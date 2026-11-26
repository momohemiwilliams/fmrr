<?php

namespace App\Mail;

use App\Models\StudentVerificationRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentApplicationRejected extends Mailable
{
    use Queueable, SerializesModels;

    public StudentVerificationRequest $verification;
    public User $student;
    public string $reason;

    public function __construct(StudentVerificationRequest $verification, User $student, string $reason)
    {
        $this->verification = $verification;
        $this->student = $student;
        $this->reason = $reason;
    }

    public function build()
    {
        $this->verification->loadMissing(['plan.subTier']);
        $plan = $this->verification->plan;
        $planName = optional($plan)->name ?? 'Academic Subscription';
        $subTierName = optional(optional($plan)->subTier)->name ?? $planName;
        $isComplimentary = $plan
            ? ((float) ($plan->price ?? 0) <= 0 && (float) ($plan->price_usd ?? 0) <= 0)
            : false;

        $reapplyUrl = $this->verification->subscription_plan_id
            ? route('studentVerification.apply', ['plan_id' => $this->verification->subscription_plan_id])
            : route('studentVerification.apply');

        return $this->view('emails.student_application_rejected')
            ->subject("Update on Your {$planName} Application")
            ->with([
                'verification' => $this->verification,
                'student' => $this->student,
                'reason' => $this->reason,
                'plan' => $plan,
                'planName' => $planName,
                'subTierName' => $subTierName,
                'isComplimentary' => $isComplimentary,
                'reapplyUrl' => $reapplyUrl,
            ]);
    }
}
