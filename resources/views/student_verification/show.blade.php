@extends('layouts.master')

@section('content')
@php
    $showPlan = $verification->plan;
    $showPlanName = optional($showPlan)->name ?? 'Academic Subscription';
    $showIsComplimentary = $showPlan
        ? ((float) ($showPlan->price ?? 0) <= 0 && (float) ($showPlan->price_usd ?? 0) <= 0)
        : false;
    $showDuration = optional($showPlan)->duration ?? 30;
@endphp

<style>
    .sv-show-page {
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }
    .sv-card {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04) !important;
    }
    .sv-avatar-lg {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        background: #eef2f7;
        color: #0c2b70;
        font-size: 22px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1.5px solid #dbe4f0;
    }
    .sv-overline {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        color: #64748b !important;
    }
    .sv-pill-neutral {
        display: inline-flex;
        align-items: center;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 2px 8px;
        font-size: 11.5px;
        font-weight: 600;
    }
    .sv-status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12.5px;
        font-weight: 600;
        white-space: nowrap;
    }
    .sv-status-pending {
        background: #fef9ec;
        color: #b45309;
        border: 1px solid #fde68a;
    }
    .sv-status-approved {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }
    .sv-status-rejected {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }
    .sv-btn-navy {
        background: #0c2b70 !important;
        border-color: #0c2b70 !important;
        color: #ffffff !important;
        font-weight: 600;
    }
    .sv-btn-navy:hover {
        background: #143ca3 !important;
        border-color: #143ca3 !important;
        color: #ffffff !important;
    }
    .sv-btn-neutral {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        color: #334155 !important;
        font-weight: 600;
    }
    .sv-btn-neutral:hover {
        background: #f8fafc !important;
        border-color: #94a3b8 !important;
        color: #0f172a !important;
    }
    .sv-btn-reject-soft {
        background: #ffffff !important;
        border: 1px solid #fecaca !important;
        color: #dc2626 !important;
        font-weight: 600;
    }
    .sv-btn-reject-soft:hover {
        background: #fef2f2 !important;
        border-color: #fca5a5 !important;
        color: #b91c1c !important;
    }
    .sv-quick-chip {
        background: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        color: #334155 !important;
        border-radius: 20px !important;
        padding: 5px 12px !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        transition: all 0.15s ease;
    }
    .sv-quick-chip:hover {
        background: #eef2ff !important;
        border-color: #c7d2fe !important;
        color: #0c2b70 !important;
    }
</style>

<div class="nk-content sv-show-page">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">

                <!-- Breadcrumb & Top Bar -->
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between align-items-center">
                        <div class="nk-block-head-content">
                            <nav>
                                <ul class="breadcrumb breadcrumb-arrow mb-2">
                                    <li class="breadcrumb-item"><a href="{{ route('studentVerification.index') }}" style="color: #64748b;">Academic Verification</a></li>
                                    <li class="breadcrumb-item active" style="color: #0c2b70;">Application #{{ $verification->id }}</li>
                                </ul>
                            </nav>
                            <h3 class="nk-block-title page-title" style="color: #0f172a; font-weight: 700;">
                                {{ optional($verification->applicant)->name ?? 'Academic Application' }}
                            </h3>
                            <div class="nk-block-des text-soft">
                                <p style="color: #64748b;">Submitted on {{ $verification->created_at->format('M d, Y h:i A') }} ({{ $verification->created_at->diffForHumans() }})</p>
                            </div>
                        </div>
                        <div class="nk-block-head-content d-flex align-items-center flex-wrap" style="gap: 10px;">
                            <a href="{{ route('studentVerification.index') }}" class="btn btn-sm sv-btn-neutral">
                                <em class="icon ni ni-arrow-left mr-1"></em> Back to All Applications
                            </a>
                            @if ($verification->status == 0)
                                <span class="sv-status-pill sv-status-pending">
                                    <em class="icon ni ni-clock"></em> Pending Verification
                                </span>
                            @elseif ($verification->status == 1)
                                <span class="sv-status-pill sv-status-approved">
                                    <em class="icon ni ni-check-circle"></em> Approved &amp; Verified
                                </span>
                            @else
                                <span class="sv-status-pill sv-status-rejected">
                                    <em class="icon ni ni-cross-circle"></em> Rejected
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Session Alerts -->
                @if (session('success'))
                    <div class="alert alert-success alert-icon alert-dismissible mb-4">
                        <em class="icon ni ni-check-circle"></em>
                        <strong>{{ session('success') }}</strong>
                        <button class="close" data-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-icon alert-dismissible mb-4">
                        <em class="icon ni ni-alert-circle"></em>
                        <strong>{{ session('error') }}</strong>
                        <button class="close" data-dismiss="alert"></button>
                    </div>
                @endif

                @if (isset($errors) && $errors->any())
                    <div class="alert alert-danger alert-dismissible mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button class="close" data-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Two-Column Layout -->
                <div class="row g-gs">

                    <!-- Left Column: Details & Decision Action -->
                    <div class="col-lg-5">

                        <!-- Applicant & Academic Details Card -->
                        <div class="card sv-card mb-4">
                            <div class="card-inner">
                                <div class="user-card user-card-s2 mb-3">
                                    <div class="sv-avatar-lg">
                                        <span>{{ strtoupper(substr(optional($verification->applicant)->name ?? 'U', 0, 2)) }}</span>
                                    </div>
                                    <div class="user-info">
                                        <h5 class="title mt-2 mb-1" style="color: #0f172a; font-weight: 700;">{{ optional($verification->applicant)->name ?? 'Unknown Applicant' }}</h5>
                                        <span class="sub-text" style="color: #64748b;">
                                            <a href="mailto:{{ optional($verification->applicant)->email }}" style="color: #64748b;">{{ optional($verification->applicant)->email }}</a>
                                        </span>
                                    </div>
                                </div>

                                <h6 class="sv-overline mb-3 mt-4">Academic Onboarding Information</h6>
                                <table class="table table-sm table-borderless">
                                    <tbody>
                                        <tr>
                                            <td style="width: 40%; color: #64748b;">Institution:</td>
                                            <td class="font-weight-bold" style="color: #0f172a;">
                                                <em class="icon ni ni-building mr-1" style="color: #64748b;"></em>
                                                {{ $verification->institution_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b;">Faculty / Dept:</td>
                                            <td class="font-weight-bold" style="color: #1e293b;">
                                                <em class="icon ni ni-folder mr-1" style="color: #64748b;"></em>
                                                {{ $verification->faculty_department ?? 'Not specified' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b;">Academic Role:</td>
                                            <td>
                                                <span class="sv-pill-neutral">
                                                    <em class="icon ni ni-user-check mr-1"></em>
                                                    {{ $verification->role_within_institution ?? 'Academic Applicant' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b;">Institutional Email:</td>
                                            <td>
                                                @if ($verification->institutional_email)
                                                    <a href="mailto:{{ $verification->institutional_email }}" class="font-weight-bold" style="color: #0c2b70;">
                                                        <em class="icon ni ni-mail mr-1"></em>{{ $verification->institutional_email }}
                                                    </a>
                                                    @if ($verification->status == 1)
                                                        <span class="d-block mt-1" style="font-size: 11px; color: #059669; font-weight: 500;">&bull; Transitioned</span>
                                                    @else
                                                        <span class="d-block mt-1" style="font-size: 11px; color: #64748b;">&bull; Target Transition</span>
                                                    @endif
                                                @else
                                                    <span style="color: #94a3b8;">Not specified</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b;">ID / Matric / Staff No:</td>
                                            <td>
                                                @if ($verification->student_id_number)
                                                    <span class="sv-pill-neutral">
                                                        {{ $verification->student_id_number }}
                                                    </span>
                                                @else
                                                    <span style="color: #94a3b8;">Not specified</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b;">Target Program / Plan:</td>
                                            <td>
                                                <span class="font-weight-bold" style="color: #0f172a;">{{ $showPlanName }}</span>
                                                @if (optional(optional($verification->plan)->subTier)->name)
                                                    <span class="sv-pill-neutral ml-1">{{ $verification->plan->subTier->name }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b;">Submitted On:</td>
                                            <td style="color: #1e293b;">{{ $verification->created_at->format('M d, Y h:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b;">Account Registered:</td>
                                            <td style="color: #1e293b;">{{ optional($verification->applicant)->created_at ? optional($verification->applicant)->created_at->format('M d, Y') : 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Verification Status & Review Record Card -->
                        <div class="card sv-card mb-4">
                            <div class="card-inner">
                                <h6 class="sv-overline mb-3">Verification &amp; Decision Status</h6>

                                @if ($verification->status == 0)
                                    <div class="p-3 rounded mb-3" style="background: #fef9ec; border: 1px solid #fde68a; color: #92400e;">
                                        <div class="d-flex align-items-start">
                                            <em class="icon ni ni-clock mr-2 mt-1" style="font-size: 18px; color: #b45309;"></em>
                                            <div>
                                                <strong style="color: #78350f;">Awaiting Verification</strong><br>
                                                <span style="font-size: 13px; color: #92400e;">Review the uploaded verification document on the right to approve or reject this application.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="mt-4 pt-3 border-top">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <button type="button" class="btn sv-btn-reject-soft btn-block" data-toggle="modal" data-target="#rejectModal">
                                                    <em class="icon ni ni-cross mr-1"></em> Reject Application
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" class="btn sv-btn-navy btn-block" id="btnApproveShow">
                                                    <em class="icon ni ni-check mr-1"></em> {{ $showIsComplimentary ? 'Approve & Grant' : 'Verify & Approve' }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @elseif ($verification->status == 1)
                                    <div class="p-3 rounded mb-3" style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46;">
                                        <div class="d-flex align-items-start">
                                            <em class="icon ni ni-check-circle mr-2 mt-1" style="font-size: 18px; color: #059669;"></em>
                                            <div>
                                                <strong style="color: #064e3b;">Application Approved</strong><br>
                                                <span style="font-size: 13px; color: #047857;">
                                                    {{ $showIsComplimentary ? "{$showDuration}-Day complimentary view-only access is currently active." : 'Academic affiliation verified. Applicant can proceed with subscription access.' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <table class="table table-sm table-borderless mt-3">
                                        <tbody>
                                            <tr>
                                                <td style="width: 40%; color: #64748b;">Reviewed By:</td>
                                                <td class="font-weight-bold" style="color: #0f172a;">{{ optional($verification->reviewer)->name ?? 'Administrator' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #64748b;">Decision Date:</td>
                                                <td style="color: #1e293b;">{{ $verification->updated_at->format('M d, Y h:i A') }}</td>
                                            </tr>
                                            @if ($verification->subscription)
                                                <tr>
                                                    <td style="color: #64748b;">Access Active From:</td>
                                                    <td class="font-weight-bold" style="color: #047857;">{{ str_replace('May.', 'May', \Carbon\Carbon::parse($verification->subscription->start_date)->format('M. d, Y')) }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="color: #64748b;">Access Expires On:</td>
                                                    <td class="font-weight-bold" style="color: #0c2b70;">{{ str_replace('May.', 'May', \Carbon\Carbon::parse($verification->subscription->end_date)->format('M. d, Y')) }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                @else
                                    <div class="p-3 rounded mb-3" style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b;">
                                        <div class="d-flex align-items-start">
                                            <em class="icon ni ni-cross-circle mr-2 mt-1" style="font-size: 18px; color: #dc2626;"></em>
                                            <div>
                                                <strong style="color: #7f1d1d;">Application Rejected</strong><br>
                                                <span style="font-size: 13px; color: #b91c1c;">The applicant has been notified of the rejection feedback.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <table class="table table-sm table-borderless mt-3">
                                        <tbody>
                                            <tr>
                                                <td style="width: 40%; color: #64748b;">Reviewed By:</td>
                                                <td class="font-weight-bold" style="color: #0f172a;">{{ optional($verification->reviewer)->name ?? 'Administrator' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #64748b;">Decision Date:</td>
                                                <td style="color: #1e293b;">{{ $verification->updated_at->format('M d, Y h:i A') }}</td>
                                            </tr>
                                            @if ($verification->note)
                                                <tr>
                                                    <td style="color: #64748b;">Rejection Reason:</td>
                                                    <td>
                                                        <div class="p-2 rounded bg-lighter border text-danger" style="font-size: 13px; font-style: italic;">
                                                            "{{ $verification->note }}"
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Academic Verification Document Preview -->
                    <div class="col-lg-7">
                        <div class="card sv-card h-100">
                            <div class="card-inner border-bottom py-3">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <div>
                                        <h6 class="card-title mb-0" style="color: #0f172a; font-weight: 700;">
                                            <em class="icon ni ni-file-docs mr-1" style="color: #0c2b70;"></em>
                                            Academic Verification Document
                                        </h6>
                                        <span class="small" style="color: #64748b;">{{ basename($verification->proof_path) }}</span>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('studentVerification.preview', $verification->id) }}" target="_blank" class="btn sv-btn-navy btn-sm">
                                            <em class="icon ni ni-external mr-1"></em> Open in Full Window
                                        </a>
                                        <a href="{{ route('studentVerification.proof', $verification->id) }}" class="btn sv-btn-neutral btn-sm">
                                            <em class="icon ni ni-download mr-1"></em> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner p-3">
                                @php
                                    $extension = strtolower(pathinfo($verification->proof_path, PATHINFO_EXTENSION));
                                    $isPdf = $extension === 'pdf';
                                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
                                @endphp

                                @if ($isPdf)
                                    <!-- PDF Embedded Viewer -->
                                    <div class="embed-responsive border rounded" style="height: 650px; border-color: #e2e8f0 !important;">
                                        <iframe src="{{ route('studentVerification.preview', $verification->id) }}" class="w-100 h-100 border-0" title="Academic Verification PDF"></iframe>
                                    </div>
                                @elseif ($isImage)
                                    <!-- Image Preview -->
                                    <div class="text-center p-3 rounded" style="background: #0f172a; max-height: 650px; overflow: auto;">
                                        <a href="{{ route('studentVerification.preview', $verification->id) }}" target="_blank">
                                            <img src="{{ route('studentVerification.preview', $verification->id) }}" alt="Verification Document" class="img-fluid rounded" style="max-height: 620px; box-shadow: 0 4px 15px rgba(0,0,0,0.35);">
                                        </a>
                                    </div>
                                @else
                                    <!-- Generic File Fallback -->
                                    <div class="text-center py-5">
                                        <div style="width: 70px; height: 70px; border-radius: 50%; background: #eef2ff; color: #0c2b70; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                                            <em class="icon ni ni-file-docs" style="font-size: 32px;"></em>
                                        </div>
                                        <h5>{{ basename($verification->proof_path) }}</h5>
                                        <p class="text-muted">Click below to open or download the document.</p>
                                        <div class="btn-group mt-3">
                                            <a href="{{ route('studentVerification.preview', $verification->id) }}" target="_blank" class="btn sv-btn-navy">
                                                <em class="icon ni ni-eye mr-1"></em> Preview
                                            </a>
                                            <a href="{{ route('studentVerification.proof', $verification->id) }}" class="btn sv-btn-neutral">
                                                <em class="icon ni ni-download mr-1"></em> Download
                                            </a>
                                        </div>
                                    </div>
                                @endif


                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<!-- Hidden Approval Form -->
<form id="approve-form" action="{{ route('studentVerification.approve', $verification->id) }}" method="POST" class="d-none">
    @csrf
</form>

<!-- Rejection Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 20px 50px rgba(15, 23, 42, 0.2);">
            <div class="modal-header bg-white border-bottom py-3 px-4">
                <h5 class="modal-title d-flex align-items-center" style="color: #0f172a; font-weight: 700; font-size: 16px;">
                    <span class="d-inline-flex align-items-center justify-content-center mr-2" style="width: 30px; height: 30px; border-radius: 50%; background: #fef2f2; color: #dc2626;">
                        <em class="icon ni ni-alert-circle"></em>
                    </span>
                    Reject Academic Application
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <em class="icon ni ni-cross"></em>
                </button>
            </div>
            <form method="POST" action="{{ route('studentVerification.reject', $verification->id) }}">
                @csrf
                <div class="modal-body p-4">
                    <p class="mb-3" style="font-size: 13.5px; color: #475569; line-height: 1.55;">
                        Specify the reason for rejecting <strong>{{ optional($verification->applicant)->name }}</strong>'s application for <strong>{{ $showPlanName }}</strong>. This explanation will be emailed directly to the applicant.
                    </p>

                    <div class="form-group mb-3" style="display: block; clear: both;">
                        <label class="form-label d-block mb-2" style="font-size: 12px; font-weight: 600; color: #64748b;">
                            Quick Suggestion Tags (Click to insert):
                        </label>
                        <div class="quick-tags-container" style="display: flex; flex-wrap: wrap; gap: 6px;">
                            <button type="button" class="btn btn-xs sv-quick-chip quick-tag" data-text="The uploaded document does not clearly confirm active academic affiliation for the current session.">
                                Not Current Session
                            </button>
                            <button type="button" class="btn btn-xs sv-quick-chip quick-tag" data-text="The uploaded institutional ID or academic affiliation document is blurry or unreadable. Please upload a clear photo or PDF scan.">
                                Blurry / Unreadable
                            </button>
                            <button type="button" class="btn btn-xs sv-quick-chip quick-tag" data-text="The name on the academic proof does not match your registered account name.">
                                Name Mismatch
                            </button>
                            <button type="button" class="btn btn-xs sv-quick-chip quick-tag" data-text="The academic institution could not be verified as an eligible tertiary university or recognized research faculty.">
                                Unverified Institution
                            </button>
                        </div>
                    </div>

                    <div class="form-group pt-2 mb-0" style="display: block; clear: both;">
                        <label class="form-label d-block mb-1" for="rejectionNote" style="font-size: 13px; font-weight: 600; color: #1e293b;">
                            Rejection Reason &amp; Feedback <span class="text-danger">*</span>
                        </label>
                        <textarea required class="form-control" style="border-radius: 10px; border-color: #cbd5e1;" name="note" id="rejectionNote" rows="4" placeholder="Enter specific feedback explaining why this document could not be verified..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light py-3 px-4 border-top">
                    <button type="button" class="btn sv-btn-neutral" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" style="font-weight: 600;">
                        <em class="icon ni ni-cross mr-1"></em> Confirm Rejection &amp; Send Email
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
        // Quick suggestion tag inserter
        document.querySelectorAll('.quick-tag').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var textarea = document.getElementById('rejectionNote');
                if (textarea) {
                    textarea.value = this.dataset.text;
                    textarea.focus();
                }
            });
        });

        // SweetAlert approval confirmation
        var approveBtn = document.getElementById('btnApproveShow');
        if (approveBtn) {
            approveBtn.addEventListener('click', function(e) {
                e.preventDefault();
                @php
                    $showPlan = $verification->plan;
                    $showPlanName = optional($showPlan)->name ?? 'Academic Subscription';
                    $showIsComplimentary = $showPlan
                        ? ((float) ($showPlan->price ?? 0) <= 0 && (float) ($showPlan->price_usd ?? 0) <= 0)
                        : false;
                    $showDuration = optional($showPlan)->duration ?? 30;
                @endphp
                var studentName = "{{ addslashes(optional($verification->applicant)->name ?? 'this applicant') }}";
                var instEmail = "{{ addslashes($verification->institutional_email ?? optional($verification->applicant)->email) }}";
                var planName = "{{ addslashes($showPlanName) }}";
                var isComplimentary = {{ $showIsComplimentary ? 'true' : 'false' }};
                var duration = "{{ $showDuration }}";

                var modalTitle = isComplimentary
                    ? 'Approve Student Research Application?'
                    : 'Approve Academic Verification?';

                var modalHtml = isComplimentary
                    ? `Are you sure you want to verify and approve <strong>${studentName}</strong> for <strong>${planName}</strong>?<br><br><span style="font-size: 13.5px; color: #526484;">This will immediately grant <strong>${duration} days of complimentary view-only access</strong>, transition the account email to <code>${instEmail}</code>, and send an approval notification email.</span>`
                    : `Are you sure you want to verify and approve <strong>${studentName}</strong> for <strong>${planName}</strong>?<br><br><span style="font-size: 13.5px; color: #526484;">This will confirm academic affiliation, <strong>unlock their ability to proceed with subscription payment</strong>, and <strong>transition the user's account registration email to <code>${instEmail}</code></strong>.</span>`;

                var confirmBtnText = isComplimentary
                    ? '<em class="icon ni ni-check mr-1"></em> Yes, Approve & Grant Access'
                    : '<em class="icon ni ni-check mr-1"></em> Yes, Verify & Approve';

                var loadingText = isComplimentary
                    ? `Activating ${duration}-day complimentary access grant and sending notification email.`
                    : 'Updating account email, verifying affiliation, unlocking payment access, and sending notification email.';

                Swal.fire({
                    title: modalTitle,
                    html: modalHtml,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#6e829f',
                    confirmButtonText: confirmBtnText,
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Approving Application...',
                            text: loadingText,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        document.getElementById('approve-form').submit();
                    }
                });
            });
        }
    });
</script>
@endsection
