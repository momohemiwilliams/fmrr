@php
    $isComplimentary = (float) $package->price <= 0 && (float) ($package->price_usd ?? 0) <= 0;
    $isCurrentPlan = false;
    $user = \Illuminate\Support\Facades\Auth::user();
    $requiresAcademicVerification = $package->requiresAcademicVerification();
    $isAcademicVerified = false;
    $isAcademicPending = false;
    $hasAcademicDomain = false;

    if ($user) {
        $isCurrentPlan = \App\Models\Subscription::where('user_id', $user->id)
            ->where('subscription_plan_id', $package->id)
            ->where('status', 1)
            ->where('end_date', '>=', \Carbon\Carbon::now())
            ->exists();

        if ($requiresAcademicVerification) {
            $hasAcademicDomain = $user->hasAcademicEmailDomain();
            $isAcademicVerified = $user->hasVerifiedAcademicAffiliation();
            $isAcademicPending = $user->hasPendingAcademicVerification();
        }
    }

    $hasDiscount = $package->hasActiveDiscount();
    $discountPercent = $hasDiscount ? $package->getActiveDiscountPercentage() : 0;
    $finalPriceNgn = $package->getDiscountedPrice('NGN');
    $finalPriceUsd = $package->getDiscountedPrice('USD');
    $basePriceNgn = (float) ($package->price ?? 0);
    $basePriceUsd = (float) ($package->price_usd ?? 0);

    $activePromoSubTier = ($package->subTier && $package->subTier->isPromoActive()) ? $package->subTier : null;
    $activePromoTier = ($package->subTier && $package->subTier->tier && $package->subTier->tier->isPromoActive()) ? $package->subTier->tier : null;
    $cardPromoBadge = $activePromoSubTier ? $activePromoSubTier->promo_badge : ($activePromoTier ? $activePromoTier->promo_badge : null);
    if (empty($cardPromoBadge) && $hasDiscount) {
        $cardPromoBadge = $discountPercent . '% OFF DISCOUNT';
    }
    $cardPromoFeatures = $activePromoSubTier && !empty($activePromoSubTier->promo_features_list)
        ? $activePromoSubTier->promo_features_list
        : ($activePromoTier && !empty($activePromoTier->promo_features_list) ? $activePromoTier->promo_features_list : []);
    $isPromotionalCard = !empty($cardPromoBadge) || !empty($cardPromoFeatures) || $hasDiscount;
@endphp
<div class="plan-card {{ ($highlight ?? false) ? 'highlighted' : '' }} {{ $isCurrentPlan ? 'active-user-plan' : '' }} {{ $isPromotionalCard ? 'promotional-card' : '' }}">
    @if ($isCurrentPlan)
        <span class="popular-badge badge-active">
            <em class="icon ni ni-check-circle mr-1"></em> Active Plan
        </span>
    @elseif ($cardPromoBadge)
        <span class="popular-badge badge-promo">
            <em class="icon ni ni-spark mr-1"></em> {{ $cardPromoBadge }}
        </span>
    @elseif ($highlight ?? false)
        <span class="popular-badge badge-best-value">
            <em class="icon ni ni-star-fill mr-1"></em> Best Value
        </span>
    @endif
    <div class="plan-card-header">
        <span class="plan-card-title">{{ $package->name }}</span>
        <h2 class="plan-card-price" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
            @if ($isComplimentary)
                <span>Complimentary</span>
            @elseif ((float)$package->price > 0 && ($requiresAcademicVerification && !$isAcademicVerified))
                <span style="color: #f4d078; font-size: 22px; font-weight: 700;">
                    @if ($hasDiscount)
                        <s style="opacity: 0.6; font-size: 15px; color: rgba(255,255,255,0.7); margin-right: 4px;">₦{{ number_format($basePriceNgn, 2) }}</s>
                        ₦{{ number_format($finalPriceNgn, 2) }}
                    @else
                        ₦{{ number_format($package->price, 2) }}
                    @endif
                    <small style="font-size: 13px; color: rgba(255, 255, 255, 0.75); font-weight: 400;">/ {{ $package->duration }} Days</small>
                </span>
                @if(isset($package->price_usd) && $package->price_usd > 0)
                    <span style="font-size: 13px; color: rgba(255, 255, 255, 0.85); font-weight: 500; margin-top: 2px;">
                        @if ($hasDiscount)
                            <s style="opacity: 0.6; margin-right: 4px;">${{ number_format($basePriceUsd, 2) }}</s>
                            ${{ number_format($finalPriceUsd, 2) }}
                        @else
                            ${{ number_format($package->price_usd, 2) }}
                        @endif
                    </span>
                @endif
            @endif
        </h2>
    </div>
    <div class="plan-card-body">
        @if ($package->description && strcasecmp(trim($package->description), trim($package->name)) !== 0)
            <p style="font-size: 13px; color: rgba(255, 255, 255, 0.82); line-height: 1.5; margin-bottom: 12px;">{{ $package->description }}</p>
        @endif
        @if (!empty($cardPromoFeatures) || $hasDiscount)
            <div class="promo-perks-box">
                <div class="promo-perks-header">
                    <span class="promo-perks-pill">
                        <em class="icon ni ni-spark mr-1"></em> Special Promotion Included
                    </span>
                </div>
                <ul class="promo-perks-list">
                    @if ($hasDiscount)
                        <li class="promo-perk-item">
                            <span class="promo-perk-bullet" style="background: rgba(213, 167, 59, 0.35); color: #f4d078; border-color: rgba(213, 167, 59, 0.5);">
                                <em class="icon ni ni-percent"></em>
                            </span>
                            <span class="promo-perk-text" style="color: #f4d078; font-weight: 700;">
                                {{ $discountPercent }}% Instant Discount (Auto-Deducted at Checkout)
                            </span>
                        </li>
                    @endif
                    @foreach ($cardPromoFeatures as $pfeat)
                        <li class="promo-perk-item">
                            <span class="promo-perk-bullet">
                                <em class="icon ni ni-check"></em>
                            </span>
                            <span class="promo-perk-text">{{ $pfeat }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="plan-card-footer">
        @if ($isCurrentPlan)
            <button type="button" class="choose-button" disabled style="width: 100% !important; opacity: 0.9 !important; background: #334155 !important; color: #ffffff !important; cursor: not-allowed !important; border: 1px solid #475569 !important; display: flex !important; align-items: center !important; justify-content: center !important; gap: 6px !important; font-weight: 700 !important; border-radius: 30px !important; padding: 12px 20px !important;">
                <em class="icon ni ni-check-circle" style="font-size: 16px !important; color: #ffffff !important;"></em>
                <span style="color: #ffffff !important; font-weight: 700 !important;">Current Active Plan</span>
            </button>
            <span class="complimentary-note" style="display: block !important; margin-top: 10px !important; background: rgba(16, 185, 129, 0.2) !important; border: 1px solid rgba(16, 185, 129, 0.4) !important; color: #a7f3d0 !important; font-weight: 600 !important; border-radius: 10px !important; padding: 10px 14px !important; font-size: 12.5px !important; text-align: center !important;">
                <span style="color: #a7f3d0 !important; font-weight: 600 !important;">You are currently subscribed to this plan.</span>
            </span>
        @elseif ($requiresAcademicVerification && !$user)
            <a href="{{ route('login') }}" class="choose-button" style="width: 100% !important; display: flex !important; align-items: center !important; justify-content: center !important; gap: 8px !important; text-align: center !important; background: {{ ($highlight ?? false) ? 'linear-gradient(90deg, #f4d078, #d5a73b)' : '#ffffff' }} !important; color: #0c2b70 !important; font-weight: 700 !important; font-size: 14.5px !important; border-radius: 30px !important; padding: 12px 20px !important; text-decoration: none !important; box-shadow: 0 4px 12px rgba(0,0,0,0.2) !important;">
                <em class="icon ni ni-signin" style="font-size: 16px !important; color: #0c2b70 !important;"></em>
                <span style="color: #0c2b70 !important; font-weight: 700 !important;">Sign In to Complete Onboarding</span>
            </a>
            <span class="complimentary-note" style="display: block !important; margin-top: 12px !important; background: rgba(255, 255, 255, 0.15) !important; border: 1px solid rgba(255, 255, 255, 0.25) !important; color: #ffffff !important; border-radius: 10px !important; padding: 10px 14px !important; font-size: 12.5px !important; line-height: 1.4 !important; text-align: center !important;">
                <span style="color: #ffffff !important; font-weight: 500 !important;">
                    <em class="icon ni ni-info mr-1" style="color: #f4d078 !important;"></em> Mandatory academic onboarding and institutional verification required.
                </span>
            </span>
        @elseif ($requiresAcademicVerification && !$isAcademicVerified)
            @if ($isAcademicPending)
                <button type="button" class="choose-button" disabled style="width: 100% !important; opacity: 0.95 !important; background: #f59e0b !important; color: #ffffff !important; cursor: not-allowed !important; border: 1px solid #d97706 !important; display: flex !important; align-items: center !important; justify-content: center !important; gap: 8px !important; font-size: 14.5px !important; font-weight: 700 !important; border-radius: 30px !important; padding: 12px 20px !important; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3) !important;">
                    <em class="icon ni ni-clock" style="font-size: 16px !important; color: #ffffff !important;"></em>
                    <span style="color: #ffffff !important; font-weight: 700 !important;">Onboarding Pending Review</span>
                </button>
                <span class="complimentary-note" style="display: block !important; margin-top: 12px !important; background: rgba(245, 158, 11, 0.2) !important; border: 1px solid rgba(245, 158, 11, 0.45) !important; color: #fef3c7 !important; font-weight: 600 !important; border-radius: 10px !important; padding: 10px 14px !important; font-size: 12.5px !important; line-height: 1.4 !important; text-align: center !important;">
                    <span style="color: #fef3c7 !important; font-weight: 600 !important;">
                        Your academic onboarding profile is currently under review by FMDQ administrators.
                    </span>
                </span>
            @else
                <a href="{{ route('studentVerification.apply', ['plan_id' => $package->id]) }}" class="choose-button" style="width: 100% !important; display: flex !important; align-items: center !important; justify-content: center !important; gap: 8px !important; text-align: center !important; background: {{ ($highlight ?? false) ? 'linear-gradient(90deg, #f4d078, #d5a73b)' : '#ffffff' }} !important; color: #0c2b70 !important; font-weight: 700 !important; font-size: 14.5px !important; border-radius: 30px !important; padding: 12px 20px !important; text-decoration: none !important; box-shadow: 0 4px 12px rgba(0,0,0,0.2) !important;">
                    <em class="icon ni ni-shield-check" style="font-size: 17px !important; color: #0c2b70 !important;"></em>
                    <span style="color: #0c2b70 !important; font-weight: 700 !important;">Complete Academic Onboarding</span>
                </a>
                <span class="complimentary-note" style="display: block !important; margin-top: 12px !important; background: rgba(255, 255, 255, 0.15) !important; border: 1px solid rgba(255, 255, 255, 0.25) !important; color: #ffffff !important; border-radius: 10px !important; padding: 10px 14px !important; font-size: 12.5px !important; line-height: 1.4 !important; text-align: center !important;">
                    <span style="color: #ffffff !important; font-weight: 500 !important;">
                        Requires institutional profile, faculty/department, academic role, ID proof &amp; verified institutional email.
                    </span>
                </span>
            @endif
        @elseif ($isComplimentary)
            <a href="{{ route('studentVerification.apply', ['plan_id' => $package->id]) }}" class="choose-button" style="width: 100% !important; display: flex !important; align-items: center !important; justify-content: center !important; gap: 8px !important; text-align: center !important; background: {{ ($highlight ?? false) ? 'linear-gradient(90deg, #f4d078, #d5a73b)' : '#ffffff' }} !important; color: #0c2b70 !important; font-weight: 700 !important; font-size: 14.5px !important; border-radius: 30px !important; padding: 12px 20px !important; text-decoration: none !important; box-shadow: 0 4px 12px rgba(0,0,0,0.2) !important;">
                <span style="color: #0c2b70 !important; font-weight: 700 !important;">Apply Now</span>
            </a>
            <span class="complimentary-note" style="display: block !important; margin-top: 12px !important; background: rgba(255, 255, 255, 0.15) !important; border: 1px solid rgba(255, 255, 255, 0.25) !important; color: #ffffff !important; border-radius: 10px !important; padding: 10px 14px !important; font-size: 12.5px !important; line-height: 1.4 !important; text-align: center !important;">
                <span style="color: #ffffff !important; font-weight: 500 !important;">
                    Requires eligibility verification and FMDQ approval.
                </span>
            </span>
        @else
            @if ($requiresAcademicVerification && $isAcademicVerified)
                <div class="mb-2 text-center">
                    <span class="badge badge-dim badge-success py-1 px-3" style="font-size: 11.5px; background: rgba(16, 185, 129, 0.25) !important; color: #6ee7b7 !important; border: 1px solid #10b981 !important; font-weight: 700 !important;">
                        <em class="icon ni ni-check-circle mr-1"></em> Academic Onboarding Verified
                    </span>
                </div>
            @endif
            <form method="post" action="{{ route('subscribe_payment') }}">
                @csrf
                <input name="plan_id" type="hidden" value="{{ $package->id }}">
                @if(isset($package->price_usd) && $package->price_usd > 0)
                    <button type="submit" name="currency" value="NGN" class="choose-button mb-2" style="width: 100% !important; font-size: 14.5px !important; background: #ffffff !important; color: #0c2b70 !important; font-weight: 700 !important; border-radius: 30px !important; box-shadow: 0 4px 12px rgba(0,0,0,0.12) !important;">
                        @if ($hasDiscount)
                            <span>Pay in Naira <s style="opacity: 0.55; font-size: 12px; margin: 0 2px;">₦{{ number_format($basePriceNgn, 2) }}</s> <strong>₦{{ number_format($finalPriceNgn, 2) }}</strong> <span class="badge ml-1" style="font-size: 10px; background: #d5a73b; color: #0c2b70; padding: 2px 5px; border-radius: 4px; font-weight: 700;">-{{ $discountPercent }}%</span></span>
                        @else
                            <span>Pay in Naira (₦{{ number_format($basePriceNgn, 2) }})</span>
                        @endif
                    </button>
                    <button type="submit" name="currency" value="USD" class="choose-button" style="width: 100% !important; font-size: 14.5px !important; background: linear-gradient(90deg, #f4d078, #d5a73b) !important; color: #0c2b70 !important; font-weight: 700 !important; border-radius: 30px !important; box-shadow: 0 4px 14px rgba(213, 167, 59, 0.35) !important;">
                        @if ($hasDiscount)
                            <span>Pay in USD <s style="opacity: 0.65; font-size: 12px; margin: 0 2px; color: #0c2b70;">${{ number_format($basePriceUsd, 2) }}</s> <strong style="color: #0c2b70;">${{ number_format($finalPriceUsd, 2) }}</strong> <span class="badge ml-1" style="font-size: 10px; color: #0c2b70; background: #ffffff; padding: 2px 5px; border-radius: 4px; font-weight: 700;">-{{ $discountPercent }}%</span></span>
                        @else
                            <span>Pay in USD (${{ number_format($basePriceUsd, 2) }})</span>
                        @endif
                    </button>
                @else
                    <button type="submit" name="currency" value="NGN" class="choose-button mb-2" style="width: 100% !important; font-size: 14.5px !important; background: #ffffff !important; color: #0c2b70 !important; font-weight: 700 !important; border-radius: 30px !important; box-shadow: 0 4px 12px rgba(0,0,0,0.12) !important;">
                        @if ($hasDiscount)
                            <span>Pay in Naira <s style="opacity: 0.55; font-size: 12px; margin: 0 2px;">₦{{ number_format($basePriceNgn, 2) }}</s> <strong>₦{{ number_format($finalPriceNgn, 2) }}</strong> <span class="badge ml-1" style="font-size: 10px; background: #d5a73b; color: #0c2b70; padding: 2px 5px; border-radius: 4px; font-weight: 700;">-{{ $discountPercent }}%</span></span>
                        @else
                            <span>Pay in Naira (₦{{ number_format($basePriceNgn, 2) }})</span>
                        @endif
                    </button>
                @endif
            </form>
        @endif
    </div>
</div>
