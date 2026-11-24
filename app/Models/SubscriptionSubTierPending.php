<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionSubTierPending extends Model
{
    use HasFactory;

    protected $table = 'subscription_sub_tiers_pendings';

    protected $fillable = [
        'subscription_tier_id',
        'subscription_sub_tier_id',
        'name',
        'slug',
        'description',
        'action_type',
        'inputer_id',
        'authorizer_id',
        'status',
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
}
