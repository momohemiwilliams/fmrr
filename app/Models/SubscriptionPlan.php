<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'price_usd',
        'discount_percentage',
        'duration',
        'description',
        'status',
        'seat_limit',
        'subscription_sub_tier_id',
    ];

    protected $casts = [
        'price' => 'float',
        'price_usd' => 'float',
        'discount_percentage' => 'float',
    ];

    public function subTier()
    {
        return $this->belongsTo(SubscriptionSubTier::class, 'subscription_sub_tier_id');
    }

    public function subscriptionSubTier()
    {
        return $this->belongsTo(SubscriptionSubTier::class, 'subscription_sub_tier_id');
    }

    /**
     * Get the active discount percentage applied to this plan (if promotion is currently active).
     */
    public function getActiveDiscountPercentage(): float
    {
        $subTier = $this->subTier ?? $this->subscriptionSubTier;

        // 1. Direct plan discount if active
        if (!is_null($this->discount_percentage) && (float) $this->discount_percentage > 0) {
            if ($subTier && $subTier->isPromoActive()) {
                return (float) $this->discount_percentage;
            }
            if ($subTier && $subTier->tier && $subTier->tier->isPromoActive()) {
                return (float) $this->discount_percentage;
            }
            if (!$subTier) {
                return (float) $this->discount_percentage;
            }
        }

        // 2. Sub-Tier discount
        if ($subTier && $subTier->isPromoActive()) {
            if (!is_null($subTier->discount_percentage) && (float) $subTier->discount_percentage > 0) {
                return (float) $subTier->discount_percentage;
            }
            // Smart fallback: parse percentage from badge e.g. "50% Off First 3 Months" or "20% Off"
            if (!empty($subTier->promo_badge) && preg_match('/(\d+(?:\.\d+)?)\s*%\s*(?:off)?/i', $subTier->promo_badge, $matches)) {
                return (float) $matches[1];
            }
        }

        // 3. Parent Tier discount
        if ($subTier && $subTier->tier && $subTier->tier->isPromoActive()) {
            if (!is_null($subTier->tier->discount_percentage) && (float) $subTier->tier->discount_percentage > 0) {
                return (float) $subTier->tier->discount_percentage;
            }
            // Smart fallback: parse percentage from badge e.g. "50% Off First 3 Months" or "20% Off"
            if (!empty($subTier->tier->promo_badge) && preg_match('/(\d+(?:\.\d+)?)\s*%\s*(?:off)?/i', $subTier->tier->promo_badge, $matches)) {
                return (float) $matches[1];
            }
        }

        return 0.0;
    }

    /**
     * Check if this plan has an active dynamic discount.
     */
    public function hasActiveDiscount(): bool
    {
        return $this->getActiveDiscountPercentage() > 0;
    }

    /**
     * Get the base (undiscounted) price for the given currency.
     */
    public function getBasePrice(string $currency = 'NGN'): float
    {
        return strtoupper($currency) === 'USD' ? (float) ($this->price_usd ?? 0) : (float) ($this->price ?? 0);
    }

    /**
     * Get the dynamically calculated discounted price for the given currency.
     */
    public function getDiscountedPrice(string $currency = 'NGN'): float
    {
        $base = $this->getBasePrice($currency);
        $percent = $this->getActiveDiscountPercentage();

        if ($percent > 0 && $base > 0) {
            $discount = ($base * $percent) / 100.0;
            return max(0.0, round($base - $discount, 2));
        }

        return round($base, 2);
    }

    /**
     * Get the absolute discount amount saved.
     */
    public function getDiscountSavings(string $currency = 'NGN'): float
    {
        $base = $this->getBasePrice($currency);
        $percent = $this->getActiveDiscountPercentage();

        if ($percent > 0 && $base > 0) {
            return round(($base * $percent) / 100.0, 2);
        }

        return 0.0;
    }

    /**
     * Determine if this plan requires verified academic affiliation.
     */
    public function requiresAcademicVerification(): bool
    {
        $subTier = $this->subTier ?? $this->subscriptionSubTier;
        if ($subTier) {
            $subTierName = strtolower($subTier->name ?? '');
            if (str_contains($subTierName, 'academic') || str_contains($subTierName, 'student')) {
                return true;
            }

            $tier = $subTier->tier;
            if ($tier && str_contains(strtolower($tier->name ?? ''), 'academic')) {
                return true;
            }
        }

        $planName = strtolower($this->name ?? '');
        return str_contains($planName, 'academic') || str_contains($planName, 'student');
    }
}
