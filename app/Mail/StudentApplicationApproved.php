<?php

namespace App\Mail;

use App\Models\StudentVerificationRequest;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentApplicationApproved extends Mailable
{
    use Queueable, SerializesModels;

    public StudentVerificationRequest $verification;
    public User $student;
    public ?Subscription $subscription;

    public function __construct(StudentVerificationRequest $verification, User $student, ?Subscription $subscription = null)
    {
        $this->verification = $verification;
        $this->student = $student;
        $this->subscription = $subscription;
    }

    public function build()
    {
        $subject = $this->subscription 
            ? 'Congratulations! Your Student Research Access Has Been Approved'
            : 'Congratulations! Your Academic Affiliation Has Been Verified & Approved';

        return $this->view('emails.student_application_approved')
            ->subject($subject)
            ->with([
                'verification' => $this->verification,
                'student' => $this->student,
                'subscription' => $this->subscription,
                'loginUrl' => url('/login'),
            ]);
    }
}
