@extends('layouts.headerexternal')

@section('content')
<link href="{{ asset('public/admin/css/dashlite.css') }}" rel="stylesheet" type="text/css" />
<style>
    /* Reset and Base Styles */
    .pricing-container * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Arial', sans-serif;
    }

    .pricing-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        padding: 40px 20px;
    }

    /* Page Title */
    .pricing-body-header h2 {
        color: #1a3a8f;
        font-size: 36px;
        font-weight: 800;
        margin-bottom: 40px;
        text-align: center;
        position: relative;
    }

    .pricing-body-header h2::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, #1a3a8f, #2e4ba0);
        border-radius: 2px;
    }

    /* Plans Container */
    .pricing-body-plans {
        width: 100%;
        max-width: 1140px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .plans-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: stretch;
        gap: 24px;
        max-width: 1140px;
        width: 100%;
        margin: 0 auto;
        padding-top: 18px;
    }

    /* Plan Card */
    .plans-container .card,
    .plans-container .card + .card {
        flex: 1 1 280px;
        min-width: 260px;
        max-width: 340px;
        margin: 0 !important;
        background: linear-gradient(145deg, #1a3a8f 0%, #0c2b70 100%);
        border-radius: 20px;
        padding: 28px 24px;
        color: white;
        box-shadow: 0 15px 35px rgba(12, 43, 112, 0.25);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: visible;
        height: auto;
    }

    .plans-container .card .card-body {
        flex: 1 1 auto !important;
        margin-bottom: 12px;
    }

    .plans-container .card .card-footer {
        margin-top: auto !important;
        padding-top: 8px;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(12, 43, 112, 0.3);
    }

    /* Decorative Elements */
    .card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 60px;
        height: 60px;
        background-color: rgba(255, 255, 255, 0.08);
        border-radius: 0 20px 0 60px;
        pointer-events: none;
    }

    .card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 40px;
        background-color: rgba(255, 255, 255, 0.05);
        border-radius: 0 40px 0 20px;
        pointer-events: none;
    }

    /* Card Header */
    .card-header {
        text-align: center;
        margin-bottom: 14px;
        position: relative;
    }

    .card-title {
        font-size: 16px;
        font-weight: 800;
        display: block;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        line-height: 1.35;
        color: #ffffff;
        word-break: normal;
        padding: 0 4px;
    }

    .card-price {
        font-size: clamp(22px, 4vw, 28px);
        font-weight: 900;
        position: relative;
        word-break: break-word;
        line-height: 1.1;
        margin: 10px 0;
    }

    /* Card Body */
    .card-body {
        flex: 1;
        text-align: center;
    }

    .card-body p {
        font-size: 13.5px;
        line-height: 1.5;
        color: rgba(255, 255, 255, 0.85);
    }

    /* Card Footer */
    .card-footer {
        margin-top: auto;
    }

    /* Highlighted Card */
    .card.highlighted {
        background: linear-gradient(135deg, #1e429c 0%, #0d2d78 100%);
        box-shadow: 0 15px 35px rgba(12, 43, 112, 0.4);
        border: 2px solid rgba(255, 215, 138, 0.6);
    }

    .card.highlighted::before {
        background-color: rgba(255, 215, 138, 0.2);
    }

    .card.highlighted .card-price {
        color: #f4d078;
        text-shadow: 0 0 10px rgba(255, 215, 138, 0.4);
    }

    /* Active User Plan Card */
    .card.active-user-plan {
        background: linear-gradient(145deg, #122861 0%, #081d4a 100%) !important;
        border: 2px solid #10b981 !important;
        box-shadow: 0 15px 35px rgba(16, 185, 129, 0.35) !important;
    }

    /* Promotional Card Styling */
    .card.promotional-card {
        border: 2px solid #d5a73b !important;
        background: linear-gradient(155deg, #1d409e 0%, #0c2b70 60%, #092055 100%) !important;
        box-shadow: 0 16px 38px -8px rgba(213, 167, 59, 0.35), 0 0 0 1px rgba(213, 167, 59, 0.25) !important;
    }

    .card.promotional-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 22px 48px -8px rgba(213, 167, 59, 0.45), 0 0 0 1.5px rgba(213, 167, 59, 0.4) !important;
    }

    /* Sleek Floating Header Pill Badge (replaces awkward rotated ribbon) */
    .popular-badge {
        position: absolute;
        top: -14px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, #f4d078 0%, #d5a73b 100%);
        color: #0c2b70;
        padding: 6px 18px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        white-space: nowrap;
        border-radius: 50px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
        border: 1.5px solid rgba(255, 255, 255, 0.4);
        z-index: 10;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        line-height: 1.2;
    }

    .popular-badge.badge-promo {
        background: linear-gradient(135deg, #f4d078 0%, #d5a73b 100%) !important;
        color: #0c2b70 !important;
        box-shadow: 0 4px 16px rgba(213, 167, 59, 0.45) !important;
        border: 1.5px solid rgba(255, 255, 255, 0.5) !important;
    }

    .popular-badge.badge-active {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.4) !important;
        border: 1.5px solid rgba(255, 255, 255, 0.45) !important;
    }

    .popular-badge.badge-best-value {
        background: linear-gradient(135deg, #f4d078 0%, #d5a73b 100%) !important;
        color: #0c2b70 !important;
        box-shadow: 0 4px 16px rgba(213, 167, 59, 0.4) !important;
        border: 1.5px solid rgba(255, 255, 255, 0.45) !important;
    }

    /* Promotional Perks Box */
    .promo-perks-box {
        margin: 14px 0 10px 0;
        padding: 12px 14px;
        background: rgba(213, 167, 59, 0.08);
        border: 1px solid rgba(213, 167, 59, 0.32);
        border-radius: 12px;
        text-align: left;
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.12);
    }

    .promo-perks-header {
        margin-bottom: 9px;
        display: flex;
        align-items: center;
    }

    .promo-perks-pill {
        display: inline-flex;
        align-items: center;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #f4d078;
        background: rgba(213, 167, 59, 0.18);
        border: 1px solid rgba(213, 167, 59, 0.4);
        padding: 3px 8px;
        border-radius: 5px;
    }

    .promo-perks-list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .promo-perk-item {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        font-size: 12.5px;
        line-height: 1.4;
    }

    .promo-perk-bullet {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 17px;
        height: 17px;
        min-width: 17px;
        background: rgba(213, 167, 59, 0.22);
        color: #f4d078;
        border-radius: 50%;
        margin-top: 1px;
        border: 1px solid rgba(213, 167, 59, 0.45);
        font-size: 10px;
        font-weight: 700;
    }

    .promo-perk-text {
        flex: 1;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.95);
        word-break: break-word;
    }

    /* CTA Button */
    .choose-button {
        display: block;
        width: 100%;
        background-color: white;
        color: #1a3a8f;
        padding: 12px 20px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border: none;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .choose-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transform: translateX(-100%);
        transition: transform 0.6s ease;
    }

    .choose-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .choose-button:hover::before {
        transform: translateX(100%);
    }

    .highlighted .choose-button {
        background: linear-gradient(90deg, #f4d078, #d5a73b);
        color: #0c2b70;
        font-weight: 700;
    }

    /* Plan Tabs */
    .plan-tabs {
        display: flex;
        gap: 10px;
        background: #eef1f8;
        padding: 6px;
        border-radius: 40px;
        margin: 10px auto 40px;
    }

    .plan-tab-btn {
        border: none;
        background: transparent;
        color: #526484;
        font-weight: 700;
        font-size: 16px;
        padding: 11px 28px;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.25s ease;
        font-family: 'Roboto', sans-serif;
    }

    .plan-tab-btn.active {
        background: #1a3a8f;
        color: #fff;
        box-shadow: 0 4px 10px rgba(12, 43, 112, 0.25);
    }

    .plan-tab-panel {
        width: 100%;
        display: none;
    }

    .plan-tab-panel.active {
        display: block;
    }

    /* Sub-tier group heading, used inside the Academic tab */
    .plan-group-heading {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 20px;
    }

    .plan-group-heading h3 {
        color: #1c2b46;
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 6px;
        font-family: 'Roboto', sans-serif;
    }

    .plan-group-heading p {
        color: #667;
        font-size: 13.5px;
        line-height: 1.6;
        font-family: 'Roboto', sans-serif;
    }

    .plan-group + .plan-group {
        margin-top: 50px;
    }

    /* Side-by-side row for the last two sub-tiers */
    .plan-groups-row {
        display: grid;
        grid-template-columns: repeat(2, minmax(280px, 460px));
        justify-content: center;
        align-items: stretch;
        gap: 30px;
        margin-top: 50px;
        max-width: 1020px;
        width: 100%;
        margin-left: auto;
        margin-right: auto;
    }

    .plan-groups-row .plan-group {
        margin-top: 0 !important;
        margin-bottom: 0;
    }

    .plan-group-col {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .plan-group-col .plan-group-heading {
        margin: 0 auto 20px;
        width: 100%;
        text-align: center;
        min-height: 95px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    .plan-group-col .plans-container {
        flex: 1 1 auto;
        display: flex;
        justify-content: center;
        align-items: stretch;
        width: 100%;
        margin: 0;
    }

    .plan-group-col .plans-container .card {
        height: 100%;
        width: 100%;
        max-width: 340px;
        margin: 0 !important;
    }

    /* Complimentary / non-payable plan card */
    .card .complimentary-note {
        display: block;
        background: rgba(255, 255, 255, 0.12);
        border-radius: 10px;
        padding: 12px;
        font-size: 12.5px;
        line-height: 1.5;
        color: rgba(255, 255, 255, 0.85);
        text-align: center;
    }

    /* Responsive Adjustments */
    @media (max-width: 991px) {
        .plans-container {
            max-width: 760px;
        }
        .plans-container .card,
        .plans-container .card + .card {
            flex: 1 1 280px;
            max-width: 340px;
        }
    }

    @media (max-width: 768px) {
        .pricing-body-header h2 {
            font-size: 28px;
        }
        
        .plans-container {
            flex-direction: column;
            align-items: center;
        }

        .plans-container .card,
        .plans-container .card + .card {
            width: 100%;
            max-width: 400px;
            min-height: auto;
            margin: 0 0 20px 0 !important;
        }

        .plan-groups-row {
            grid-template-columns: 1fr;
            gap: 40px;
            margin-top: 40px;
        }

        .plan-group-col {
            max-width: 100%;
            width: 100%;
        }

        .plan-group-col .plan-group-heading {
            min-height: auto !important;
            height: auto !important;
        }
    }
</style>
    <div class="info">

        <div class="title">Subscribe </div>


    </div>
    </div>

    </section>
    <section class="hd-main-container pricing-section">
        <div class="upgrade-card">
            <div class="pricing-container">

                @if ($activeSubscription ?? $userSubscription)
                    <div style="max-width: 1100px; width: 100%; margin: 0 auto 30px; padding: 0 15px;">
                        <div style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border: 1.5px solid #10b981; border-radius: 14px; padding: 22px 26px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; box-shadow: 0 6px 20px rgba(16, 185, 129, 0.12);">
                            <div style="display: flex; align-items: center; gap: 18px; flex: 1; min-width: 280px;">
                                <div style="width: 50px; height: 50px; border-radius: 50%; background: #10b981; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 26px; flex-shrink: 0; box-shadow: 0 3px 10px rgba(16, 185, 129, 0.35);">
                                    <em class="icon ni ni-check-circle-fill"></em>
                                </div>
                                <div>
                                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px; flex-wrap: wrap;">
                                        <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.6px; color: #065f46; background: #a7f3d0; padding: 3px 10px; border-radius: 6px;">
                                            Current Active Subscription
                                        </span>
                                        @if(isset($activeSubscription->end_date))
                                            <span style="font-size: 12.5px; color: #047857; font-weight: 600;">
                                                Expires: {{ \Carbon\Carbon::parse($activeSubscription->end_date)->format('M d, Y') }} ({{ max(0, \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($activeSubscription->end_date), false)) }} days remaining)
                                            </span>
                                        @endif
                                    </div>
                                    <h3 style="font-size: 20px; font-weight: 800; color: #064e3b; margin: 0 0 4px 0; font-family: 'Roboto', sans-serif;">
                                        {{ $activeSubscription->subscriptionPlan->name ?? 'Active Plan' }}
                                    </h3>
                                    <p style="font-size: 13.5px; color: #047857; margin: 0; line-height: 1.5; font-family: 'Roboto', sans-serif;">
                                        You already have full active access to this plan. You cannot re-subscribe to your current plan, but you can <strong>switch or upgrade to a different plan</strong> below at any time.
                                    </p>
                                </div>
                            </div>
                            <!-- <div style="display: flex; gap: 12px; align-items: center;">
                                <a href="{{ url('profile') }}" style="background: #ffffff; border: 1.5px solid #10b981; color: #065f46; padding: 10px 22px; border-radius: 25px; font-weight: 700; font-size: 13.5px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); transition: all 0.2s ease;">
                                    <em class="icon ni ni-user"></em> Manage In Profile &rarr;
                                </a>
                            </div> -->
                        </div>
                    </div>
                @endif

                <div class="pricing-body-header" style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; width: 100%;">
                    @if ($userSubscription)
                        <h1>Switch or Upgrade Plan</h1>
                        <h2>Choose An Alternative Plan</h2>
                    @else
                        <h1>Upgrade Your Access</h1>
                        <h2>Choose A Plan</h2>
                    @endif
        
        <div class="pricing-benefits-grid" style="max-width: 1200px; margin: 30px auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; font-family: 'Roboto', sans-serif;">
            <!-- Benefit 1 -->
            <div style="background: #ffffff; border: 1px solid #e5e9f2; border-radius: 8px; padding: 25px 20px; text-align: center; box-shadow: 0 4px 10px rgba(0,0,0,0.03); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: #fef8e4; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; color: #ad8e4f;">
                    <em class="icon ni ni-book-read" style="font-size: 24px;"></em>
                </div>
                <h4 style="font-size: 16.5px; color: #1c2b46; font-weight: 700; margin-bottom: 10px; font-family: 'Roboto', sans-serif;">Full Access</h4>
                <p style="font-size: 13.5px; color: #526484; line-height: 1.6; margin: 0; font-family: 'Roboto', sans-serif;">View and download all financial market regulations, rules, and circulars.</p>
            </div>
            
            <!-- Benefit 2 -->
            <div style="background: #ffffff; border: 1px solid #e5e9f2; border-radius: 8px; padding: 25px 20px; text-align: center; box-shadow: 0 4px 10px rgba(0,0,0,0.03); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: #e6f8f3; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; color: #1ee0ac;">
                    <em class="icon ni ni-eye" style="font-size: 24px;"></em>
                </div>
                <h4 style="font-size: 16.5px; color: #1c2b46; font-weight: 700; margin-bottom: 10px; font-family: 'Roboto', sans-serif;">Interactive Previews</h4>
                <p style="font-size: 13.5px; color: #526484; line-height: 1.6; margin: 0; font-family: 'Roboto', sans-serif;">Preview PDF documents directly within your browser window.</p>
            </div>
            
            <!-- Benefit 3 -->
            <div style="background: #ffffff; border: 1px solid #e5e9f2; border-radius: 8px; padding: 25px 20px; text-align: center; box-shadow: 0 4px 10px rgba(0,0,0,0.03); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: #e5f3ff; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; color: #09c2de;">
                    <em class="icon ni ni-network" style="font-size: 24px;"></em>
                </div>
                <h4 style="font-size: 16.5px; color: #1c2b46; font-weight: 700; margin-bottom: 10px; font-family: 'Roboto', sans-serif;">Document Linkage</h4>
                <p style="font-size: 13.5px; color: #526484; line-height: 1.6; margin: 0; font-family: 'Roboto', sans-serif;">Trace amendments, active versions, and revisions effortlessly.</p>
            </div>
            
            <!-- Benefit 4 -->
            <div style="background: #ffffff; border: 1px solid #e5e9f2; border-radius: 8px; padding: 25px 20px; text-align: center; box-shadow: 0 4px 10px rgba(0,0,0,0.03); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: #f3f2ff; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; color: #816bff;">
                    <em class="icon ni ni-search" style="font-size: 24px;"></em>
                </div>
                <h4 style="font-size: 16.5px; color: #1c2b46; font-weight: 700; margin-bottom: 10px; font-family: 'Roboto', sans-serif;">Smart Tools</h4>
                <p style="font-size: 13.5px; color: #526484; line-height: 1.6; margin: 0; font-family: 'Roboto', sans-serif;">Use advanced filters and search, and get real-time notifications.</p>
            </div>
        </div>
    </div>
    <div class="pricing-body-plans">
        <div class="plan-tabs">
            <button type="button" class="plan-tab-btn active" data-tab="institutional">Institutional Subscription</button>
            <button type="button" class="plan-tab-btn" data-tab="academic">
                {{ ($academicTier && $academicTier->isPromoActive() && $academicTier->promo_tab_title) ? $academicTier->promo_tab_title : 'Academic Subscription' }}
                @if ($academicTier && $academicTier->isPromoActive() && $academicTier->promo_badge)
                    <span class="badge ml-1" style="background:#d5a73b;color:#0c2b70;font-size:11px;padding:2px 6px;border-radius:4px;font-weight:700;">{{ $academicTier->promo_badge }}</span>
                @endif
            </button>
        </div>

        <div class="plan-tab-panel active" id="plan-tab-institutional">
            <div class="plans-container">
                @foreach ($institutionalPlans as $package)
                    @include('partials.subscription-plan-card', ['package' => $package, 'highlight' => $package->duration >= 365])
                @endforeach
            </div>
        </div>

        <div class="plan-tab-panel" id="plan-tab-academic">
            @if ($academicTier)
                @if ($academicTier->isPromoActive() && !empty($academicTier->promo_features_list))
                    <div class="text-center my-3">
                        <div style="background:#fff8e1; border:1px dashed #ffb300; display:inline-block; text-align:left; padding:12px 20px; border-radius:8px;">
                            <div style="font-weight:700; color:#b78103; font-size:13px; text-transform:uppercase; margin-bottom:6px;">
                                <i class="fas fa-gift mr-1"></i> Special Promotion Features:
                            </div>
                            <ul style="margin:0; padding-left:18px; color:#5d4037; font-size:13.5px;">
                                @foreach ($academicTier->promo_features_list as $feature)
                                    <li><i class="fas fa-check-circle text-success mr-1"></i> {{ $feature }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                @php
                    $subTiers = $academicTier->subTiers;
                    $topSubTiers = $subTiers->count() > 2 ? $subTiers->slice(0, $subTiers->count() - 2) : collect();
                    $sideBySideSubTiers = $subTiers->count() > 2 ? $subTiers->slice(-2) : $subTiers;
                @endphp

                @foreach ($topSubTiers as $subTier)
                    <div class="plan-group">
                        <div class="plan-group-heading">
                            <h3>
                                {{ $subTier->name }}
                                @if ($subTier->isPromoActive() && $subTier->promo_badge)
                                    <span class="badge ml-1" style="background:#d5a73b;color:#0c2b70;font-size:12px;padding:3px 8px;border-radius:4px;font-weight:700;">{{ $subTier->promo_badge }}</span>
                                @endif
                            </h3>
                            @if ($subTier->description)
                                <p>{{ $subTier->description }}</p>
                            @endif
                            @if ($subTier->isPromoActive() && !empty($subTier->promo_features_list))
                                <div class="promo-features-box my-2 p-2 rounded" style="background:#fff8e1; border:1px dashed #ffb300; display:inline-block; text-align:left; max-width:600px;">
                                    <div style="font-weight:700; color:#b78103; font-size:12px; text-transform:uppercase; margin-bottom:4px;">
                                        <i class="fas fa-gift mr-1"></i> Promotional Features:
                                    </div>
                                    <ul style="margin:0; padding-left:18px; color:#5d4037; font-size:13px;">
                                        @foreach ($subTier->promo_features_list as $feature)
                                            <li><i class="fas fa-check-circle text-success mr-1"></i> {{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="plans-container">
                            @foreach ($subTier->plans as $package)
                                @include('partials.subscription-plan-card', ['package' => $package, 'highlight' => $package->duration >= 365 && $package->price > 0])
                            @endforeach
                        </div>
                    </div>
                @endforeach

                @if ($sideBySideSubTiers->count() > 1)
                    <div class="plan-groups-row">
                        @foreach ($sideBySideSubTiers as $subTier)
                            <div class="plan-group plan-group-col">
                                <div class="plan-group-heading">
                                    <h3>
                                        {{ $subTier->name }}
                                        @if ($subTier->isPromoActive() && $subTier->promo_badge)
                                            <span class="badge ml-1" style="background:#d5a73b;color:#0c2b70;font-size:12px;padding:3px 8px;border-radius:4px;font-weight:700;">{{ $subTier->promo_badge }}</span>
                                        @endif
                                    </h3>
                                    @if ($subTier->description)
                                        <p>{{ $subTier->description }}</p>
                                    @endif
                                    @if ($subTier->isPromoActive() && !empty($subTier->promo_features_list))
                                        <div class="promo-features-box my-2 p-2 rounded" style="background:#fff8e1; border:1px dashed #ffb300; display:inline-block; text-align:left; max-width:600px;">
                                            <div style="font-weight:700; color:#b78103; font-size:12px; text-transform:uppercase; margin-bottom:4px;">
                                                <i class="fas fa-gift mr-1"></i> Promotional Features:
                                            </div>
                                            <ul style="margin:0; padding-left:18px; color:#5d4037; font-size:13px;">
                                                @foreach ($subTier->promo_features_list as $feature)
                                                    <li><i class="fas fa-check-circle text-success mr-1"></i> {{ $feature }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <div class="plans-container">
                                    @foreach ($subTier->plans as $package)
                                        @include('partials.subscription-plan-card', ['package' => $package, 'highlight' => $package->duration >= 365 && $package->price > 0])
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    @foreach ($sideBySideSubTiers as $subTier)
                        <div class="plan-group">
                            <div class="plan-group-heading">
                                <h3>
                                    {{ $subTier->name }}
                                    @if ($subTier->isPromoActive() && $subTier->promo_badge)
                                        <span class="badge ml-1" style="background:#d5a73b;color:#0c2b70;font-size:12px;padding:3px 8px;border-radius:4px;font-weight:700;">{{ $subTier->promo_badge }}</span>
                                    @endif
                                </h3>
                                @if ($subTier->description)
                                    <p>{{ $subTier->description }}</p>
                                @endif
                                @if ($subTier->isPromoActive() && !empty($subTier->promo_features_list))
                                    <div class="promo-features-box my-2 p-2 rounded" style="background:#fff8e1; border:1px dashed #ffb300; display:inline-block; text-align:left; max-width:600px;">
                                        <div style="font-weight:700; color:#b78103; font-size:12px; text-transform:uppercase; margin-bottom:4px;">
                                            <i class="fas fa-gift mr-1"></i> Promotional Features:
                                        </div>
                                        <ul style="margin:0; padding-left:18px; color:#5d4037; font-size:13px;">
                                            @foreach ($subTier->promo_features_list as $feature)
                                                <li><i class="fas fa-check-circle text-success mr-1"></i> {{ $feature }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <div class="plans-container">
                                @foreach ($subTier->plans as $package)
                                    @include('partials.subscription-plan-card', ['package' => $package, 'highlight' => $package->duration >= 365 && $package->price > 0])
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif
        </div>
    </div>

            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function syncSideBySideHeadings() {
                var headings = document.querySelectorAll('.plan-groups-row .plan-group-col .plan-group-heading');
                if (!headings.length) return;
                headings.forEach(function(h) { h.style.minHeight = ''; });
                if (window.innerWidth <= 768) return;
                var maxH = 0;
                headings.forEach(function(h) {
                    if (h.offsetHeight > maxH) maxH = h.offsetHeight;
                });
                if (maxH > 0) {
                    headings.forEach(function(h) { h.style.minHeight = maxH + 'px'; });
                }
            }

            document.querySelectorAll('.plan-tab-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.plan-tab-btn').forEach(function(b) { b.classList.remove('active'); });
                    document.querySelectorAll('.plan-tab-panel').forEach(function(p) { p.classList.remove('active'); });
                    btn.classList.add('active');
                    document.getElementById('plan-tab-' + btn.dataset.tab).classList.add('active');
                    syncSideBySideHeadings();
                });
            });

            syncSideBySideHeadings();
            window.addEventListener('resize', syncSideBySideHeadings);
        });
    </script>
@endsection
</div>
</body>

</html>