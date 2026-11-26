<?php

namespace App\Mail;

use App\Models\StudentVerificationRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentVerificationAdminAlert extends Mailable
{
    use Queueable, SerializesModels;

    public StudentVerificationRequest $verification;
    public User $admin;

    public function __construct(StudentVerificationRequest $verification, User $admin)
    {
        $this->verification = $verification;
        $this->admin = $admin;
    }

    public function build()
    {
        $this->verification->loadMissing(['applicant', 'plan.subTier']);
        $applicantName = optional($this->verification->applicant)->name ?? 'Applicant';
        $plan = $this->verification->plan;
        $planName = optional($plan)->name ?? 'Academic Subscription';
        $subTierName = optional(optional($plan)->subTier)->name ?? $planName;
        $isComplimentary = $plan
            ? ((float) ($plan->price ?? 0) <= 0 && (float) ($plan->price_usd ?? 0) <= 0)
            : false;
        $durationText = ($plan && !empty($plan->duration)) ? "{$plan->duration} Days" : null;

        return $this->view('emails.student_verification_admin_alert')
            ->subject("New {$planName} Verification Application - {$applicantName}")
            ->with([
                'verification' => $this->verification,
                'admin' => $this->admin,
                'student' => $this->verification->applicant,
                'plan' => $plan,
                'planName' => $planName,
                'subTierName' => $subTierName,
                'isComplimentary' => $isComplimentary,
                'durationText' => $durationText,
                'reviewUrl' => route('studentVerification.index'),
            ]);
    }
}
