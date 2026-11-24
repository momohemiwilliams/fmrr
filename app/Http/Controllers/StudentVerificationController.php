<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\SubscriptionSubTier;
use App\Models\StudentVerificationRequest;
use App\Mail\StudentVerificationAdminAlert;
use App\Mail\StudentApplicationSubmitted;
use App\Mail\StudentApplicationApproved;
use App\Mail\StudentApplicationRejected;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LogActivity;

class StudentVerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if ($user && ($user->hasRole('Portal Admin') || $user->can('student-verification-list'))) {
                return $next($request);
            }
            abort(403, 'Unauthorized action. Portal Admin access required.');
        })->only(['index', 'show', 'downloadProof', 'previewProof']);

        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if ($user && ($user->hasRole('Portal Admin') || $user->can('student-verification-approve'))) {
                return $next($request);
            }
            abort(403, 'Unauthorized action. Portal Admin access required.');
        })->only(['approve']);

        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if ($user && ($user->hasRole('Portal Admin') || $user->can('student-verification-reject'))) {
                return $next($request);
            }
            abort(403, 'Unauthorized action. Portal Admin access required.');
        })->only(['reject']);
    }

    public function apply(Request $request)
    {
        $user = Auth::user();
        $planId = $request->query('plan_id');
        $selectedPlan = $planId ? \App\Models\SubscriptionPlan::with('subTier')->find($planId) : null;

        if ($user->hasApprovedAcademicVerification()) {
            return redirect()->route('subscribe')->with('info', 'Your academic onboarding profile and affiliation have already been verified and approved. You may proceed directly to subscribe.');
        }

        $hasPending = StudentVerificationRequest::where('user_id', $user->id)->where('status', 0)->exists();
        if ($hasPending) {
            return redirect()->route('subscribe')->with('error', 'You already have an active academic onboarding and verification request awaiting administrator review.');
        }

        $academicTier = \App\Models\SubscriptionTier::where('name', 'Academic Subscription')->first();
        $academicPlans = \App\Models\SubscriptionPlan::whereHas('subTier', function ($q) use ($academicTier) {
            if ($academicTier) {
                $q->where('subscription_tier_id', $academicTier->id);
            }
            $q->orWhere('name', 'like', '%Academic%')
              ->orWhere('name', 'like', '%Student%');
        })->where('status', 1)->get();

        return view('student_verification.apply', compact('selectedPlan', 'academicPlans'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'institution_name' => 'required|string|max:255',
            'faculty_department' => 'required|string|max:255',
            'role_within_institution' => 'required|string|max:100',
            'institutional_email' => [
                'required',
                'email',
                'max:255',
                \Illuminate\Validation\Rule::unique('users', 'email')->ignore($user->id),
            ],
            'student_id_number' => 'nullable|string|max:100',
            'subscription_plan_id' => 'nullable|exists:subscription_plans,id',
            'proof' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'institution_name.required' => 'Please provide the name of your Academic Institution.',
            'faculty_department.required' => 'Please provide your Faculty and Department within the institution.',
            'role_within_institution.required' => 'Please select your academic role within the institution.',
            'institutional_email.required' => 'Please provide your official institutional (.edu) email address.',
            'institutional_email.email' => 'Please provide a valid institutional email address.',
            'institutional_email.unique' => 'This institutional email address is already associated with another account.',
            'proof.required' => 'Please upload a valid means of identification (Institutional ID, Faculty Card, Student ID, or official academic letter).',
            'proof.mimes' => 'The uploaded proof file must be a PDF, JPG, JPEG, or PNG document.',
            'proof.file' => 'The uploaded proof file must be a valid document or image.',
            'proof.max' => 'The uploaded file exceeds the maximum allowed size of 5MB. Please upload a smaller file.',
            'proof.uploaded' => 'The uploaded file exceeds the maximum allowed upload limit (5MB). Please upload a file smaller than 5MB.',
        ]);

        // Resolve plan
        $planId = $request->subscription_plan_id;
        if (!$planId) {
            $studentResearchSubTier = SubscriptionSubTier::where('name', 'Student Research')->first();
            $plan = $studentResearchSubTier ? $studentResearchSubTier->plans()->where('status', 1)->first() : null;
            $planId = $plan?->id;
        }

        $path = $request->file('proof')->store('student_verifications/' . $user->id, 'local');

        $verification = new StudentVerificationRequest();
        $verification->user_id = $user->id;
        $verification->institution_name = $request->institution_name;
        $verification->faculty_department = $request->faculty_department;
        $verification->role_within_institution = $request->role_within_institution;
        $verification->institutional_email = strtolower(trim($request->institutional_email));
        $verification->student_id_number = $request->student_id_number;
        $verification->proof_path = $path;
        $verification->subscription_plan_id = $planId;
        $verification->status = 0;
        $verification->save();

        LogActivity::addToLog('Academic onboarding & affiliation verification request submitted by ' . $user->name);

        // 1. Send confirmation email to the applicant
        $this->notifyStudentSubmission($verification, $user);

        // 2. Send email notification to all Portal Admins
        $this->notifyPortalAdmins($verification);

        return redirect()->route('subscribe')->with('success', 'Your academic onboarding profile and verification request has been submitted and is awaiting administrative review. A confirmation email has been sent to your inbox.');
    }

    public function index(Request $request)
    {
        $stats = [
            'total' => StudentVerificationRequest::count(),
            'pending' => StudentVerificationRequest::where('status', 0)->count(),
            'approved' => StudentVerificationRequest::where('status', 1)->count(),
            'rejected' => StudentVerificationRequest::where('status', 2)->count(),
        ];

        $query = StudentVerificationRequest::with(['applicant', 'reviewer', 'subscription', 'plan'])->orderBy('created_at', 'desc');

        if ($request->has('status') && $request->status !== '' && $request->status !== 'all') {
            $query->where('status', (int) $request->status);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('institution_name', 'like', "%{$search}%")
                  ->orWhere('faculty_department', 'like', "%{$search}%")
                  ->orWhere('role_within_institution', 'like', "%{$search}%")
                  ->orWhere('institutional_email', 'like', "%{$search}%")
                  ->orWhere('student_id_number', 'like', "%{$search}%")
                  ->orWhereHas('applicant', function ($userQ) use ($search) {
                      $userQ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $data = $query->paginate(15)->withQueryString();

        return view('student_verification.index', compact('data', 'stats'));
    }

    public function show($id)
    {
        $verification = StudentVerificationRequest::with(['applicant', 'reviewer', 'subscription', 'plan'])->findOrFail($id);

        return view('student_verification.show', compact('verification'));
    }

    public function approve($id)
    {
        $verification = StudentVerificationRequest::with(['applicant', 'plan'])->findOrFail($id);

        if ($verification->status != 0) {
            return redirect()->back()->with('error', 'This application has already been decided.');
        }

        $plan = $verification->plan;
        if (!$plan && $verification->subscription_plan_id) {
            $plan = \App\Models\SubscriptionPlan::find($verification->subscription_plan_id);
        }

        try {
            return DB::transaction(function () use ($verification, $plan) {
                // If the target plan is complimentary (price <= 0), automatically activate the subscription grant
                if ($plan && (float) $plan->price <= 0 && (float) ($plan->price_usd ?? 0) <= 0) {
                    $subscription = new Subscription();
                    $subscription->user_id = $verification->user_id;
                    $subscription->subscription_plan_id = $plan->id;
                    $subscription->start_date = Carbon::now();
                    $subscription->end_date = Carbon::now()->addDays($plan->duration ?: 30);
                    $subscription->status = 1;
                    $subscription->save();

                    $verification->subscription_id = $subscription->id;
                }

                $verification->status = 1;
                $verification->reviewer_id = Auth::id();
                $verification->save();

                $applicant = $verification->applicant;
                if ($applicant) {
                    // Mandatory transition/update of account registration to verified institutional email address
                    if (!empty($verification->institutional_email) && strtolower(trim($verification->institutional_email)) !== strtolower(trim($applicant->email))) {
                        $newEmail = strtolower(trim($verification->institutional_email));
                        $isEmailTaken = User::where('email', $newEmail)->where('id', '!=', $applicant->id)->exists();
                        if (!$isEmailTaken) {
                            $oldEmail = $applicant->email;
                            $applicant->email = $newEmail;
                            $applicant->email_verified_at = Carbon::now();
                            LogActivity::addToLog("Account registration email for {$applicant->name} transitioned from {$oldEmail} to verified institutional email {$newEmail} upon academic confirmation.");
                        } else {
                            Log::warning("Could not transition account email for user #{$applicant->id} to {$newEmail} because it is already taken by another account.");
                        }
                    }

                    if (!empty($verification->institution_name)) {
                        $applicant->company_name = $verification->institution_name;
                    }
                    $applicant->save();
                }

                $applicantName = $applicant ? $applicant->name : 'Applicant #' . $verification->user_id;
                LogActivity::addToLog('Academic affiliation application for ' . $applicantName . ' approved by ' . Auth::user()->name);

                if ($applicant && !empty($applicant->email)) {
                    try {
                        Mail::to($applicant->email)->send(new StudentApplicationApproved($verification, $applicant, $verification->subscription));
                    } catch (\Exception $e) {
                        Log::error('Failed to send academic approval email: ' . $e->getMessage());
                    }
                }

                $msg = ($plan && (float) $plan->price <= 0)
                    ? 'Academic application approved! Complimentary access has been activated and notification email sent.'
                    : 'Academic affiliation verified and approved! The applicant is now authorized to subscribe to the academic subscription tier.';

                return redirect()->back()->with('success', $msg);
            });
        } catch (\Exception $e) {
            Log::error('Academic verification approval failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $this->validate($request, ['note' => 'required|string|min:3|max:1000']);

        $verification = StudentVerificationRequest::with('applicant')->findOrFail($id);

        if ($verification->status != 0) {
            return redirect()->back()->with('error', 'This application has already been decided.');
        }

        $verification->status = 2;
        $verification->reviewer_id = Auth::id();
        $verification->note = $request->note;
        $verification->save();

        $applicant = $verification->applicant;
        $applicantName = $applicant ? $applicant->name : 'Student #' . $verification->user_id;
        LogActivity::addToLog('Student Research application for ' . $applicantName . ' rejected by ' . Auth::user()->name);

        if ($applicant && !empty($applicant->email)) {
            try {
                Mail::to($applicant->email)->send(new StudentApplicationRejected($verification, $applicant, $request->note));
            } catch (\Exception $e) {
                Log::error('Failed to send student verification rejection email: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Application rejected. An email with your feedback has been sent to the student.');
    }

    public function previewProof($id)
    {
        $verification = StudentVerificationRequest::findOrFail($id);

        if (!Storage::disk('local')->exists($verification->proof_path)) {
            return redirect()->back()->with('error', 'Proof file not found on server.');
        }

        $file = Storage::disk('local')->get($verification->proof_path);
        $mime = Storage::disk('local')->mimeType($verification->proof_path) ?: 'application/octet-stream';

        return response($file, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . basename($verification->proof_path) . '"',
        ]);
    }

    public function downloadProof($id)
    {
        $verification = StudentVerificationRequest::findOrFail($id);

        if (!Storage::disk('local')->exists($verification->proof_path)) {
            return redirect()->back()->with('error', 'Proof file not found.');
        }

        return Storage::disk('local')->download($verification->proof_path);
    }

    private function notifyPortalAdmins(StudentVerificationRequest $verification): void
    {
        try {
            $verification->loadMissing('applicant');

            // Find all active users with role Portal Admin, Super Admin, or permission student-verification-list
            $admins = User::where('status', 1)
                ->where(function ($query) {
                    $query->whereHas('roles', function ($q) {
                        $q->whereIn('name', ['Portal Admin', 'Super Admin']);
                    })->orWhereHas('permissions', function ($q) {
                        $q->where('name', 'student-verification-list');
                    });
                })
                ->get();

            $sentEmails = [];
            foreach ($admins as $admin) {
                if (!empty($admin->email) && !in_array($admin->email, $sentEmails)) {
                    try {
                        Mail::to($admin->email)->send(new StudentVerificationAdminAlert($verification, $admin));
                        $sentEmails[] = $admin->email;
                    } catch (\Exception $mailEx) {
                        Log::error('Failed sending student verification alert to ' . $admin->email . ': ' . $mailEx->getMessage());
                    }
                }
            }

            // Fallback to configured FEEDBACK_RECIPIENTS if no admins found
            $fallbackRecipients = env('FEEDBACK_RECIPIENTS');
            if (empty($sentEmails) && !empty($fallbackRecipients)) {
                $dummyAdmin = new User();
                $dummyAdmin->name = 'Administrator';
                $dummyAdmin->email = $fallbackRecipients;
                try {
                    Mail::to($fallbackRecipients)->send(new StudentVerificationAdminAlert($verification, $dummyAdmin));
                } catch (\Exception $mailEx) {
                    Log::error('Failed sending student verification alert to fallback ' . $fallbackRecipients . ': ' . $mailEx->getMessage());
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to notify portal admins of student verification: ' . $e->getMessage());
        }
    }

    private function notifyStudentSubmission(StudentVerificationRequest $verification, User $student): void
    {
        try {
            if (!empty($student->email)) {
                Mail::to($student->email)->send(new StudentApplicationSubmitted($verification, $student));
            }
        } catch (\Exception $e) {
            Log::error('Failed to notify student of application submission: ' . $e->getMessage());
        }
    }
}
