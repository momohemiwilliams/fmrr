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
        $studentName = optional($this->verification->applicant)->name ?? 'Student';

        return $this->view('emails.student_verification_admin_alert')
            ->subject("New Student Research Application - {$studentName}")
            ->with([
                'verification' => $this->verification,
                'admin' => $this->admin,
                'student' => $this->verification->applicant,
                'reviewUrl' => route('studentVerification.index'),
            ]);
    }
}
