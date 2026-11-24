<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionSubTier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'subscription_tier_id',
        'description',
        'status',
        'admin_status',
        'note',
        'group_id',
        'is_promotional',
        'promo_tab_title',
        'promo_badge',
        'discount_percentage',
        'promo_features',
        'promo_start_at',
        'promo_end_at',
    ];

    protected $casts = [
        'is_promotional' => 'boolean',
        'discount_percentage' => 'float',
        'promo_start_at' => 'datetime',
        'promo_end_at' => 'datetime',
    ];

    public function tier()
    {
        return $this->belongsTo(SubscriptionTier::class, 'subscription_tier_id');
    }

    public function plans()
    {
        return $this->hasMany(SubscriptionPlan::class, 'subscription_sub_tier_id');
    }

    public function isPromoActive(): bool
    {
        if (!$this->is_promotional) {
            return false;
        }

        $now = \Carbon\Carbon::now();
        if ($this->promo_start_at && $now->lt($this->promo_start_at)) {
            return false;
        }
        if ($this->promo_end_at && $now->gt($this->promo_end_at)) {
            return false;
        }

        return true;
    }

    public function getPromoFeaturesListAttribute(): array
    {
        if (empty($this->promo_features)) {
            return [];
        }
        if (is_array($this->promo_features)) {
            return $this->promo_features;
        }
        $decoded = json_decode($this->promo_features, true);
        if (is_array($decoded)) {
            return $decoded;
        }
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $this->promo_features))));
    }

    public function getPromoStatusAttribute(): string
    {
        if (!$this->is_promotional) {
            return 'inactive';
        }
        $now = \Carbon\Carbon::now();
        if ($this->promo_start_at && $now->lt($this->promo_start_at)) {
            return 'scheduled';
        }
        if ($this->promo_end_at && $now->gt($this->promo_end_at)) {
            return 'expired';
        }
        return 'active';
    }

    /**
     * Determine if this sub-tier requires verified academic affiliation.
     */
    public function requiresAcademicVerification(): bool
    {
        $subTierName = strtolower($this->name ?? '');
        if (str_contains($subTierName, 'academic') || str_contains($subTierName, 'student')) {
            return true;
        }

        $tier = $this->tier;
        return $tier && str_contains(strtolower($tier->name ?? ''), 'academic');
    }
}
