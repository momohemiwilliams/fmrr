<?php

namespace App\Mail;

use App\Models\StudentVerificationRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentApplicationSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public StudentVerificationRequest $verification;
    public User $student;

    public function __construct(StudentVerificationRequest $verification, User $student)
    {
        $this->verification = $verification;
        $this->student = $student;
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
        $durationText = ($plan && !empty($plan->duration)) ? "{$plan->duration} Days" : null;

        return $this->view('emails.student_application_submitted')
            ->subject("{$planName} Application Received")
            ->with([
                'verification' => $this->verification,
                'student' => $this->student,
                'plan' => $plan,
                'planName' => $planName,
                'subTierName' => $subTierName,
                'isComplimentary' => $isComplimentary,
                'durationText' => $durationText,
            ]);
    }
}
