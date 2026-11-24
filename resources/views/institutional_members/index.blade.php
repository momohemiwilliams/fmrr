@extends('layouts.externalprofile')

@section('page_title', 'Manage Team')

@section('content')
<link href="{{ asset('public/admin/css/dashlite.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha384-R334r6kryDNB/GWs2kfB6blAOyWPCxjdHSww/mo7fel+o5TM/AOobJ0QpGRXSDh4" crossorigin="anonymous">

<style>
    .team-page-wrapper {
        background-color: #f4f6fa;
        min-height: calc(100vh - 320px);
        padding: 30px 20px 80px;
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .team-container {
        max-width: 860px;
        margin: 0 auto;
    }

    .team-back-nav {
        margin-bottom: 20px;
    }

    .btn-back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #0c2b70;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none !important;
        padding: 8px 14px;
        border-radius: 8px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    }

    .btn-back-link:hover {
        background: #0c2b70;
        color: #ffffff !important;
        border-color: #0c2b70;
        transform: translateX(-3px);
    }

    .team-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 36px 32px;
        box-shadow: 0 10px 30px -5px rgba(12, 43, 112, 0.07), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
    }

    .team-header {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        padding-bottom: 24px;
        border-bottom: 1px solid #eef2f6;
        margin-bottom: 24px;
    }

    .team-header-icon {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        background: linear-gradient(135deg, #0c2b70 0%, #1a3a8f 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        flex-shrink: 0;
        box-shadow: 0 8px 18px rgba(12, 43, 112, 0.2);
        border: 2px solid rgba(199, 157, 81, 0.4);
    }

    .team-header-content {
        flex: 1;
    }

    .team-header-content h2 {
        color: #0c2b70;
        font-size: 22px;
        font-weight: 800;
        margin: 0 0 6px;
        letter-spacing: -0.2px;
    }

    .team-plan-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fef9ed;
        color: #92400e;
        border: 1px solid #fde68a;
        font-size: 12px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        margin-bottom: 8px;
    }

    .team-header-content p.subtitle {
        color: #64748b;
        font-size: 13.5px;
        margin: 0;
        line-height: 1.5;
    }

    /* Seat Meter Card */
    .seat-meter-box {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 28px;
    }

    .seat-meter-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .seat-meter-label {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .seat-count-text {
        font-size: 14px;
        font-weight: 700;
        color: #0c2b70;
    }

    .seat-progress-track {
        background: #e2e8f0;
        height: 10px;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .seat-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #0c2b70 0%, #1a3a8f 60%, #c79d51 100%);
        border-radius: 20px;
        transition: width 0.5s ease;
    }

    .seat-meter-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 12.5px;
        color: #64748b;
    }

    .badge-seats-available {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #ecfdf5;
        color: #059669;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 12px;
        border: 1px solid #a7f3d0;
    }

    .badge-seats-full {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #fffbeb;
        color: #d97706;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 12px;
        border: 1px solid #fde68a;
    }

    /* Team Members Table */
    .table-container {
        border: 1px solid #edf2f7;
        border-radius: 14px;
        overflow-x: auto;
        overflow-y: hidden;
        margin-bottom: 30px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    }

    .team-table {
        width: 100%;
        min-width: 860px;
        border-collapse: collapse;
        margin: 0;
        background: #ffffff;
    }

    .team-table th {
        background: #f8fafc;
        color: #475569;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 18px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .team-table td {
        padding: 16px 18px;
        vertical-align: middle;
        font-size: 13.5px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
    }

    .team-table tbody tr:last-child td {
        border-bottom: none;
    }

    .team-table tbody tr:hover td {
        background-color: #fafbfc;
    }

    /* Member Name & Avatar */
    .member-info-col {
        display: flex;
        align-items: center;
        gap: 12px;
        white-space: nowrap;
    }

    .member-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #eff6ff;
        color: #1a3a8f;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 13px;
        flex-shrink: 0;
        border: 1px solid #dbeafe;
    }

    .member-avatar.owner-avatar {
        background: linear-gradient(135deg, #0c2b70 0%, #1a3a8f 100%);
        color: #ffffff;
        border: 1.5px solid #c79d51;
    }

    .member-name {
        font-weight: 700;
        color: #0f172a;
    }

    .badge-you {
        background: #e2e8f0;
        color: #475569;
        font-size: 11px;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 10px;
        margin-left: 6px;
        white-space: nowrap;
    }

    /* Status Badges */
    .profile-role-badge-wrap {
        display: flex;
        align-items: center;
        margin-bottom: 4px;
    }

    .badge-role,
    .profile-role-badge {
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        padding: 4px 12px !important;
        border-radius: 20px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        white-space: nowrap !important;
        line-height: 1.2 !important;
    }

    .profile-meta-item {
        display: flex !important;
        align-items: center !important;
        gap: 6px !important;
        font-size: 12px !important;
        line-height: 1.4 !important;
        white-space: nowrap !important;
    }

    .profile-meta-item .icon {
        font-size: 14px !important;
        flex-shrink: 0 !important;
        line-height: 1 !important;
        color: #64748b;
    }

    .profile-meta-function {
        color: #334155 !important;
        font-size: 11.5px !important;
        font-weight: 500 !important;
    }

    .profile-meta-function .icon {
        color: #0c2b70 !important;
    }

    .badge-owner {
        background: #fef9ed;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .badge-active-member {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }

    .dot-active {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #10b981;
    }

    /* Remove Button */
    .btn-remove-member {
        width: auto !important;
        background: transparent !important;
        border: 1px solid #fecaca !important;
        color: #ef4444 !important;
        font-weight: 600 !important;
        font-size: 12px !important;
        padding: 6px 12px !important;
        border-radius: 8px !important;
        cursor: pointer !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 4px !important;
        transition: all 0.2s ease !important;
    }

    .btn-remove-member:hover {
        background: #ef4444 !important;
        color: #ffffff !important;
        border-color: #ef4444 !important;
    }

    /* Add Member Section */
    .add-member-section {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
    }

    .add-member-title {
        font-size: 15px;
        font-weight: 700;
        color: #0c2b70;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .add-member-desc {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 16px;
    }

    .invite-form-wrapper {
        display: flex;
        gap: 12px;
    }

    @media (max-width: 576px) {
        .invite-form-wrapper {
            flex-direction: column;
        }
        .invite-form-wrapper button {
            width: 100% !important;
        }
    }

    .input-with-icon {
        position: relative;
        flex: 1;
    }

    .input-leading-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 18px;
        pointer-events: none;
    }

    .input-with-icon input[type="email"] {
        width: 100%;
        padding: 12px 14px 12px 42px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 14px;
        outline: none;
        transition: all 0.2s ease;
        background: #ffffff;
    }

    .input-with-icon input[type="email"]:focus {
        border-color: #0c2b70;
        box-shadow: 0 0 0 3px rgba(12, 43, 112, 0.12);
    }

    .btn-add-member {
        width: auto !important;
        background: #0c2b70 !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 12px 24px !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        cursor: pointer !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        white-space: nowrap !important;
        transition: all 0.2s ease !important;
        box-shadow: 0 4px 12px rgba(12, 43, 112, 0.2) !important;
        flex-shrink: 0 !important;
    }

    .btn-add-member:hover {
        background: #1a3a8f !important;
        color: #ffffff !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 6px 16px rgba(12, 43, 112, 0.28) !important;
    }

    .btn-add-member:disabled {
        background: #94a3b8 !important;
        color: #ffffff !important;
        cursor: not-allowed !important;
        box-shadow: none !important;
        transform: none !important;
        opacity: 0.65 !important;
    }

    /* Helper Notice */
    .helper-notice {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        background: #f0f7ff;
        border: 1px solid #d0e1fd;
        border-radius: 10px;
        padding: 12px 14px;
        font-size: 12.5px;
        color: #1e40af;
        margin-top: 14px;
        line-height: 1.5;
    }

    .helper-notice em {
        font-size: 16px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .seats-full-banner {
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 12px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #92400e;
        font-size: 13.5px;
    }

    .seats-full-banner em {
        font-size: 20px;
        color: #d97706;
    }

    /* SweetAlert2 Side-by-Side Action Buttons */
    .swal2-actions,
    .swal2-actions-row {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        justify-content: center !important;
        align-items: center !important;
        gap: 12px !important;
        width: 100% !important;
        margin: 1.5rem auto 0 !important;
    }

    .swal2-actions .swal2-deny,
    button.swal2-deny {
        display: none !important;
    }

    /* Buttons when NOT loading */
    .swal2-actions:not(.swal2-loading) button.swal2-confirm,
    .swal2-actions:not(.swal2-loading) button.swal2-cancel,
    .swal2-actions:not(.swal2-loading) .swal2-styled.swal2-confirm,
    .swal2-actions:not(.swal2-loading) .swal2-styled.swal2-cancel,
    .swal2-actions-row:not(.swal2-loading) .swal2-confirm-btn,
    .swal2-actions-row:not(.swal2-loading) .swal2-cancel-btn {
        width: auto !important;
        flex: 0 1 auto !important;
        min-width: 130px !important;
        margin: 0 4px !important;
        padding: 11px 22px !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        border-radius: 8px !important;
        box-shadow: none !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        cursor: pointer !important;
        outline: none !important;
        animation: none !important;
        transform: none !important;
    }

    .swal2-actions:not(.swal2-loading) button.swal2-confirm,
    .swal2-actions:not(.swal2-loading) .swal2-styled.swal2-confirm,
    .swal2-confirm-btn {
        background-color: #e85347 !important;
        color: #ffffff !important;
        border: 1px solid #e85347 !important;
    }

    .swal2-actions:not(.swal2-loading) button.swal2-confirm:hover,
    .swal2-actions:not(.swal2-loading) .swal2-styled.swal2-confirm:hover,
    .swal2-confirm-btn:hover {
        background-color: #d63d31 !important;
        border-color: #d63d31 !important;
    }

    .swal2-actions:not(.swal2-loading) button.swal2-cancel,
    .swal2-actions:not(.swal2-loading) .swal2-styled.swal2-cancel,
    .swal2-cancel-btn {
        background-color: #6e829f !important;
        color: #ffffff !important;
        border: 1px solid #6e829f !important;
    }

    .swal2-actions:not(.swal2-loading) button.swal2-cancel:hover,
    .swal2-actions:not(.swal2-loading) .swal2-styled.swal2-cancel:hover,
    .swal2-cancel-btn:hover {
        background-color: #566882 !important;
        border-color: #566882 !important;
    }

    /* Loading State: completely hide buttons and stop Dashlite rotation */
    .swal2-loading .swal2-actions button,
    .swal2-actions.swal2-loading button,
    .swal2-actions.swal2-loading .swal2-styled,
    .swal2-actions.swal2-loading .swal2-confirm,
    .swal2-actions.swal2-loading .swal2-cancel {
        display: none !important;
        animation: none !important;
        transform: none !important;
        visibility: hidden !important;
        width: 0 !important;
        height: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* Clean, centered SweetAlert circular spinner */
    .swal2-actions.swal2-loading .swal2-loader,
    .swal2-popup.swal2-loading .swal2-loader,
    .swal2-loader {
        display: inline-block !important;
        visibility: visible !important;
        opacity: 1 !important;
        width: 44px !important;
        height: 44px !important;
        margin: 12px auto !important;
        border: 4px solid #f1f5f9 !important;
        border-top-color: #e85347 !important;
        border-right-color: #e85347 !important;
        border-radius: 50% !important;
        box-sizing: border-box !important;
        animation: swal-clean-spin 0.8s linear infinite !important;
        background: transparent !important;
    }

    @keyframes swal-clean-spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

</style>

@php
    $ownerName = Auth::user()->name ?? 'Owner';
    $ownerParts = array_filter(explode(' ', trim($ownerName)));
    if (count($ownerParts) >= 2) {
        $ownerInitials = strtoupper(substr($ownerParts[0], 0, 1) . substr(end($ownerParts), 0, 1));
    } else {
        $ownerInitials = strtoupper(substr($ownerName, 0, 2));
    }

    $seatPercentage = $seatLimit > 0 ? min(100, round(($seatsUsed / $seatLimit) * 100)) : 0;
    $seatsRemaining = max(0, $seatLimit - $seatsUsed);
@endphp

<div class="team-page-wrapper">
    <div class="team-container">
        <!-- Back Link Navigation -->
        <div class="team-back-nav">
            <a href="{{ route('profile') }}" class="btn-back-link">
                <em class="icon ni ni-arrow-left"></em> Back to Profile
            </a>
        </div>

        <div class="team-card">
            <!-- Header -->
            <div class="team-header">
                <div class="team-header-icon">
                    <em class="icon ni ni-users"></em>
                </div>
                <div class="team-header-content">
                    <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 8px;">
                        <h2>Manage Team</h2>
                        <span class="team-plan-tag">
                            <em class="icon ni ni-shield-check"></em> {{ $subscription->subscriptionPlan->name }}
                        </span>
                    </div>
                    <p class="subtitle">
                        Add up to {{ $seatLimit - 1 }} additional team members to share this subscription and collaborate on FMRR Portal regulations.
                    </p>
                </div>
            </div>

            <!-- Visual Seat Meter -->
            <div class="seat-meter-box">
                <div class="seat-meter-top">
                    <span class="seat-meter-label">
                        <em class="icon ni ni-pie"></em> Seat Allocation
                    </span>
                    <span class="seat-count-text">
                        {{ $seatsUsed }} of {{ $seatLimit }} Seats Used
                    </span>
                </div>

                <div class="seat-progress-track">
                    <div class="seat-progress-fill" style="width: {{ $seatPercentage }}%;"></div>
                </div>

                <div class="seat-meter-footer">
                    <span>{{ $seatPercentage }}% capacity utilized</span>
                    @if ($seatsRemaining > 0)
                        <span class="badge-seats-available">
                            <em class="icon ni ni-check"></em> {{ $seatsRemaining }} {{ $seatsRemaining === 1 ? 'seat' : 'seats' }} available
                        </span>
                    @else
                        <span class="badge-seats-full">
                            <em class="icon ni ni-alert-circle"></em> All seats allocated
                        </span>
                    @endif
                </div>
            </div>

            <!-- Members Table -->
            <div class="table-container">
                <table class="team-table">
                    <thead>
                        <tr>
                            <th style="min-width: 190px;">Team Member</th>
                            <th style="min-width: 200px;">Email Address</th>
                            <th style="min-width: 260px;">Role &amp; Academic Profile</th>
                            <th style="min-width: 110px;">Status</th>
                            <th class="text-right" style="min-width: 180px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Subscription Owner -->
                        <tr>
                            <td>
                                <div class="member-info-col">
                                    <div class="member-avatar owner-avatar" title="Account Owner">
                                        {{ $ownerInitials }}
                                    </div>
                                    <div>
                                        <span class="member-name">{{ Auth::user()->name }}</span>
                                        <span class="badge-you">You</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-muted" style="white-space: nowrap;">{{ Auth::user()->email }}</td>
                            <td>
                                <div class="profile-role-badge-wrap">
                                    <span class="badge-role badge-owner">
                                        <em class="icon ni ni-crown"></em> Primary Account Holder
                                    </span>
                                </div>
                                <div class="profile-meta-item text-muted mt-1">
                                    <em class="icon ni ni-building"></em>
                                    <span>{{ Auth::user()->company_name ?: 'Academic Institution' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge-role badge-active-member">
                                    <span class="dot-active"></span> Active
                                </span>
                            </td>
                            <td class="text-right text-muted" style="font-size: 12px; white-space: nowrap;">
                                Primary Admin
                            </td>
                        </tr>

                        <!-- Team Members -->
                        @foreach ($members as $member)
                            @php
                                $mName = optional($member->member)->name ?? 'Member';
                                $mParts = array_filter(explode(' ', trim($mName)));
                                $mInitials = count($mParts) >= 2 
                                    ? strtoupper(substr($mParts[0], 0, 1) . substr(end($mParts), 0, 1))
                                    : strtoupper(substr($mName, 0, 2));
                            @endphp
                            <tr>
                                <td>
                                    <div class="member-info-col">
                                        <div class="member-avatar" title="{{ $mName }}">
                                            {{ $mInitials }}
                                        </div>
                                        <div>
                                            <span class="member-name">{{ $mName }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted" style="white-space: nowrap;">{{ $member->email }}</td>
                                <td>
                                    <div class="profile-role-badge-wrap">
                                        <span class="badge badge-dim badge-outline-primary profile-role-badge">
                                            <em class="icon ni ni-user-check"></em> {{ $member->role ?? 'Academic Member' }}
                                        </span>
                                    </div>
                                    @if ($member->faculty || $member->department)
                                        <div class="profile-meta-item text-muted mt-1">
                                            <em class="icon ni ni-folder"></em>
                                            <span>{{ $member->faculty ?? 'Faculty' }} &bull; {{ $member->department ?? 'Dept' }}</span>
                                        </div>
                                    @endif
                                    @if ($member->function)
                                        <div class="profile-meta-item profile-meta-function mt-1">
                                            <em class="icon ni ni-briefcase text-primary"></em>
                                            <span>{{ $member->function }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge-role badge-active-member">
                                        <span class="dot-active"></span> Active
                                    </span>
                                </td>
                                <td class="text-right">
                                    <div class="d-inline-flex align-items-center" style="gap: 8px;">
                                        <button type="button" 
                                                class="btn btn-xs btn-outline-primary btn-edit-profile" 
                                                data-id="{{ $member->id }}"
                                                data-email="{{ $member->email }}"
                                                data-name="{{ $mName }}"
                                                data-role="{{ $member->role }}"
                                                data-faculty="{{ $member->faculty }}"
                                                data-department="{{ $member->department }}"
                                                data-function="{{ $member->function }}">
                                            <em class="icon ni ni-edit mr-1"></em> Configure Profile
                                        </button>
                                        <form method="POST" action="{{ route('institutionalMember.remove', $member->id) }}" id="remove-form-{{ $member->id }}">
                                            @csrf
                                            <button type="button" 
                                                    class="btn-remove-member btn-confirm-remove"
                                                    data-form-id="remove-form-{{ $member->id }}"
                                                    data-email="{{ $member->email }}"
                                                    data-name="{{ $mName }}">
                                                <em class="icon ni ni-trash"></em> Remove
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Add Member Section with Profiling Interface -->
            @if ($seatsUsed < $seatLimit)
                <div class="add-member-section">
                    <div class="add-member-title">
                        <em class="icon ni ni-user-add"></em> Add &amp; Profile New Team Member
                    </div>
                    <p class="add-member-desc">
                        Add an institutional member under this subscription and configure their institutional role, academic faculty, department, and function.
                    </p>

                    <form id="add_member_form" method="POST" action="{{ route('institutionalMember.invite') }}">
                        @csrf
                        <div class="row g-3">
                            <!-- 1. Member Email Address -->
                            <div class="col-12 col-md-6">
                                <label class="form-label" style="font-weight: 600; font-size: 13px; color: #1e293b;">
                                    <em class="icon ni ni-mail text-primary mr-1"></em> Member Email Address <span class="text-danger">*</span>
                                </label>
                                <div style="position: relative;">
                                    <input type="email" id="member_email" name="email" class="form-control" placeholder="colleague@university.edu" required value="{{ old('email') }}" autocomplete="off" style="border-radius: 10px; padding: 10px 42px 10px 14px; font-size: 13.5px; border: 1.5px solid #cbd5e1; transition: border-color 0.2s ease, box-shadow 0.2s ease;">
                                    <div id="email_status_indicator" style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); display: none; line-height: 1; pointer-events: none;">
                                        <div id="email_spinner" class="spinner-border spinner-border-sm text-primary" role="status" style="width: 17px; height: 17px; border-width: 2px; display: none;"></div>
                                        <em id="email_success_icon" class="icon ni ni-check-circle-fill" style="color: #10b981; font-size: 20px; display: none;"></em>
                                        <em id="email_error_icon" class="icon ni ni-cross-circle-fill" style="color: #ef4444; font-size: 20px; display: none;"></em>
                                    </div>
                                </div>
                                <div id="email_live_feedback" class="mt-1" style="font-size: 12px; display: none; line-height: 1.4;"></div>
                                <small id="email_default_hint" class="text-muted" style="font-size: 11.5px;">Must be registered on the FMRR Portal.</small>
                            </div>

                            <!-- 2. Institutional Role -->
                            <div class="col-12 col-md-6">
                                <label class="form-label" style="font-weight: 600; font-size: 13px; color: #1e293b;">
                                    <em class="icon ni ni-user-check text-primary mr-1"></em> Institutional Role <span class="text-danger">*</span>
                                </label>
                                <select id="member_role" name="role" class="form-control" required style="border-radius: 10px; height: 42px; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select member role</option>
                                    <option value="Student" {{ old('role') == 'Student' ? 'selected' : '' }}>Student (Undergraduate / Postgraduate / PhD)</option>
                                    <option value="Lecturer / Professor" {{ old('role') == 'Lecturer / Professor' ? 'selected' : '' }}>Lecturer / Senior Lecturer / Professor</option>
                                    <option value="Researcher" {{ old('role') == 'Researcher' ? 'selected' : '' }}>Researcher / Research Fellow</option>
                                    <option value="Dean / Head of Department" {{ old('role') == 'Dean / Head of Department' ? 'selected' : '' }}>Dean / Head of Department / Director</option>
                                    <option value="Administrative / Academic Staff" {{ old('role') == 'Administrative / Academic Staff' ? 'selected' : '' }}>Administrative / Academic Staff</option>
                                    <option value="Other Academic Function" {{ old('role') == 'Other Academic Function' ? 'selected' : '' }}>Other Academic Staff</option>
                                </select>
                            </div>

                            <!-- 3. Faculty -->
                            <div class="col-12 col-md-6">
                                <label class="form-label" style="font-weight: 600; font-size: 13px; color: #1e293b;">
                                    <em class="icon ni ni-folder text-primary mr-1"></em> Academic Faculty <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="member_faculty" name="faculty" class="form-control" placeholder="e.g. Faculty of Social Sciences, Faculty of Law" required value="{{ old('faculty') }}" style="border-radius: 10px; padding: 10px 14px; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                            </div>

                            <!-- 4. Department -->
                            <div class="col-12 col-md-6">
                                <label class="form-label" style="font-weight: 600; font-size: 13px; color: #1e293b;">
                                    <em class="icon ni ni-building text-primary mr-1"></em> Academic Department <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="member_department" name="department" class="form-control" placeholder="e.g. Department of Economics, Dept of Finance" required value="{{ old('department') }}" style="border-radius: 10px; padding: 10px 14px; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                            </div>

                            <!-- 5. Institutional Function -->
                            <div class="col-12">
                                <label class="form-label" style="font-weight: 600; font-size: 13px; color: #1e293b;">
                                    <em class="icon ni ni-briefcase text-primary mr-1"></em> Academic / Institutional Function <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="member_function" name="function" class="form-control" placeholder="e.g. Teaching / Course Instruction, Academic Research &amp; Publication, Graduate Supervision" required value="{{ old('function') }}" style="border-radius: 10px; padding: 10px 14px; font-size: 13.5px; border: 1.5px solid #cbd5e1;">
                            </div>

                            <div class="col-12 text-right mt-2">
                                <button type="submit" id="btn_submit_member" class="btn-add-member" disabled title="Please enter a registered FMRR user email and complete all profiling fields.">
                                    <em class="icon ni ni-plus"></em> <span id="btn_submit_text">Add &amp; Profile Member</span>
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="helper-notice mt-3">
                        <em class="icon ni ni-info"></em>
                        <div>
                            <strong>Account Requirement:</strong> The team member must already have a registered FMRR Portal account. If they don't have one yet, ask them to create a free account first, then enter their registered email here to assign their academic profile and grant access.
                        </div>
                    </div>
                </div>
            @else
                <div class="seats-full-banner">
                    <em class="icon ni ni-info-fill"></em>
                    <div>
                        <strong>All seats are currently allocated.</strong> To add more team members, remove an existing member above or contact FMDQ support to upgrade your subscription capacity.
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Configure Profile Modal -->
<div class="modal fade" id="modalEditMemberProfile" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 15px 40px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 16px 16px 0 0; padding: 18px 24px;">
                <h5 class="modal-title" style="color: #0c2b70; font-weight: 700; font-size: 16px;">
                    <em class="icon ni ni-user-check text-primary mr-1"></em> Configure Member Academic Profile
                </h5>
                <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </button>
            </div>
            <form method="POST" id="editProfileForm" action="">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-muted mb-3" style="font-size: 13px;">
                        Configure institutional role, faculty, department, and academic function for <strong id="modalMemberEmailText"></strong>.
                    </p>

                    <!-- Role -->
                    <div class="form-group mb-3">
                        <label class="form-label" style="font-weight: 600; font-size: 13px; color: #1e293b;">
                            Institutional Role <span class="text-danger">*</span>
                        </label>
                        <select name="role" id="modalMemberRole" class="form-control" required style="border-radius: 8px; height: 42px;">
                            <option value="Student">Student (Undergraduate / Postgraduate / PhD)</option>
                            <option value="Lecturer / Professor">Lecturer / Senior Lecturer / Professor</option>
                            <option value="Researcher">Researcher / Research Fellow</option>
                            <option value="Dean / Head of Department">Dean / Head of Department / Director</option>
                            <option value="Administrative / Academic Staff">Administrative / Academic Staff</option>
                            <option value="Other Academic Function">Other Academic Staff</option>
                        </select>
                    </div>

                    <!-- Faculty -->
                    <div class="form-group mb-3">
                        <label class="form-label" style="font-weight: 600; font-size: 13px; color: #1e293b;">
                            Academic Faculty <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="faculty" id="modalMemberFaculty" class="form-control" required placeholder="e.g. Faculty of Social Sciences" style="border-radius: 8px;">
                    </div>

                    <!-- Department -->
                    <div class="form-group mb-3">
                        <label class="form-label" style="font-weight: 600; font-size: 13px; color: #1e293b;">
                            Academic Department <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="department" id="modalMemberDepartment" class="form-control" required placeholder="e.g. Department of Economics" style="border-radius: 8px;">
                    </div>

                    <!-- Function -->
                    <div class="form-group mb-3">
                        <label class="form-label" style="font-weight: 600; font-size: 13px; color: #1e293b;">
                            Academic / Institutional Function <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="function" id="modalMemberFunction" class="form-control" required placeholder="e.g. Teaching / Course Instruction, Academic Research" style="border-radius: 8px;">
                    </div>
                </div>
                <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; border-radius: 0 0 16px 16px; padding: 14px 24px;">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: #0c2b70; border-color: #0c2b70; font-weight: 600;">
                        <em class="icon ni ni-check mr-1"></em> Save Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert2 Confirmation Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configure/Edit Profile Modal trigger
        document.querySelectorAll('.btn-edit-profile').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var id = this.getAttribute('data-id');
                var email = this.getAttribute('data-email');
                var role = this.getAttribute('data-role');
                var faculty = this.getAttribute('data-faculty');
                var department = this.getAttribute('data-department');
                var func = this.getAttribute('data-function');

                var form = document.getElementById('editProfileForm');
                form.action = "{{ url('team') }}/" + id + "/profile";

                document.getElementById('modalMemberEmailText').textContent = email;
                document.getElementById('modalMemberRole').value = role || 'Student';
                document.getElementById('modalMemberFaculty').value = faculty || '';
                document.getElementById('modalMemberDepartment').value = department || '';
                document.getElementById('modalMemberFunction').value = func || '';

                if (typeof $ !== 'undefined' && typeof $.fn.modal !== 'undefined') {
                    $('#modalEditMemberProfile').modal('show');
                } else if (typeof bootstrap !== 'undefined' && typeof bootstrap.Modal !== 'undefined') {
                    new bootstrap.Modal(document.getElementById('modalEditMemberProfile')).show();
                }
            });
        });

        document.querySelectorAll('.btn-confirm-remove').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                var formId = this.getAttribute('data-form-id');
                var form = formId ? document.getElementById(formId) : this.closest('form');
                var email = this.getAttribute('data-email') || 'this member';
                var name = this.getAttribute('data-name');
                var displayName = (name && name !== 'Member') 
                    ? `<strong>${name}</strong> (${email})` 
                    : `<strong>${email}</strong>`;

                Swal.fire({
                    title: 'Remove Team Member?',
                    html: `Are you sure you want to remove ${displayName} from your team?<br><br><span style="font-size: 13.5px; color: #64748b;">Their access to this institutional subscription will be revoked immediately and their seat will be freed up.</span>`,
                    icon: 'warning',
                    showCancelButton: true,
                    showDenyButton: false,
                    confirmButtonColor: '#e85347',
                    cancelButtonColor: '#6e829f',
                    confirmButtonText: '<em class="icon ni ni-trash mr-1"></em> Yes, Remove',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                    focusCancel: true,
                    customClass: {
                        actions: 'swal2-actions-row',
                        confirmButton: 'swal2-confirm-btn',
                        cancelButton: 'swal2-cancel-btn'
                    }
                }).then(function(result) {
                    if (result.isConfirmed && form) {
                        Swal.fire({
                            title: 'Removing Member...',
                            html: '<span style="font-size: 14px; color: #64748b;">Please wait while we update your team.</span>',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            showCancelButton: false,
                            didOpen: function() {
                                Swal.showLoading();
                            }
                        });
                        form.submit();
                    }
                });
            });
        });

        // Add Member form live validation, user existence check & submit spinner
        var inviteForm = document.getElementById('add_member_form');
        var emailInput = document.getElementById('member_email');
        var roleSelect = document.getElementById('member_role');
        var facultyInput = document.getElementById('member_faculty');
        var departmentInput = document.getElementById('member_department');
        var functionInput = document.getElementById('member_function');
        var submitBtn = document.getElementById('btn_submit_member');

        var emailIndicator = document.getElementById('email_status_indicator');
        var emailSpinner = document.getElementById('email_spinner');
        var emailSuccessIcon = document.getElementById('email_success_icon');
        var emailErrorIcon = document.getElementById('email_error_icon');
        var emailFeedback = document.getElementById('email_live_feedback');
        var emailDefaultHint = document.getElementById('email_default_hint');

        var isEmailVerified = false;
        var checkTimer = null;
        var currentRequestEmail = '';

        function checkFormValidity() {
            if (!submitBtn) return;
            var emailVal = emailInput ? emailInput.value.trim() : '';
            var roleVal = roleSelect ? roleSelect.value.trim() : '';
            var facultyVal = facultyInput ? facultyInput.value.trim() : '';
            var departmentVal = departmentInput ? departmentInput.value.trim() : '';
            var functionVal = functionInput ? functionInput.value.trim() : '';

            var allRequiredFilled = emailVal.length > 0 && roleVal.length > 0 && facultyVal.length > 0 && departmentVal.length > 0 && functionVal.length > 0;

            if (allRequiredFilled && isEmailVerified) {
                submitBtn.disabled = false;
                submitBtn.title = '';
            } else {
                submitBtn.disabled = true;
                if (!allRequiredFilled) {
                    submitBtn.title = 'Please fill all required profiling fields.';
                } else if (!isEmailVerified) {
                    submitBtn.title = 'Member email must be verified on the FMRR Portal before adding.';
                }
            }
        }

        function setEmailStatus(state, message) {
            if (!emailIndicator) return;
            emailIndicator.style.display = 'block';
            emailSpinner.style.display = 'none';
            emailSuccessIcon.style.display = 'none';
            emailErrorIcon.style.display = 'none';

            if (state === 'checking') {
                emailSpinner.style.display = 'inline-block';
                emailInput.style.borderColor = '#93c5fd';
                emailInput.style.boxShadow = '0 0 0 3px rgba(59, 130, 246, 0.15)';
                emailFeedback.style.display = 'block';
                emailFeedback.innerHTML = '<span style="color: #2563eb; font-weight: 500;"><em class="icon ni ni-loader mr-1"></em> Checking FMRR Portal user directory...</span>';
                if (emailDefaultHint) emailDefaultHint.style.display = 'none';
                isEmailVerified = false;
            } else if (state === 'valid') {
                emailSuccessIcon.style.display = 'inline-block';
                emailInput.style.borderColor = '#10b981';
                emailInput.style.boxShadow = '0 0 0 3px rgba(16, 185, 129, 0.18)';
                emailFeedback.style.display = 'block';
                emailFeedback.innerHTML = '<span style="color: #059669; font-weight: 600;"><em class="icon ni ni-check-circle mr-1"></em> ' + message + '</span>';
                if (emailDefaultHint) emailDefaultHint.style.display = 'none';
                isEmailVerified = true;
            } else if (state === 'invalid') {
                emailErrorIcon.style.display = 'inline-block';
                emailInput.style.borderColor = '#ef4444';
                emailInput.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.18)';
                emailFeedback.style.display = 'block';
                emailFeedback.innerHTML = '<span style="color: #dc2626; font-weight: 500;"><em class="icon ni ni-alert-circle mr-1"></em> ' + message + '</span>';
                if (emailDefaultHint) emailDefaultHint.style.display = 'none';
                isEmailVerified = false;
            } else {
                emailIndicator.style.display = 'none';
                emailInput.style.borderColor = '#cbd5e1';
                emailInput.style.boxShadow = 'none';
                emailFeedback.style.display = 'none';
                if (emailDefaultHint) emailDefaultHint.style.display = 'block';
                isEmailVerified = false;
            }
            checkFormValidity();
        }

        function performUserCheck(email) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                setEmailStatus('invalid', 'Please enter a valid email address.');
                return;
            }

            currentRequestEmail = email.toLowerCase();
            setEmailStatus('checking', '');

            fetch('{{ route('institutionalMember.checkUser') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email: email })
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (emailInput.value.trim().toLowerCase() !== currentRequestEmail) {
                    return;
                }
                if (data.exists) {
                    setEmailStatus('valid', data.message || 'Registered user verified: ' + data.user_name);
                } else {
                    setEmailStatus('invalid', data.message || 'No registered user found with this email.');
                }
            })
            .catch(function(err) {
                if (emailInput.value.trim().toLowerCase() === currentRequestEmail) {
                    setEmailStatus('invalid', 'Could not verify user at this time. Please try again.');
                }
            });
        }

        if (emailInput) {
            emailInput.addEventListener('input', function() {
                var val = this.value.trim();
                isEmailVerified = false;
                checkFormValidity();
                clearTimeout(checkTimer);

                if (val.length === 0) {
                    setEmailStatus('reset', '');
                    return;
                }

                checkTimer = setTimeout(function() {
                    performUserCheck(val);
                }, 350);
            });

            emailInput.addEventListener('blur', function() {
                var val = this.value.trim();
                if (val.length > 0 && !isEmailVerified) {
                    clearTimeout(checkTimer);
                    performUserCheck(val);
                }
            });

            if (emailInput.value.trim().length > 0) {
                performUserCheck(emailInput.value.trim());
            }
        }

        [roleSelect, facultyInput, departmentInput, functionInput].forEach(function(el) {
            if (el) {
                el.addEventListener('input', checkFormValidity);
                el.addEventListener('change', checkFormValidity);
            }
        });

        checkFormValidity();

        if (inviteForm) {
            inviteForm.addEventListener('submit', function(e) {
                if (submitBtn.disabled || !isEmailVerified) {
                    e.preventDefault();
                    return false;
                }
                submitBtn.style.opacity = '0.85';
                submitBtn.style.cursor = 'wait';
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true" style="width: 15px; height: 15px; border-width: 2px; vertical-align: -2px;"></span> Adding &amp; Profiling Member...';
                setTimeout(function() {
                    submitBtn.disabled = true;
                }, 10);
            });
        }
    });
</script>
@endsection
