@extends('layouts.master')

@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">

                <!-- Breadcrumb & Top Bar -->
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between align-items-center">
                        <div class="nk-block-head-content">
                            <nav>
                                <ul class="breadcrumb breadcrumb-arrow mb-2">
                                    <li class="breadcrumb-item"><a href="{{ route('studentVerification.index') }}">Student Verification</a></li>
                                    <li class="breadcrumb-item active">Application #{{ $verification->id }}</li>
                                </ul>
                            </nav>
                            <h3 class="nk-block-title page-title">
                                {{ optional($verification->applicant)->name ?? 'Student Application' }}
                            </h3>
                            <div class="nk-block-des text-soft">
                                <p>Submitted on {{ $verification->created_at->format('M d, Y h:i A') }} ({{ $verification->created_at->diffForHumans() }})</p>
                            </div>
                        </div>
                        <div class="nk-block-head-content">
                            <a href="{{ route('studentVerification.index') }}" class="btn btn-outline-light mr-2">
                                <em class="icon ni ni-arrow-left mr-1"></em> Back to All Applications
                            </a>
                            @if ($verification->status == 0)
                                <span class="badge badge-dim badge-warning px-3 py-2" style="font-size: 13px;">
                                    <em class="icon ni ni-clock mr-1"></em> Pending Verification
                                </span>
                            @elseif ($verification->status == 1)
                                <span class="badge badge-dim badge-success px-3 py-2" style="font-size: 13px;">
                                    <em class="icon ni ni-check-circle mr-1"></em> Approved &bull; Active Access
                                </span>
                            @else
                                <span class="badge badge-dim badge-danger px-3 py-2" style="font-size: 13px;">
                                    <em class="icon ni ni-cross-circle mr-1"></em> Rejected
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
                        <div class="card card-bordered mb-4">
                            <div class="card-inner">
                                <div class="user-card user-card-s2 mb-3">
                                    <div class="user-avatar lg bg-primary-dim text-primary" style="font-size: 20px; font-weight: 700;">
                                        <span>{{ strtoupper(substr(optional($verification->applicant)->name ?? 'U', 0, 2)) }}</span>
                                    </div>
                                    <div class="user-info">
                                        <h5 class="title mt-2 mb-1">{{ optional($verification->applicant)->name ?? 'Unknown Student' }}</h5>
                                        <span class="sub-text text-muted">
                                            <a href="mailto:{{ optional($verification->applicant)->email }}">{{ optional($verification->applicant)->email }}</a>
                                        </span>
                                    </div>
                                </div>

                                <h6 class="overline-title text-primary-alt mb-3 mt-4">Academic Onboarding Information</h6>
                                <table class="table table-sm table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="text-muted" style="width: 40%;">Institution:</td>
                                            <td class="font-weight-bold">
                                                <em class="icon ni ni-building text-primary mr-1"></em>
                                                {{ $verification->institution_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Faculty / Dept:</td>
                                            <td class="font-weight-bold text-dark">
                                                <em class="icon ni ni-folder text-info mr-1"></em>
                                                {{ $verification->faculty_department ?? 'Not specified' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Academic Role:</td>
                                            <td>
                                                <span class="badge badge-dim badge-outline-primary font-weight-bold">
                                                    <em class="icon ni ni-user-check mr-1"></em>
                                                    {{ $verification->role_within_institution ?? 'Student' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Institutional Email:</td>
                                            <td>
                                                @if ($verification->institutional_email)
                                                    <a href="mailto:{{ $verification->institutional_email }}" class="font-weight-bold text-primary">
                                                        <em class="icon ni ni-mail mr-1"></em>{{ $verification->institutional_email }}
                                                    </a>
                                                    @if ($verification->status == 1)
                                                        <span class="badge badge-dot badge-success ml-1" title="Account transitioned to this email">Transitioned</span>
                                                    @else
                                                        <span class="badge badge-dim badge-info ml-1" style="font-size: 10.5px;" title="Account will transition to this email upon approval">Target Transition</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">Not specified</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">ID / Matric / Staff No:</td>
                                            <td class="font-weight-bold">
                                                @if ($verification->student_id_number)
                                                    <span class="badge badge-dim badge-outline-secondary font-weight-normal">
                                                        {{ $verification->student_id_number }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">Not specified</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Target Program / Plan:</td>
                                            <td class="font-weight-bold text-primary">
                                                {{ optional($verification->plan)->name ?? 'Academic Subscription Access' }}
                                                @if (optional(optional($verification->plan)->subTier)->name)
                                                    <span class="badge badge-dim badge-outline-primary ml-1">{{ $verification->plan->subTier->name }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Submitted On:</td>
                                            <td>{{ $verification->created_at->format('M d, Y h:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Account Registered:</td>
                                            <td>{{ optional($verification->applicant)->created_at ? optional($verification->applicant)->created_at->format('M d, Y') : 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Verification Status & Review Record Card -->
                        <div class="card card-bordered mb-4">
                            <div class="card-inner">
                                <h6 class="overline-title text-primary-alt mb-3">Verification &amp; Decision Status</h6>

                                @if ($verification->status == 0)
                                    <div class="alert alert-warning" style="background: #fef8e4; border-color: #f7e4a8; color: #ad8e4f;">
                                        <div class="d-flex align-items-center">
                                            <em class="icon ni ni-clock mr-2" style="font-size: 20px;"></em>
                                            <div>
                                                <strong>Awaiting Verification</strong><br>
                                                <span style="font-size: 13px;">Review the uploaded proof document on the right to approve or reject this application.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="mt-4 pt-2 border-top">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <button type="button" class="btn btn-outline-danger btn-block" data-toggle="modal" data-target="#rejectModal">
                                                    <em class="icon ni ni-cross mr-1"></em> Reject Application
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" class="btn btn-success btn-block" id="btnApproveShow">
                                                    <em class="icon ni ni-check mr-1"></em> Approve &amp; Grant
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @elseif ($verification->status == 1)
                                    <div class="alert alert-success" style="background: #e6f8f3; border-color: #a4ebd8; color: #1ee0ac;">
                                        <div class="d-flex align-items-center">
                                            <em class="icon ni ni-check-circle mr-2" style="font-size: 22px;"></em>
                                            <div>
                                                <strong style="color: #0d8263;">Application Approved</strong><br>
                                                <span style="font-size: 13px; color: #1c5e4d;">30-Day complimentary view-only access is currently active.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <table class="table table-sm table-borderless mt-3">
                                        <tbody>
                                            <tr>
                                                <td class="text-muted" style="width: 40%;">Reviewed By:</td>
                                                <td class="font-weight-bold">{{ optional($verification->reviewer)->name ?? 'Administrator' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Decision Date:</td>
                                                <td>{{ $verification->updated_at->format('M d, Y h:i A') }}</td>
                                            </tr>
                                            @if ($verification->subscription)
                                                <tr>
                                                    <td class="text-muted">Access Active From:</td>
                                                    <td class="font-weight-bold text-success">{{ str_replace('May.', 'May', \Carbon\Carbon::parse($verification->subscription->start_date)->format('M. d, Y')) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Access Expires On:</td>
                                                    <td class="font-weight-bold text-primary">{{ str_replace('May.', 'May', \Carbon\Carbon::parse($verification->subscription->end_date)->format('M. d, Y')) }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                @else
                                    <div class="alert alert-danger" style="background: #fdeeee; border-color: #f6b8b8; color: #e85347;">
                                        <div class="d-flex align-items-center">
                                            <em class="icon ni ni-cross-circle mr-2" style="font-size: 22px;"></em>
                                            <div>
                                                <strong style="color: #9c271d;">Application Rejected</strong><br>
                                                <span style="font-size: 13px; color: #7f221a;">The applicant has been notified of the rejection feedback.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <table class="table table-sm table-borderless mt-3">
                                        <tbody>
                                            <tr>
                                                <td class="text-muted" style="width: 40%;">Reviewed By:</td>
                                                <td class="font-weight-bold">{{ optional($verification->reviewer)->name ?? 'Administrator' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Decision Date:</td>
                                                <td>{{ $verification->updated_at->format('M d, Y h:i A') }}</td>
                                            </tr>
                                            @if ($verification->note)
                                                <tr>
                                                    <td class="text-muted">Rejection Reason:</td>
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

                    <!-- Right Column: Proof of Enrollment Document Preview -->
                    <div class="col-lg-7">
                        <div class="card card-bordered h-100">
                            <div class="card-inner border-bottom py-3">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <div>
                                        <h6 class="card-title mb-0">
                                            <em class="icon ni ni-file-docs text-primary mr-1"></em>
                                            Proof of Enrollment Document
                                        </h6>
                                        <span class="text-muted small">{{ basename($verification->proof_path) }}</span>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('studentVerification.preview', $verification->id) }}" target="_blank" class="btn btn-primary btn-sm">
                                            <em class="icon ni ni-external mr-1"></em> Open in Full Window
                                        </a>
                                        <a href="{{ route('studentVerification.proof', $verification->id) }}" class="btn btn-outline-secondary btn-sm">
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
                                    <div class="embed-responsive border rounded" style="height: 650px;">
                                        <iframe src="{{ route('studentVerification.preview', $verification->id) }}" class="w-100 h-100 border-0" title="Proof of Enrollment PDF"></iframe>
                                    </div>
                                @elseif ($isImage)
                                    <!-- Image Preview -->
                                    <div class="text-center p-3 rounded" style="background: #1f2937; max-height: 650px; overflow: auto;">
                                        <a href="{{ route('studentVerification.preview', $verification->id) }}" target="_blank">
                                            <img src="{{ route('studentVerification.preview', $verification->id) }}" alt="Student Proof" class="img-fluid rounded" style="max-height: 620px; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">
                                        </a>
                                    </div>
                                @else
                                    <!-- Generic File Fallback -->
                                    <div class="text-center py-5">
                                        <div style="width: 70px; height: 70px; border-radius: 50%; background: #e5f3ff; color: #002060; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                                            <em class="icon ni ni-file-docs" style="font-size: 32px;"></em>
                                        </div>
                                        <h5>{{ basename($verification->proof_path) }}</h5>
                                        <p class="text-muted">Click below to open or download the document.</p>
                                        <div class="btn-group mt-3">
                                            <a href="{{ route('studentVerification.preview', $verification->id) }}" target="_blank" class="btn btn-primary">
                                                <em class="icon ni ni-eye mr-1"></em> Preview
                                            </a>
                                            <a href="{{ route('studentVerification.proof', $verification->id) }}" class="btn btn-outline-secondary">
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
        <div class="modal-content">
            <div class="modal-header bg-danger-dim">
                <h5 class="modal-title text-danger">
                    <em class="icon ni ni-alert-circle mr-1"></em>
                    Reject Student Application
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <em class="icon ni ni-cross"></em>
                </button>
            </div>
            <form method="POST" action="{{ route('studentVerification.reject', $verification->id) }}">
                @csrf
                <div class="modal-body">
                    <p class="text-soft mb-3" style="font-size: 13.5px;">
                        Specify the reason for rejecting <strong>{{ optional($verification->applicant)->name }}</strong>'s research application. This explanation will be emailed directly to the student.
                    </p>

                    <div class="form-group mb-3" style="display: block; clear: both;">
                        <label class="form-label text-muted d-block mb-1" style="font-size: 12px; font-weight: 600;">
                            Quick Suggestion Tags (Click to insert):
                        </label>
                        <div class="quick-tags-container" style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 4px;">
                            <button type="button" class="btn btn-xs btn-outline-light quick-tag" style="margin: 2px;" data-text="The uploaded document does not clearly confirm enrollment for the current academic session.">
                                Not Current Session
                            </button>
                            <button type="button" class="btn btn-xs btn-outline-light quick-tag" style="margin: 2px;" data-text="The uploaded Student ID / admission letter is blurry or unreadable. Please upload a clear photo or PDF scan.">
                                Blurry / Unreadable
                            </button>
                            <button type="button" class="btn btn-xs btn-outline-light quick-tag" style="margin: 2px;" data-text="The name on the academic proof does not match your registered account name.">
                                Name Mismatch
                            </button>
                            <button type="button" class="btn btn-xs btn-outline-light quick-tag" style="margin: 2px;" data-text="The academic institution could not be verified as an eligible tertiary university or research faculty.">
                                Unverified Institution
                            </button>
                        </div>
                    </div>

                    <div class="form-group pt-2" style="display: block; clear: both;">
                        <label class="form-label d-block mb-1" for="rejectionNote" style="font-size: 13px; font-weight: 600;">
                            Feedback for Student <span class="text-danger">*</span>
                        </label>
                        <textarea required class="form-control" name="note" id="rejectionNote" rows="4" placeholder="Enter feedback explaining why this document could not be verified..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
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
                var studentName = "{{ addslashes(optional($verification->applicant)->name ?? 'this applicant') }}";
                var instEmail = "{{ addslashes($verification->institutional_email ?? optional($verification->applicant)->email) }}";

                Swal.fire({
                    title: 'Approve Academic Verification?',
                    html: `Are you sure you want to verify and approve <strong>${studentName}</strong>?<br><br><span style="font-size: 13.5px; color: #526484;">This will confirm academic affiliation, grant access to academic subscription tiers, and <strong>transition the user's account registration email to <code>${instEmail}</code></strong>.</span>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#6e829f',
                    confirmButtonText: '<em class="icon ni ni-check mr-1"></em> Yes, Approve & Transition Email',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Approving Application...',
                            text: 'Updating account email, verifying affiliation, and sending notification email.',
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
