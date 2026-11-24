<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\InstitutionalSubscriptionMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Helpers\LogActivity;

class InstitutionalSubscriptionMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function ownerSubscription($user)
    {
        return Subscription::with('subscriptionPlan')
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->where('end_date', '>=', Carbon::now())
            ->whereHas('subscriptionPlan', function ($query) {
                $query->where('seat_limit', '>', 1)
                      ->orWhere('name', 'like', '%Institutional Academic%');
            })
            ->latest('end_date')
            ->first();
    }

    public function index()
    {
        $user = Auth::user();
        $subscription = $this->ownerSubscription($user);

        if (!$subscription) {
            return redirect()->route('profile')->with('error', 'You do not have an active team-eligible subscription.');
        }

        $members = InstitutionalSubscriptionMember::with('member')
            ->where('owner_subscription_id', $subscription->id)
            ->where('status', InstitutionalSubscriptionMember::STATUS_ACTIVE)
            ->orderBy('created_at', 'desc')
            ->get();

        $planSeatLimit = (int) ($subscription->subscriptionPlan->seat_limit ?? 0);
        // Default to 6 total seats (1 primary owner + up to 5 additional team members) for Institutional Academic plans
        $seatLimit = $planSeatLimit > 1 ? $planSeatLimit : 6;
        $seatsUsed = $members->count() + 1; // +1 for the owner's own seat

        return view('institutional_members.index', compact('subscription', 'members', 'seatLimit', 'seatsUsed'));
    }

    public function checkUser(Request $request)
    {
        $email = trim($request->input('email', ''));

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'exists' => false,
                'status' => 'invalid_email',
                'message' => 'Please enter a valid email format.'
            ]);
        }

        $currentUser = Auth::user();
        $targetUser = User::where('email', $email)->first();

        if (!$targetUser) {
            return response()->json([
                'exists' => false,
                'status' => 'not_found',
                'message' => 'No registered account found with this email. The member must create a free FMRR Portal account first.'
            ]);
        }

        if ($targetUser->id === $currentUser->id) {
            return response()->json([
                'exists' => false,
                'status' => 'is_owner',
                'message' => 'You cannot add yourself; you are already the primary account holder.'
            ]);
        }

        $subscription = $this->ownerSubscription($currentUser);
        if ($subscription) {
            $alreadyMember = InstitutionalSubscriptionMember::where('owner_subscription_id', $subscription->id)
                ->where('member_user_id', $targetUser->id)
                ->where('status', InstitutionalSubscriptionMember::STATUS_ACTIVE)
                ->exists();

            if ($alreadyMember) {
                return response()->json([
                    'exists' => false,
                    'status' => 'already_member',
                    'message' => 'This user has already been added to your institutional subscription.'
                ]);
            }
        }

        return response()->json([
            'exists' => true,
            'status' => 'valid',
            'user_name' => $targetUser->name,
            'user_email' => $targetUser->email,
            'message' => 'Registered user verified: ' . $targetUser->name
        ]);
    }

    public function invite(Request $request)
    {
        $user = Auth::user();
        $subscription = $this->ownerSubscription($user);

        if (!$subscription) {
            return redirect()->route('profile')->with('error', 'You do not have an active team-eligible subscription.');
        }

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users,email'],
            'role' => ['required', 'string', 'max:100'],
            'faculty' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'function' => ['required', 'string', 'max:255'],
        ], [
            'email.exists' => 'No registered user was found with this email. They must create an FMRR Portal account first.',
            'role.required' => 'Please configure the institutional role for this member.',
            'faculty.required' => 'Please configure the academic faculty for this member.',
            'department.required' => 'Please configure the academic department for this member.',
            'function.required' => 'Please configure the academic or institutional function for this member.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $planSeatLimit = (int) ($subscription->subscriptionPlan->seat_limit ?? 0);
        $seatLimit = $planSeatLimit > 1 ? $planSeatLimit : 6;
        $activeCount = InstitutionalSubscriptionMember::where('owner_subscription_id', $subscription->id)
            ->where('status', InstitutionalSubscriptionMember::STATUS_ACTIVE)
            ->count();

        if ($activeCount + 1 >= $seatLimit) {
            return redirect()->back()->with('error', 'All ' . ($seatLimit - 1) . ' additional member seats on this subscription have been used.');
        }

        $newMember = User::where('email', $request->email)->first();

        if ($newMember->id == $user->id) {
            return redirect()->back()->with('error', 'You are already the owner of this subscription.');
        }

        $exists = InstitutionalSubscriptionMember::where('owner_subscription_id', $subscription->id)
            ->where('member_user_id', $newMember->id)
            ->where('status', InstitutionalSubscriptionMember::STATUS_ACTIVE)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'This user has already been added to your team.');
        }

        try {
            return DB::transaction(function () use ($user, $subscription, $newMember, $request) {
                $seat = new Subscription();
                $seat->user_id = $newMember->id;
                $seat->subscription_plan_id = $subscription->subscription_plan_id;
                $seat->start_date = Carbon::now();
                $seat->end_date = $subscription->end_date;
                $seat->status = 1;
                $seat->save();

                $member = new InstitutionalSubscriptionMember();
                $member->owner_subscription_id = $subscription->id;
                $member->owner_user_id = $user->id;
                $member->email = $newMember->email;
                $member->member_user_id = $newMember->id;
                $member->member_subscription_id = $seat->id;
                $member->role = $request->role;
                $member->faculty = $request->faculty;
                $member->department = $request->department;
                $member->function = $request->function;
                $member->status = InstitutionalSubscriptionMember::STATUS_ACTIVE;
                $member->save();

                $this->notifyGrantedAccess($newMember->email, $user->name, $subscription->subscriptionPlan->name);

                LogActivity::addToLog('Team member (' . $newMember->email . ') with role ' . $request->role . ' added by ' . $user->name);

                return redirect()->back()->with('success', 'Team member (' . $newMember->email . ') has been added and profiled successfully. Seat allocation updated.');
            });
        } catch (\Exception $e) {
            Log::error('Institutional member add failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function updateProfile(Request $request, $id)
    {
        $user = Auth::user();
        $subscription = $this->ownerSubscription($user);

        if (!$subscription) {
            return redirect()->route('profile')->with('error', 'You do not have an active team-eligible subscription.');
        }

        $member = InstitutionalSubscriptionMember::where('owner_subscription_id', $subscription->id)
            ->where('status', InstitutionalSubscriptionMember::STATUS_ACTIVE)
            ->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'role' => ['required', 'string', 'max:100'],
            'faculty' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'function' => ['required', 'string', 'max:255'],
        ], [
            'role.required' => 'Please specify the institutional role.',
            'faculty.required' => 'Please specify the academic faculty.',
            'department.required' => 'Please specify the academic department.',
            'function.required' => 'Please specify the academic or institutional function.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $member->role = $request->role;
        $member->faculty = $request->faculty;
        $member->department = $request->department;
        $member->function = $request->function;
        $member->save();

        LogActivity::addToLog('Team member (' . $member->email . ') profile updated by ' . $user->name);

        return redirect()->back()->with('success', 'Profile for team member (' . $member->email . ') has been configured successfully.');
    }

    public function remove(Request $request, $id)
    {
        $user = Auth::user();
        $subscription = $this->ownerSubscription($user);

        if (!$subscription) {
            return redirect()->route('profile')->with('error', 'You do not have an active team-eligible subscription.');
        }

        $member = InstitutionalSubscriptionMember::where('owner_subscription_id', $subscription->id)->findOrFail($id);

        try {
            return DB::transaction(function () use ($member, $user) {
                $member->status = InstitutionalSubscriptionMember::STATUS_REMOVED;
                $member->save();

                if ($member->member_subscription_id) {
                    Subscription::where('id', $member->member_subscription_id)->update([
                        'status' => 0,
                        'end_date' => Carbon::now(),
                    ]);
                }

                LogActivity::addToLog('Team member (' . $member->email . ') removed by ' . $user->name);

                return redirect()->back()->with('success', 'Team member (' . $member->email . ') has been removed successfully. 1 seat has been freed up.');
            });
        } catch (\Exception $e) {
            Log::error('Institutional member removal failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    private function notifyGrantedAccess($email, $ownerName, $planName)
    {
        try {
            Mail::to($email)->queue(new \App\Mail\NotifyUser([
                'email' => $email,
                'title' => $ownerName . ' has granted you access to the FMRR Portal via their ' . $planName . ' subscription.',
                'action' => 'Institutional Subscription Access',
            ]));
        } catch (\Exception $e) {
            Log::error('Failed to queue institutional member access email', ['error' => $e->getMessage()]);
        }
    }
}
