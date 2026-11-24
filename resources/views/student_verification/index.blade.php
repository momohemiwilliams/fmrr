@extends('layouts.master')

@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">

                <!-- Header -->
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between align-items-center">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Student Research Applications</h3>
                            <div class="nk-block-des text-soft">
                                <p>Manage, review, verify, approve, or reject student research verification applications.</p>
                            </div>
                        </div>
                        <div class="nk-block-head-content">
                            @if (($stats['pending'] ?? 0) > 0)
                                <span class="badge badge-dim badge-warning px-3 py-2" style="font-size: 13px;">
                                    <em class="icon ni ni-bell mr-1"></em> {{ $stats['pending'] }} Pending Review
                                </span>
                            @else
                                <span class="badge badge-dim badge-success px-3 py-2" style="font-size: 13px;">
                                    <em class="icon ni ni-check mr-1"></em> All Caught Up
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

                <!-- KPI / Stats Overview Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <a href="{{ route('studentVerification.index', ['status' => 'all']) }}" class="card card-bordered text-dark text-decoration-none">
                            <div class="card-inner py-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="text-muted text-uppercase" style="font-size: 11px; font-weight: 700; letter-spacing: 0.5px;">Total Applications</span>
                                        <h3 class="mt-1 mb-0" style="color: #002060; font-weight: 800;">{{ number_format($stats['total'] ?? 0) }}</h3>
                                    </div>
                                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #eef1f8; display: flex; align-items: center; justify-content: center; color: #002060;">
                                        <em class="icon ni ni-files" style="font-size: 22px;"></em>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('studentVerification.index', ['status' => '0']) }}" class="card card-bordered text-dark text-decoration-none" style="border-left: 4px solid #f59e0b !important;">
                            <div class="card-inner py-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="text-warning text-uppercase" style="font-size: 11px; font-weight: 700; letter-spacing: 0.5px;">Pending Review</span>
                                        <h3 class="mt-1 mb-0 text-warning" style="font-weight: 800;">{{ number_format($stats['pending'] ?? 0) }}</h3>
                                    </div>
                                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #fef3c7; display: flex; align-items: center; justify-content: center; color: #d97706;">
                                        <em class="icon ni ni-clock" style="font-size: 22px;"></em>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('studentVerification.index', ['status' => '1']) }}" class="card card-bordered text-dark text-decoration-none" style="border-left: 4px solid #10b981 !important;">
                            <div class="card-inner py-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="text-success text-uppercase" style="font-size: 11px; font-weight: 700; letter-spacing: 0.5px;">Approved Grants</span>
                                        <h3 class="mt-1 mb-0 text-success" style="font-weight: 800;">{{ number_format($stats['approved'] ?? 0) }}</h3>
                                    </div>
                                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #d1fae5; display: flex; align-items: center; justify-content: center; color: #059669;">
                                        <em class="icon ni ni-check-circle" style="font-size: 22px;"></em>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('studentVerification.index', ['status' => '2']) }}" class="card card-bordered text-dark text-decoration-none" style="border-left: 4px solid #ef4444 !important;">
                            <div class="card-inner py-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="text-danger text-uppercase" style="font-size: 11px; font-weight: 700; letter-spacing: 0.5px;">Rejected</span>
                                        <h3 class="mt-1 mb-0 text-danger" style="font-weight: 800;">{{ number_format($stats['rejected'] ?? 0) }}</h3>
                                    </div>
                                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #fee2e2; display: flex; align-items: center; justify-content: center; color: #dc2626;">
                                        <em class="icon ni ni-cross-circle" style="font-size: 22px;"></em>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Filters & Search Toolbar -->
                <div class="card card-bordered mb-4">
                    <div class="card-inner py-3">
                        <form action="{{ route('studentVerification.index') }}" method="GET" class="row g-3 align-items-center">
                            <!-- Status Tabs -->
                            <div class="col-lg-6 col-md-12">
                                <div class="btn-group btn-group-sm w-100" role="group">
                                    <a href="{{ route('studentVerification.index', array_merge(request()->except(['status', 'page']), ['status' => 'all'])) }}"
                                       class="btn {{ (!request()->has('status') || request('status') === 'all') ? 'btn-primary' : 'btn-outline-light' }}">
                                        All ({{ $stats['total'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('studentVerification.index', array_merge(request()->except(['status', 'page']), ['status' => '0'])) }}"
                                       class="btn {{ request('status') === '0' ? 'btn-warning text-white' : 'btn-outline-light' }}">
                                        Pending ({{ $stats['pending'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('studentVerification.index', array_merge(request()->except(['status', 'page']), ['status' => '1'])) }}"
                                       class="btn {{ request('status') === '1' ? 'btn-success text-white' : 'btn-outline-light' }}">
                                        Approved ({{ $stats['approved'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('studentVerification.index', array_merge(request()->except(['status', 'page']), ['status' => '2'])) }}"
                                       class="btn {{ request('status') === '2' ? 'btn-danger text-white' : 'btn-outline-light' }}">
                                        Rejected ({{ $stats['rejected'] ?? 0 }})
                                    </a>
                                </div>
                                <input type="hidden" name="status" value="{{ request('status', 'all') }}">
                            </div>

                            <!-- Search Input -->
                            <div class="col-lg-4 col-md-8">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-left">
                                        <em class="icon ni ni-search"></em>
                                    </div>
                                    <input type="text" name="search" class="form-control form-control-sm"
                                           placeholder="Search by student name, email, institution, ID..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="col-lg-2 col-md-4 text-right">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <em class="icon ni ni-filter"></em> Filter
                                </button>
                                @if (request()->filled('search') || (request()->has('status') && request('status') !== 'all'))
                                    <a href="{{ route('studentVerification.index') }}" class="btn btn-sm btn-outline-secondary ml-1" title="Clear Filters">
                                        <em class="icon ni ni-reload"></em>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Clean Applications Data Table -->
                <div class="card card-bordered card-preview">
                    <div class="card-inner p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Applicant</th>
                                        <th>Academic Affiliation &amp; Role</th>
                                        <th>Institutional Email</th>
                                        <th>Proof Document</th>
                                        <th>Submitted</th>
                                        <th>Status</th>
                                        <th class="text-right" style="width: 220px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $requestItem)
                                        <tr>
                                            <td class="align-middle text-muted">
                                                {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                                            </td>

                                            <!-- Applicant Info -->
                                            <td class="align-middle">
                                                <div class="user-card">
                                                    <div class="user-avatar bg-primary-dim text-primary sm" style="font-weight: 700;">
                                                        <span>{{ strtoupper(substr(optional($requestItem->applicant)->name ?? 'U', 0, 2)) }}</span>
                                                    </div>
                                                    <div class="user-info">
                                                        <a href="{{ route('studentVerification.show', $requestItem->id) }}" class="tb-lead" style="font-weight: 600; color: #002060;">
                                                            {{ optional($requestItem->applicant)->name ?? 'Unknown Applicant' }}
                                                        </a>
                                                        <span class="tb-sub text-muted" style="font-size: 12px;">
                                                            <a href="mailto:{{ optional($requestItem->applicant)->email }}" class="text-muted">{{ optional($requestItem->applicant)->email }}</a>
                                                        </span>
                                                        @if (optional($requestItem->plan)->name)
                                                            <div class="mt-1">
                                                                <span class="badge badge-dim badge-outline-primary" style="font-size: 10.5px;">
                                                                    {{ $requestItem->plan->name }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Academic Affiliation & Role -->
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center mb-1">
                                                    <em class="icon ni ni-building text-primary mr-2" style="font-size: 16px;"></em>
                                                    <span style="font-size: 13.5px; font-weight: 600;">{{ $requestItem->institution_name }}</span>
                                                </div>
                                                @if ($requestItem->faculty_department)
                                                    <div class="text-muted" style="font-size: 12px;">
                                                        <em class="icon ni ni-folder mr-1"></em>{{ $requestItem->faculty_department }}
                                                    </div>
                                                @endif
                                                @if ($requestItem->role_within_institution)
                                                    <div class="mt-1">
                                                        <span class="badge badge-dim badge-outline-secondary" style="font-size: 10.5px;">
                                                            <em class="icon ni ni-user-check mr-1"></em>{{ $requestItem->role_within_institution }}
                                                        </span>
                                                        @if ($requestItem->student_id_number)
                                                            <span class="text-muted small ml-1">#{{ $requestItem->student_id_number }}</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>

                                            <!-- Institutional Email (Mandatory Transition) -->
                                            <td class="align-middle">
                                                @if ($requestItem->institutional_email)
                                                    <a href="mailto:{{ $requestItem->institutional_email }}" style="font-size: 13px; font-weight: 500; color: #0c2b70;">
                                                        {{ $requestItem->institutional_email }}
                                                    </a>
                                                    @if ($requestItem->status == 1)
                                                        <span class="badge badge-dot badge-success d-block mt-1">Transitioned</span>
                                                    @else
                                                        <span class="badge badge-dot badge-warning d-block mt-1">Target Email</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            <!-- Proof Document -->
                                            <td class="align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('studentVerification.preview', $requestItem->id) }}" target="_blank" class="btn btn-outline-primary btn-sm" title="Preview Proof Document">
                                                        <em class="icon ni ni-eye mr-1"></em> Preview
                                                    </a>
                                                    <a href="{{ route('studentVerification.proof', $requestItem->id) }}" class="btn btn-outline-secondary btn-sm" title="Download Document">
                                                        <em class="icon ni ni-download"></em>
                                                    </a>
                                                </div>
                                            </td>

                                            <!-- Submitted Date -->
                                            <td class="align-middle text-nowrap">
                                                <span style="font-size: 13px;">{{ $requestItem->created_at->format('M d, Y') }}</span>
                                                <span class="d-block text-muted" style="font-size: 11px;">{{ $requestItem->created_at->diffForHumans() }}</span>
                                            </td>

                                            <!-- Status -->
                                            <td class="align-middle">
                                                @if ($requestItem->status == 0)
                                                    <span class="badge badge-dim badge-warning">
                                                        <em class="icon ni ni-clock mr-1"></em> Pending Review
                                                    </span>
                                                @elseif ($requestItem->status == 1)
                                                    <span class="badge badge-dim badge-success">
                                                        <em class="icon ni ni-check mr-1"></em> Approved
                                                    </span>
                                                    @if ($requestItem->reviewer)
                                                        <span class="d-block text-muted" style="font-size: 11px;">By: {{ $requestItem->reviewer->name }}</span>
                                                    @endif
                                                @else
                                                    <span class="badge badge-dim badge-danger">
                                                        <em class="icon ni ni-cross mr-1"></em> Rejected
                                                    </span>
                                                    @if ($requestItem->reviewer)
                                                        <span class="d-block text-muted" style="font-size: 11px;">By: {{ $requestItem->reviewer->name }}</span>
                                                    @endif
                                                @endif
                                            </td>

                                            <!-- Actions: View Single Request + Quick Actions -->
                                            <td class="align-middle text-right text-nowrap">
                                                <a href="{{ route('studentVerification.show', $requestItem->id) }}" class="btn btn-sm btn-primary" title="View Full Request Details">
                                                    <em class="icon ni ni-eye mr-1"></em> View
                                                </a>

                                                @if ($requestItem->status == 0)
                                                    @if (Auth::user() && (Auth::user()->hasRole('Portal Admin') || Auth::user()->hasRole('Super Admin') || Auth::user()->can('student-verification-approve')))
                                                        <button type="button" class="btn btn-sm btn-success ml-1 btn-approve-student" data-id="{{ $requestItem->id }}" data-name="{{ optional($requestItem->applicant)->name }}" title="Approve Application">
                                                            <em class="icon ni ni-check"></em> Approve
                                                        </button>
                                                    @endif

                                                    @if (Auth::user() && (Auth::user()->hasRole('Portal Admin') || Auth::user()->hasRole('Super Admin') || Auth::user()->can('student-verification-reject')))
                                                        <button type="button" class="btn btn-sm btn-danger ml-1" data-toggle="modal" data-target="#rejectModal-{{ $requestItem->id }}" title="Reject Application">
                                                            <em class="icon ni ni-cross"></em> Reject
                                                        </button>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5 text-muted">
                                                <div class="py-4">
                                                    <em class="icon ni ni-inbox text-soft" style="font-size: 48px;"></em>
                                                    <h5 class="mt-3 mb-1 text-soft">No applications found</h5>
                                                    <p class="text-muted small">
                                                        @if (request()->filled('search') || request()->filled('status'))
                                                            No student applications match your filter criteria. Try clearing filters.
                                                        @else
                                                            There are no student verification applications in the system yet.
                                                        @endif
                                                    </p>
                                                    @if (request()->filled('search') || request()->filled('status'))
                                                        <a href="{{ route('studentVerification.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                                                            View All Applications
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    @if ($data->total() > 0)
                        <div class="card-inner py-3 border-top">
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                                <div class="text-muted small mb-2 mb-sm-0">
                                    Showing {{ $data->firstItem() ?? 0 }} to {{ $data->lastItem() ?? 0 }} of {{ $data->total() }} applications
                                </div>
                                <div>
                                    {{ $data->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODALS & FORMS (Placed OUTSIDE the table to prevent any DOM/layout breakage) -->
<!-- ========================================================================= -->
@foreach ($data as $requestItem)
    <!-- Hidden Approve Form for this item -->
    <form id="approve-form-{{ $requestItem->id }}" action="{{ route('studentVerification.approve', $requestItem->id) }}" method="POST" class="d-none">
        @csrf
    </form>

    @if ($requestItem->status == 0)
        <!-- Rejection Modal for this item -->
        <div class="modal fade" id="rejectModal-{{ $requestItem->id }}" tabindex="-1" role="dialog">
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
                    <form method="POST" action="{{ route('studentVerification.reject', $requestItem->id) }}">
                        @csrf
                        <div class="modal-body">
                            <p class="text-soft mb-3" style="font-size: 13.5px;">
                                Please specify the reason for rejecting <strong>{{ optional($requestItem->applicant)->name }}</strong>'s application. This reason will be emailed directly to the student.
                            </p>

                            <!-- Quick-Pick Rejection Templates -->
                            <div class="form-group mb-3" style="display: block; clear: both;">
                                <label class="form-label text-muted d-block mb-1" style="font-size: 12px; font-weight: 600;">
                                    Quick Reason Suggestions (Click to insert):
                                </label>
                                <div class="quick-tags-container" style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 4px;">
                                    <button type="button" class="btn btn-xs btn-outline-light quick-reason" style="margin: 2px;" data-target="note-{{ $requestItem->id }}" data-reason="The uploaded document does not clearly show proof of enrollment for the current academic session.">
                                        Not Current Session
                                    </button>
                                    <button type="button" class="btn btn-xs btn-outline-light quick-reason" style="margin: 2px;" data-target="note-{{ $requestItem->id }}" data-reason="The uploaded Student ID / admission letter is blurry or unreadable. Please upload a clear photo or PDF scan.">
                                        Blurry / Unreadable
                                    </button>
                                    <button type="button" class="btn btn-xs btn-outline-light quick-reason" style="margin: 2px;" data-target="note-{{ $requestItem->id }}" data-reason="The name on the academic proof does not match your registered account name.">
                                        Name Mismatch
                                    </button>
                                    <button type="button" class="btn btn-xs btn-outline-light quick-reason" style="margin: 2px;" data-target="note-{{ $requestItem->id }}" data-reason="The institution could not be verified as an accredited tertiary academic institution.">
                                        Unverified Institution
                                    </button>
                                </div>
                            </div>

                            <div class="form-group pt-2" style="display: block; clear: both;">
                                <label class="form-label d-block mb-1" for="note-{{ $requestItem->id }}" style="font-size: 13px; font-weight: 600;">
                                    Rejection Reason &amp; Feedback <span class="text-danger">*</span>
                                </label>
                                <textarea required class="form-control" name="note" id="note-{{ $requestItem->id }}" rows="4" placeholder="Enter specific feedback for the student..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">
                                <em class="icon ni ni-cross mr-1"></em> Confirm Rejection &amp; Notify Student
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endforeach

<!-- SweetAlert2 / Custom confirmation script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quick reason tag inserter
        document.querySelectorAll('.quick-reason').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var targetId = this.dataset.target;
                var reasonText = this.dataset.reason;
                var textarea = document.getElementById(targetId);
                if (textarea) {
                    textarea.value = reasonText;
                    textarea.focus();
                }
            });
        });

        // SweetAlert approval confirmation
        document.querySelectorAll('.btn-approve-student').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                var studentId = this.dataset.id;
                var studentName = this.dataset.name || 'this student';

                Swal.fire({
                    title: 'Approve Student Application?',
                    html: `Are you sure you want to verify and approve <strong>${studentName}</strong>?<br><br><span style="font-size: 13.5px; color: #526484;">This will immediately grant <strong>30 days of complimentary view-only access</strong> and send an approval notification email to the student.</span>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#6e829f',
                    confirmButtonText: '<em class="icon ni ni-check mr-1"></em> Yes, Approve Access',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = document.getElementById('approve-form-' + studentId);
                        if (form) {
                            Swal.fire({
                                title: 'Approving Application...',
                                text: 'Activating 30-day access grant and sending notification email.',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            form.submit();
                        }
                    }
                });
            });
        });
    });
</script>
@endsection
