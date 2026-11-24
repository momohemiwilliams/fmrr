<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'usertype',
        'company_name',
        'group_id',
        'status',
        'admin_group'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }


    public function verifyUser()
    {
        return $this->hasOne(VerifyUser::class);
    }


    public function savedDocuments()
    {
        return $this->belongsToMany(Regulation::class, 'saved_documents');
    }



    public function downloads()
    {
        return $this->hasMany(Download::class);
    }



    public function inputtedRegulations()
    {
        return $this->hasMany(DocumentApproval::class, 'inputter_id');
    }

    public function authorisedRegulations()
    {
        return $this->hasMany(DocumentApproval::class, 'authoriser_id');
    }


    public function passwordHistories()
    {
        return $this->hasMany(PasswordHistory::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function studentVerificationRequests()
    {
        return $this->hasMany(StudentVerificationRequest::class, 'user_id');
    }

    /**
     * Get the disclaimer acceptance record for the user.
     */
    public function disclaimerAcceptance()
    {
        return $this->hasOne(DisclaimerAcceptance::class);
    }

    /**
     * Get the current active subscription for the user.
     */
    public function activeSubscription()
    {
        return $this->subscriptions()
            ->where('status', 1)
            ->where('end_date', '>=', now())
            ->with(['subscriptionPlan.subTier'])
            ->latest('end_date')
            ->first();
    }

    /**
     * Check if the user is a verified student with active access.
     */
    public function isVerifiedStudent(): bool
    {
        return $this->studentVerificationRequests()
            ->where('status', 1)
            ->whereHas('subscription', function ($query) {
                $query->where('status', 1)->where('end_date', '>=', now());
            })
            ->exists();
    }

    /**
     * Check if the user is a view-only subscriber (e.g. Student Research).
     */
    public function isViewOnlySubscriber(): bool
    {
        if ($this->usertype === 'internal') {
            return false;
        }

        if ($this->isVerifiedStudent()) {
            return true;
        }

        $activeSub = $this->activeSubscription();
        if ($activeSub) {
            return $activeSub->isViewOnly() || !$activeSub->canDownload();
        }

        return false;
    }

    /**
     * Check if the user is permitted to download regulations.
     */
    public function canDownloadDocuments(): bool
    {
        if ($this->usertype === 'internal') {
            return true;
        }

        if ($this->isViewOnlySubscriber()) {
            return false;
        }

        $activeSub = $this->activeSubscription();
        return $activeSub ? $activeSub->canDownload() : false;
    }

    /**
     * Check if the user has an active institutional educational email address.
     * Validates domains ending in .edu, .edu.xx, .ac.xx, .sch.xx, etc.
     */
    public function hasAcademicEmailDomain(): bool
    {
        if (empty($this->email)) {
            return false;
        }

        return (bool) preg_match('/(@|\\.)([a-z0-9\\-]+\\.)*(edu(\\.[a-z]{2,})?|ac\\.[a-z]{2,}|sch\\.[a-z]{2,})$/i', strtolower(trim($this->email)));
    }

    /**
     * Check if the user has an administrator-approved academic verification on file.
     */
    public function hasApprovedAcademicVerification(): bool
    {
        return $this->studentVerificationRequests()
            ->where('status', 1)
            ->exists();
    }

    /**
     * Check if the user has a pending academic verification awaiting review.
     */
    public function hasPendingAcademicVerification(): bool
    {
        return $this->studentVerificationRequests()
            ->where('status', 0)
            ->exists();
    }

    /**
     * Check if the user has verified academic affiliation (via approved academic onboarding).
     */
    public function hasVerifiedAcademicAffiliation(): bool
    {
        return $this->hasApprovedAcademicVerification();
    }

    /**
     * Get the academic verification status string.
     */
    public function getAcademicVerificationStatus(): string
    {
        if ($this->hasApprovedAcademicVerification()) {
            return 'admin_verified';
        }

        if ($this->hasPendingAcademicVerification()) {
            return 'pending';
        }

        return 'unverified';
    }
}
