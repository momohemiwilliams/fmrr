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
        return $this->view('emails.student_application_rejected')
            ->subject('Update on Your Student Research Access Application')
            ->with([
                'verification' => $this->verification,
                'student' => $this->student,
                'reason' => $this->reason,
                'reapplyUrl' => route('studentVerification.apply'),
            ]);
    }
}
