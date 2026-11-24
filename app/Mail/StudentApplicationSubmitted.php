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
        return $this->view('emails.student_application_submitted')
            ->subject('Student Research Access Application Received')
            ->with([
                'verification' => $this->verification,
                'student' => $this->student,
            ]);
    }
}
