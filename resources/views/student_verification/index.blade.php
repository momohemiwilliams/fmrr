@extends('layouts.master')

@section('content')
<style>
    .sv-page {
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }
    .sv-kpi-card {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04) !important;
    }
    .sv-kpi-card:hover {
        border-color: #cbd5e1 !important;
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.06) !important;
        transform: translateY(-1px);
    }
    .sv-kpi-card.is-active {
        border-color: #0c2b70 !important;
        box-shadow: 0 0 0 1px #0c2b70, 0 6px 16px rgba(12, 43, 112, 0.08) !important;
    }
    .sv-kpi-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: #f1f5f9;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .sv-kpi-card.is-active .sv-kpi-icon {
        background: #eef2ff;
        color: #0c2b70;
    }
    .sv-segmented {
        display: inline-flex;
        background: #f1f5f9;
        padding: 4px;
        border-radius: 10px;
        width: 100%;
        gap: 4px;
    }
    .sv-seg-btn {
        flex: 1;
        text-align: center;
        padding: 7px 12px;
        font-size: 13px;
        font-weight: 600;
        color: #64748b !important;
        border-radius: 7px;
        text-decoration: none !important;
        transition: all 0.18s ease;
        white-space: nowrap;
    }
    .sv-seg-btn:hover {
        color: #0f172a !important;
    }
    .sv-seg-btn.active {
        background: #ffffff;
        color: #0c2b70 !important;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.1);
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
    .sv-table thead th {
        background: #f8fafc !important;
        color: #475569 !important;
        font-size: 11.5px !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        border-bottom: 1px solid #e2e8f0 !important;
        padding: 13px 16px !important;
    }
    .sv-table tbody td {
        padding: 14px 16px !important;
        border-bottom: 1px solid #f1f5f9 !important;
        vertical-align: middle !important;
    }
    .sv-table tbody tr:hover {
        background: #f8fafc !important;
    }
    .sv-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #eef2f7;
        color: #0c2b70;
        font-size: 12.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid #dbe4f0;
    }
    .sv-pill-neutral {
        display: inline-flex;
        align-items: center;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 2px 8px;
        font-size: 11px;
        font-weight: 600;
    }
    .sv-status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11.5px;
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
</style>

<div class="nk-content sv-page">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">

                <!-- Header -->
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between align-items-center">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title" style="color: #0f172a; font-weight: 700;">Academic Verification Applications</h3>
                            <div class="nk-block-des text-soft">
                                <p style="color: #64748b;">Manage, review, verify, approve, or reject academic onboarding and verification applications.</p>
                            </div>
                        </div>
                        <div class="nk-block-head-content">
                            @if (($stats['pending'] ?? 0) > 0)
                                <span class="sv-status-pill sv-status-pending" style="font-size: 12.5px; padding: 6px 14px;">
                                    <em class="icon ni ni-clock"></em> {{ $stats['pending'] }} Pending Review
                                </span>
                            @else
                                <span class="sv-status-pill sv-status-approved" style="font-size: 12.5px; padding: 6px 14px;">
                                    <em class="icon ni ni-check-circle"></em> All Caught Up
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
                @php $currentStatus = request('status', 'all'); @endphp
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <a href="{{ route('studentVerification.index', ['status' => 'all']) }}" class="card sv-kpi-card text-decoration-none {{ $currentStatus === 'all' ? 'is-active' : '' }}">
                            <div class="card-inner py-3 px-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="text-uppercase" style="font-size: 11px; font-weight: 700; letter-spacing: 0.5px; color: #64748b;">Total Applications</span>
                                        <h3 class="mt-1 mb-0" style="color: #0f172a; font-weight: 700;">{{ number_format($stats['total'] ?? 0) }}</h3>
                                    </div>
                                    <div class="sv-kpi-icon">
                                        <em class="icon ni ni-files"></em>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('studentVerification.index', ['status' => '0']) }}" class="card sv-kpi-card text-decoration-none {{ $currentStatus === '0' ? 'is-active' : '' }}">
                            <div class="card-inner py-3 px-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="text-uppercase" style="font-size: 11px; font-weight: 700; letter-spacing: 0.5px; color: #64748b;">Pending Review</span>
                                        <h3 class="mt-1 mb-0" style="color: #0f172a; font-weight: 700;">{{ number_format($stats['pending'] ?? 0) }}</h3>
                                    </div>
                                    <div class="sv-kpi-icon">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('studentVerification.index', ['status' => '1']) }}" class="card sv-kpi-card text-decoration-none {{ $currentStatus === '1' ? 'is-active' : '' }}">
                            <div class="card-inner py-3 px-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="text-uppercase" style="font-size: 11px; font-weight: 700; letter-spacing: 0.5px; color: #64748b;">Approved</span>
                                        <h3 class="mt-1 mb-0" style="color: #0f172a; font-weight: 700;">{{ number_format($stats['approved'] ?? 0) }}</h3>
                                    </div>
                                    <div class="sv-kpi-icon">
                                        <em class="icon ni ni-check-circle"></em>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('studentVerification.index', ['status' => '2']) }}" class="card sv-kpi-card text-decoration-none {{ $currentStatus === '2' ? 'is-active' : '' }}">
                            <div class="card-inner py-3 px-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="text-uppercase" style="font-size: 11px; font-weight: 700; letter-spacing: 0.5px; color: #64748b;">Rejected</span>
                                        <h3 class="mt-1 mb-0" style="color: #0f172a; font-weight: 700;">{{ number_format($stats['rejected'] ?? 0) }}</h3>
                                    </div>
                                    <div class="sv-kpi-icon">
                                        <em class="icon ni ni-cross-circle"></em>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Filters & Search Toolbar -->
                <div class="card card-bordered mb-4" style="border-radius: 12px; border-color: #e2e8f0;">
                    <div class="card-inner py-3">
                        <form action="{{ route('studentVerification.index') }}" method="GET" class="row g-3 align-items-center">
                            <!-- Status Tabs -->
                            <div class="col-lg-6 col-md-12">
                                <div class="sv-segmented" role="group">
                                    <a href="{{ route('studentVerification.index', array_merge(request()->except(['status', 'page']), ['status' => 'all'])) }}"
                                       class="sv-seg-btn {{ (!request()->has('status') || request('status') === 'all') ? 'active' : '' }}">
                                        All ({{ $stats['total'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('studentVerification.index', array_merge(request()->except(['status', 'page']), ['status' => '0'])) }}"
                                       class="sv-seg-btn {{ request('status') === '0' ? 'active' : '' }}">
                                        Pending ({{ $stats['pending'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('studentVerification.index', array_merge(request()->except(['status', 'page']), ['status' => '1'])) }}"
                                       class="sv-seg-btn {{ request('status') === '1' ? 'active' : '' }}">
                                        Approved ({{ $stats['approved'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('studentVerification.index', array_merge(request()->except(['status', 'page']), ['status' => '2'])) }}"
                                       class="sv-seg-btn {{ request('status') === '2' ? 'active' : '' }}">
                                        Rejected ({{ $stats['rejected'] ?? 0 }})
                                    </a>
                                </div>
                                <input type="hidden" name="status" value="{{ request('status', 'all') }}">
                            </div>

                            <!-- Search Input -->
                            <div class="col-lg-4 col-md-8">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-left">
                                        <em class="icon ni ni-search" style="color: #64748b;"></em>
                                    </div>
                                    <input type="text" name="search" class="form-control form-control-sm"
                                           style="border-radius: 8px; border-color: #cbd5e1;"
                                           placeholder="Search by applicant name, email, institution, ID..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="col-lg-2 col-md-4 text-right">
                                <button type="submit" class="btn btn-sm sv-btn-navy">
                                    <em class="icon ni ni-filter mr-1"></em> Filter
                                </button>
                                @if (request()->filled('search') || (request()->has('status') && request('status') !== 'all'))
                                    <a href="{{ route('studentVerification.index') }}" class="btn btn-sm sv-btn-neutral ml-1" title="Clear Filters">
                                        <em class="icon ni ni-reload"></em>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Clean Applications Data Table -->
                <div class="card card-bordered card-preview" style="border-radius: 12px; border-color: #e2e8f0; overflow: hidden;">
                    <div class="card-inner p-0">
                        <div class="table-responsive">
                            <table class="table sv-table mb-0">
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
                                                    <div class="sv-avatar mr-2">
                                                        <span>{{ strtoupper(substr(optional($requestItem->applicant)->name ?? 'U', 0, 2)) }}</span>
                                                    </div>
                                                    <div class="user-info">
                                                        <a href="{{ route('studentVerification.show', $requestItem->id) }}" class="tb-lead" style="font-weight: 600; color: #0f172a;">
                                                            {{ optional($requestItem->applicant)->name ?? 'Unknown Applicant' }}
                                                        </a>
                                                        <span class="tb-sub" style="font-size: 12px; color: #64748b;">
                                                            <a href="mailto:{{ optional($requestItem->applicant)->email }}" style="color: #64748b;">{{ optional($requestItem->applicant)->email }}</a>
                                                        </span>
                                                        @if (optional($requestItem->plan)->name)
                                                            <div class="mt-1">
                                                                <span class="sv-pill-neutral">
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
                                                    <em class="icon ni ni-building mr-2" style="font-size: 15px; color: #64748b;"></em>
                                                    <span style="font-size: 13.5px; font-weight: 600; color: #1e293b;">{{ $requestItem->institution_name }}</span>
                                                </div>
                                                @if ($requestItem->faculty_department)
                                                    <div style="font-size: 12px; color: #64748b;">
                                                        <em class="icon ni ni-folder mr-1"></em>{{ $requestItem->faculty_department }}
                                                    </div>
                                                @endif
                                                @if ($requestItem->role_within_institution)
                                                    <div class="mt-1">
                                                        <span class="sv-pill-neutral">
                                                            <em class="icon ni ni-user-check mr-1"></em>{{ $requestItem->role_within_institution }}
                                                        </span>
                                                        @if ($requestItem->student_id_number)
                                                            <span class="small ml-1" style="color: #64748b;">#{{ $requestItem->student_id_number }}</span>
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
                                                        <span class="d-block mt-1" style="font-size: 11px; color: #059669; font-weight: 500;">&bull; Transitioned</span>
                                                    @else
                                                        <span class="d-block mt-1" style="font-size: 11px; color: #64748b;">&bull; Target Email</span>
                                                    @endif
                                                @else
                                                    <span style="color: #94a3b8;">-</span>
                                                @endif
                                            </td>

                                            <!-- Proof Document -->
                                            <td class="align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('studentVerification.preview', $requestItem->id) }}" target="_blank" class="btn sv-btn-neutral btn-sm" title="Preview Proof Document">
                                                        <em class="icon ni ni-eye mr-1"></em> Preview
                                                    </a>
                                                    <a href="{{ route('studentVerification.proof', $requestItem->id) }}" class="btn sv-btn-neutral btn-sm" title="Download Document">
                                                        <em class="icon ni ni-download"></em>
                                                    </a>
                                                </div>
                                            </td>

                                            <!-- Submitted Date -->
                                            <td class="align-middle text-nowrap">
                                                <span style="font-size: 13px; color: #1e293b;">{{ $requestItem->created_at->format('M d, Y') }}</span>
                                                <span class="d-block" style="font-size: 11px; color: #64748b;">{{ $requestItem->created_at->diffForHumans() }}</span>
                                            </td>

                                            <!-- Status -->
                                            <td class="align-middle">
                                                @if ($requestItem->status == 0)
                                                    <span class="sv-status-pill sv-status-pending">
                                                        <em class="icon ni ni-clock"></em> Pending Review
                                                    </span>
                                                @elseif ($requestItem->status == 1)
                                                    <span class="sv-status-pill sv-status-approved">
                                                        <em class="icon ni ni-check"></em> Approved
                                                    </span>
                                                    @if ($requestItem->reviewer)
                                                        <span class="d-block mt-1" style="font-size: 11px; color: #64748b;">By: {{ $requestItem->reviewer->name }}</span>
                                                    @endif
                                                @else
                                                    <span class="sv-status-pill sv-status-rejected">
                                                        <em class="icon ni ni-cross"></em> Rejected
                                                    </span>
                                                    @if ($requestItem->reviewer)
                                                        <span class="d-block mt-1" style="font-size: 11px; color: #64748b;">By: {{ $requestItem->reviewer->name }}</span>
                                                    @endif
                                                @endif
                                            </td>

                                            <!-- Actions: View Single Request + Quick Actions -->
                                            <td class="align-middle text-right text-nowrap">
                                                <a href="{{ route('studentVerification.show', $requestItem->id) }}" class="btn btn-sm sv-btn-neutral" title="View Full Request Details">
                                                    <em class="icon ni ni-eye mr-1"></em> View
                                                </a>

                                                @if ($requestItem->status == 0)
                                                    @if (Auth::user() && (Auth::user()->hasRole('Portal Admin') || Auth::user()->hasRole('Super Admin') || Auth::user()->can('student-verification-approve')))
                                                        @php
                                                            $reqPlan = $requestItem->plan;
                                                            $reqPlanName = optional($reqPlan)->name ?? 'Academic Subscription';
                                                            $reqIsComplimentary = $reqPlan
                                                                ? ((float) ($reqPlan->price ?? 0) <= 0 && (float) ($reqPlan->price_usd ?? 0) <= 0)
                                                                : false;
                                                            $reqDuration = optional($reqPlan)->duration ?? 30;
                                                            $reqInstEmail = $requestItem->institutional_email ?? optional($requestItem->applicant)->email;
                                                        @endphp
                                                        <button type="button"
                                                            class="btn btn-sm sv-btn-navy ml-1 btn-approve-student"
                                                            data-id="{{ $requestItem->id }}"
                                                            data-name="{{ optional($requestItem->applicant)->name }}"
                                                            data-plan="{{ $reqPlanName }}"
                                                            data-complimentary="{{ $reqIsComplimentary ? '1' : '0' }}"
                                                            data-duration="{{ $reqDuration }}"
                                                            data-email="{{ $reqInstEmail }}"
                                                            title="Approve Application">
                                                            <em class="icon ni ni-check mr-1"></em> Approve
                                                        </button>
                                                    @endif

                                                    @if (Auth::user() && (Auth::user()->hasRole('Portal Admin') || Auth::user()->hasRole('Super Admin') || Auth::user()->can('student-verification-reject')))
                                                        <button type="button" class="btn btn-sm sv-btn-reject-soft ml-1" data-toggle="modal" data-target="#rejectModal-{{ $requestItem->id }}" title="Reject Application">
                                                            <em class="icon ni ni-cross mr-1"></em> Reject
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
                    <form method="POST" action="{{ route('studentVerification.reject', $requestItem->id) }}">
                        @csrf
                        <div class="modal-body p-4">
                            <p class="mb-3" style="font-size: 13.5px; color: #475569; line-height: 1.55;">
                                Please specify the reason for rejecting <strong>{{ optional($requestItem->applicant)->name }}</strong>'s application @if(optional($requestItem->plan)->name)for <strong>{{ $requestItem->plan->name }}</strong>@endif. This reason will be emailed directly to the applicant.
                            </p>

                            <!-- Quick-Pick Rejection Templates -->
                            <div class="form-group mb-3" style="display: block; clear: both;">
                                <label class="form-label d-block mb-2" style="font-size: 12px; font-weight: 600; color: #64748b;">
                                    Quick Reason Suggestions (Click to insert):
                                </label>
                                <div class="quick-tags-container" style="display: flex; flex-wrap: wrap; gap: 6px;">
                                    <button type="button" class="btn btn-xs quick-reason" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #334155; border-radius: 20px; padding: 5px 12px; font-size: 12px;" data-target="note-{{ $requestItem->id }}" data-reason="The uploaded document does not clearly show proof of active academic affiliation for the current session.">
                                        Not Current Session
                                    </button>
                                    <button type="button" class="btn btn-xs quick-reason" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #334155; border-radius: 20px; padding: 5px 12px; font-size: 12px;" data-target="note-{{ $requestItem->id }}" data-reason="The uploaded institutional ID or academic affiliation document is blurry or unreadable. Please upload a clear photo or PDF scan.">
                                        Blurry / Unreadable
                                    </button>
                                    <button type="button" class="btn btn-xs quick-reason" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #334155; border-radius: 20px; padding: 5px 12px; font-size: 12px;" data-target="note-{{ $requestItem->id }}" data-reason="The name on the academic proof does not match your registered account name.">
                                        Name Mismatch
                                    </button>
                                    <button type="button" class="btn btn-xs quick-reason" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #334155; border-radius: 20px; padding: 5px 12px; font-size: 12px;" data-target="note-{{ $requestItem->id }}" data-reason="The institution could not be verified as an accredited tertiary academic institution.">
                                        Unverified Institution
                                    </button>
                                </div>
                            </div>

                            <div class="form-group pt-2 mb-0" style="display: block; clear: both;">
                                <label class="form-label d-block mb-1" for="note-{{ $requestItem->id }}" style="font-size: 13px; font-weight: 600; color: #1e293b;">
                                    Rejection Reason &amp; Feedback <span class="text-danger">*</span>
                                </label>
                                <textarea required class="form-control" style="border-radius: 10px; border-color: #cbd5e1;" name="note" id="note-{{ $requestItem->id }}" rows="4" placeholder="Enter specific feedback explaining why this document could not be verified..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer bg-light py-3 px-4 border-top">
                            <button type="button" class="btn sv-btn-neutral" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" style="font-weight: 600;">
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
                var studentName = this.dataset.name || 'this applicant';
                var planName = this.dataset.plan || 'Academic Subscription';
                var isComplimentary = this.dataset.complimentary === '1';
                var duration = this.dataset.duration || '30';
                var instEmail = this.dataset.email || '';

                var modalTitle = isComplimentary
                    ? 'Approve Student Research Application?'
                    : 'Approve Academic Verification?';

                var emailClause = instEmail
                    ? ` and transition the account email to <code>${instEmail}</code>`
                    : '';

                var modalHtml = isComplimentary
                    ? `Are you sure you want to verify and approve <strong>${studentName}</strong> for <strong>${planName}</strong>?<br><br><span style="font-size: 13.5px; color: #526484;">This will immediately grant <strong>${duration} days of complimentary view-only access</strong>${emailClause}, and send an approval notification email.</span>`
                    : `Are you sure you want to verify and approve <strong>${studentName}</strong> for <strong>${planName}</strong>?<br><br><span style="font-size: 13.5px; color: #526484;">This will verify their academic affiliation, <strong>unlock their ability to proceed with subscription payment</strong>${emailClause}, and send an approval notification email.</span>`;

                var confirmBtnText = isComplimentary
                    ? '<em class="icon ni ni-check mr-1"></em> Yes, Approve & Grant Access'
                    : '<em class="icon ni ni-check mr-1"></em> Yes, Verify & Approve';

                var loadingText = isComplimentary
                    ? `Activating ${duration}-day complimentary access grant and sending notification email.`
                    : 'Confirming academic eligibility, unlocking payment access, and sending notification email.';

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
                        var form = document.getElementById('approve-form-' + studentId);
                        if (form) {
                            Swal.fire({
                                title: 'Approving Application...',
                                text: loadingText,
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
