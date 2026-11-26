@extends('layouts.master')

@section('content')
<style>
    .tx-page {
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }
    .tx-kpi-card {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04) !important;
        display: block;
    }
    .tx-kpi-card:hover {
        border-color: #cbd5e1 !important;
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.06) !important;
        transform: translateY(-1px);
    }
    .tx-kpi-card.is-active {
        border-color: #0c2b70 !important;
        box-shadow: 0 0 0 1px #0c2b70, 0 6px 16px rgba(12, 43, 112, 0.08) !important;
    }
    .tx-kpi-icon {
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
    .tx-kpi-card.is-active .tx-kpi-icon {
        background: #eef2ff;
        color: #0c2b70;
    }
    .tx-segmented {
        display: inline-flex;
        background: #f1f5f9;
        padding: 4px;
        border-radius: 10px;
        width: 100%;
        gap: 4px;
    }
    .tx-seg-btn {
        flex: 1;
        text-align: center;
        padding: 7px 10px;
        font-size: 13px;
        font-weight: 600;
        color: #64748b !important;
        border-radius: 7px;
        text-decoration: none !important;
        transition: all 0.18s ease;
        white-space: nowrap;
    }
    .tx-seg-btn:hover {
        color: #0f172a !important;
    }
    .tx-seg-btn.active {
        background: #ffffff;
        color: #0c2b70 !important;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.1);
    }
    .tx-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #eef2f7;
        color: #0c2b70;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid #dbe4f0;
    }
    .tx-ref-badge {
        display: inline-block;
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 3px 8px;
        font-family: monospace;
        font-size: 11.5px;
    }
    .tx-status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
        white-space: nowrap;
    }
    .tx-status-success {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }
    .tx-status-pending {
        background: #fef9ec;
        color: #b45309;
        border: 1px solid #fde68a;
    }
    .tx-status-failed {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }
</style>

<div class="nk-content tx-page">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">

                <!-- Header -->
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between align-items-center">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Transactions</h3>
                            <div class="nk-block-des text-soft">
                                <p style="color: #64748b;">Monitor subscription and document payment transactions, references, and settlement statuses.</p>
                            </div>
                        </div>
                        <div class="nk-block-head-content">
                            <a href="{{ url('subscribers') }}" class="btn btn-outline-light">
                                <em class="icon ni ni-users mr-1"></em> View Subscribers
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Alerts -->
                @if (\Session::has('success'))
                    <div class="alert alert-success alert-icon alert-dismissible mb-4">
                        <em class="icon ni ni-check-circle"></em>
                        <strong>{{ \Session::get('success') }}</strong>
                        <button class="close" data-dismiss="alert"></button>
                    </div>
                @endif

                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-icon alert-dismissible mb-4">
                        <strong>Oops!</strong> Something went wrong, please check below errors.
                        <ul class="mb-0 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button class="close" data-dismiss="alert"></button>
                    </div>
                @endif

                <!-- KPI Overview Cards -->
                @php $currentStatus = request('status', 'all'); @endphp
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <a href="{{ route('transactions.index', ['status' => 'all']) }}" class="card tx-kpi-card text-decoration-none {{ $currentStatus === 'all' ? 'is-active' : '' }}">
                            <div class="card-inner py-3 px-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="text-uppercase" style="font-size: 11px; font-weight: 700; letter-spacing: 0.5px; color: #64748b;">Total Transactions</span>
                                        <h3 class="mt-1 mb-0" style="color: #0f172a; font-weight: 700;">{{ number_format($stats['total'] ?? 0) }}</h3>
                                    </div>
                                    <div class="tx-kpi-icon">
                                        <em class="icon ni ni-tranx"></em>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('transactions.index', ['status' => 'success']) }}" class="card tx-kpi-card text-decoration-none {{ $currentStatus === 'success' ? 'is-active' : '' }}">
                            <div class="card-inner py-3 px-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="text-uppercase" style="font-size: 11px; font-weight: 700; letter-spacing: 0.5px; color: #64748b;">Successful</span>
                                        <h3 class="mt-1 mb-0" style="color: #0f172a; font-weight: 700;">{{ number_format($stats['success'] ?? 0) }}</h3>
                                    </div>
                                    <div class="tx-kpi-icon">
                                        <em class="icon ni ni-check-circle"></em>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="{{ route('transactions.index', ['status' => 'pending']) }}" class="card tx-kpi-card text-decoration-none {{ $currentStatus === 'pending' ? 'is-active' : '' }}">
                            <div class="card-inner py-3 px-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="text-uppercase" style="font-size: 11px; font-weight: 700; letter-spacing: 0.5px; color: #64748b;">Pending</span>
                                        <h3 class="mt-1 mb-0" style="color: #0f172a; font-weight: 700;">{{ number_format($stats['pending'] ?? 0) }}</h3>
                                    </div>
                                    <div class="tx-kpi-icon">
                                        <em class="icon ni ni-clock"></em>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card tx-kpi-card">
                            <div class="card-inner py-3 px-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="text-uppercase" style="font-size: 11px; font-weight: 700; letter-spacing: 0.5px; color: #64748b;">Settled Revenue</span>
                                        <div class="mt-1" style="color: #0c2b70; font-weight: 700; font-size: 16px; line-height: 1.25;">
                                            ₦{{ number_format((float)($stats['revenue_ngn'] ?? 0), 2) }}
                                        </div>
                                        @if (($stats['revenue_usd'] ?? 0) > 0)
                                            <div style="color: #64748b; font-weight: 600; font-size: 12px;">
                                                ${{ number_format((float)$stats['revenue_usd'], 2) }} USD
                                            </div>
                                        @endif
                                    </div>
                                    <div class="tx-kpi-icon">
                                        <em class="icon ni ni-wallet-alt"></em>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter & Search Toolbar -->
                <div class="card card-bordered mb-4">
                    <div class="card-inner py-3">
                        <form action="{{ route('transactions.index') }}" method="GET" class="row g-3 align-items-center">
                            <div class="col-lg-5 col-md-12">
                                <div class="tx-segmented" role="group">
                                    <a href="{{ route('transactions.index', array_merge(request()->except(['status', 'page']), ['status' => 'all'])) }}"
                                       class="tx-seg-btn {{ $currentStatus === 'all' ? 'active' : '' }}">
                                        All ({{ $stats['total'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('transactions.index', array_merge(request()->except(['status', 'page']), ['status' => 'success'])) }}"
                                       class="tx-seg-btn {{ $currentStatus === 'success' ? 'active' : '' }}">
                                        Success ({{ $stats['success'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('transactions.index', array_merge(request()->except(['status', 'page']), ['status' => 'pending'])) }}"
                                       class="tx-seg-btn {{ $currentStatus === 'pending' ? 'active' : '' }}">
                                        Pending ({{ $stats['pending'] ?? 0 }})
                                    </a>
                                    <a href="{{ route('transactions.index', array_merge(request()->except(['status', 'page']), ['status' => 'failed'])) }}"
                                       class="tx-seg-btn {{ $currentStatus === 'failed' ? 'active' : '' }}">
                                        Failed ({{ $stats['failed'] ?? 0 }})
                                    </a>
                                </div>
                                <input type="hidden" name="status" value="{{ $currentStatus }}">
                            </div>

                            <div class="col-lg-2 col-md-4">
                                <select name="currency" class="form-control form-control-sm">
                                    <option value="all" {{ request('currency', 'all') === 'all' ? 'selected' : '' }}>All Currencies</option>
                                    <option value="NGN" {{ request('currency') === 'NGN' ? 'selected' : '' }}>NGN (₦)</option>
                                    <option value="USD" {{ request('currency') === 'USD' ? 'selected' : '' }}>USD ($)</option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-5">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-left">
                                        <em class="icon ni ni-search" style="color: #64748b;"></em>
                                    </div>
                                    <input type="text" name="search" class="form-control form-control-sm"
                                           placeholder="Search reference, customer, plan..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 text-right">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <em class="icon ni ni-filter mr-1"></em> Filter
                                </button>
                                @if (request()->filled('search') || (request()->has('status') && request('status') !== 'all') || (request()->has('currency') && request('currency') !== 'all'))
                                    <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-light ml-1" title="Reset Filters">
                                        <em class="icon ni ni-reload"></em>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Transactions Table -->
                <div class="card card-bordered card-preview" style="overflow: hidden;">
                    <div class="card-inner p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Customer</th>
                                        <th>Plan / Item</th>
                                        <th>Reference</th>
                                        <th>Amount</th>
                                        <th>Transaction Date</th>
                                        <th>Status</th>
                                        <th class="text-right" style="width: 100px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $transaction)
                                        @php
                                            $custName = optional($transaction->user)->name ?? 'Unknown User';
                                            $custEmail = optional($transaction->user)->email ?? '';
                                            $custInitials = strtoupper(substr($custName, 0, 2));
                                            $txCurrency = strtoupper($transaction->currency ?: 'NGN');
                                            $currencySymbol = $txCurrency === 'USD' ? '$' : '₦';
                                            $txStatus = strtolower((string) $transaction->status);
                                            $itemTitle = optional($transaction->subscriptionPlan)->name
                                                ?? optional($transaction->regulation)->title
                                                ?? 'Portal Transaction';
                                        @endphp
                                        <tr>
                                            <td class="text-muted">
                                                {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="tx-avatar mr-2">{{ $custInitials }}</span>
                                                    <div>
                                                        <div style="font-weight: 600; color: #0f172a; font-size: 13.5px;">{{ $custName }}</div>
                                                        @if ($custEmail)
                                                            <div style="font-size: 12px; color: #64748b;">{{ $custEmail }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div style="font-weight: 600; color: #1e293b; font-size: 13px;">{{ $itemTitle }}</div>
                                                @if ($transaction->description && $transaction->description !== $itemTitle)
                                                    <div style="font-size: 11.5px; color: #64748b; max-width: 260px; white-space: normal;">
                                                        {{ $transaction->description }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($transaction->reference)
                                                    <span class="tx-ref-badge">{{ $transaction->reference }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span style="font-weight: 700; color: #0f172a; font-size: 13.5px;">
                                                    {{ $currencySymbol }}{{ number_format((float) $transaction->amount, 2) }}
                                                </span>
                                                <span class="badge ml-1" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; font-size: 10px;">
                                                    {{ $txCurrency }}
                                                </span>
                                            </td>
                                            <td class="text-nowrap">
                                                <div style="font-size: 13px; color: #1e293b;">{{ \Carbon\Carbon::parse($transaction->created_at)->format('M d, Y') }}</div>
                                                <div style="font-size: 11px; color: #64748b;">{{ \Carbon\Carbon::parse($transaction->created_at)->format('h:i A') }}</div>
                                            </td>
                                            <td>
                                                @if (in_array($txStatus, ['success', 'successful']))
                                                    <span class="tx-status-pill tx-status-success">
                                                        <em class="icon ni ni-check"></em> Success
                                                    </span>
                                                @elseif ($txStatus === 'failed')
                                                    <span class="tx-status-pill tx-status-failed">
                                                        <em class="icon ni ni-cross"></em> Failed
                                                    </span>
                                                @else
                                                    <span class="tx-status-pill tx-status-pending">
                                                        <em class="icon ni ni-clock"></em> Pending
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <button type="button" class="btn btn-sm btn-light" data-toggle="modal" data-target="#txDetailModal-{{ $transaction->id }}">
                                                    <em class="icon ni ni-eye mr-1"></em> View
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5 text-muted">
                                                <div class="py-4">
                                                    <em class="icon ni ni-tranx text-soft" style="font-size: 44px;"></em>
                                                    <h5 class="mt-3 mb-1 text-soft">No transactions found</h5>
                                                    <p class="small text-muted mb-0">
                                                        @if (request()->filled('search') || request()->filled('status') || request()->filled('currency'))
                                                            No transactions match your selected filters. Try resetting your filters.
                                                        @else
                                                            Payment transactions will appear here once subscribers initiate payments.
                                                        @endif
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($data->total() > 0)
                        <div class="card-inner py-3 border-top">
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                                <div class="text-muted small mb-2 mb-sm-0">
                                    Showing {{ $data->firstItem() ?? 0 }} to {{ $data->lastItem() ?? 0 }} of {{ $data->total() }} transactions
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

<!-- Transaction Detail Modals -->
@foreach ($data as $transaction)
    @php
        $txCurrency = strtoupper($transaction->currency ?: 'NGN');
        $currencySymbol = $txCurrency === 'USD' ? '$' : '₦';
        $txStatus = strtolower((string) $transaction->status);
    @endphp
    <div class="modal fade" id="txDetailModal-{{ $transaction->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-white">
                    <h5 class="modal-title" style="color: #0f172a; font-weight: 700;">
                        <em class="icon ni ni-tranx mr-1" style="color: #0c2b70;"></em>
                        Transaction Details
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <em class="icon ni ni-cross"></em>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center p-3 rounded mb-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <div style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.6px; color: #64748b; font-weight: 700;">Transaction Amount</div>
                        <div style="font-size: 26px; font-weight: 800; color: #0c2b70; margin: 4px 0;">
                            {{ $currencySymbol }}{{ number_format((float) $transaction->amount, 2) }} <span style="font-size: 14px; font-weight: 600; color: #64748b;">{{ $txCurrency }}</span>
                        </div>
                        @if (in_array($txStatus, ['success', 'successful']))
                            <span class="tx-status-pill tx-status-success"><em class="icon ni ni-check"></em> Successful</span>
                        @elseif ($txStatus === 'failed')
                            <span class="tx-status-pill tx-status-failed"><em class="icon ni ni-cross"></em> Failed</span>
                        @else
                            <span class="tx-status-pill tx-status-pending"><em class="icon ni ni-clock"></em> Pending</span>
                        @endif
                    </div>

                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between py-2 border-bottom" style="border-color: #f1f5f9 !important;">
                            <span style="color: #64748b; font-size: 13px;">Reference</span>
                            <span class="tx-ref-badge">{{ $transaction->reference ?? 'N/A' }}</span>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom" style="border-color: #f1f5f9 !important;">
                            <span style="color: #64748b; font-size: 13px;">Customer</span>
                            <span style="font-weight: 600; color: #0f172a; font-size: 13px;">{{ optional($transaction->user)->name ?? 'Unknown' }}</span>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom" style="border-color: #f1f5f9 !important;">
                            <span style="color: #64748b; font-size: 13px;">Customer Email</span>
                            <span style="color: #0c2b70; font-size: 13px;">{{ optional($transaction->user)->email ?? 'N/A' }}</span>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom" style="border-color: #f1f5f9 !important;">
                            <span style="color: #64748b; font-size: 13px;">Plan / Document</span>
                            <span style="font-weight: 600; color: #1e293b; font-size: 13px;">
                                {{ optional($transaction->subscriptionPlan)->name ?? optional($transaction->regulation)->title ?? 'N/A' }}
                            </span>
                        </li>
                        @if ($transaction->description)
                            <li class="d-flex justify-content-between py-2 border-bottom" style="border-color: #f1f5f9 !important;">
                                <span style="color: #64748b; font-size: 13px;">Description</span>
                                <span class="text-right" style="color: #475569; font-size: 12.5px; max-width: 65%;">{{ $transaction->description }}</span>
                            </li>
                        @endif
                        <li class="d-flex justify-content-between pt-2 pb-0">
                            <span style="color: #64748b; font-size: 13px;">Date &amp; Time</span>
                            <span style="color: #1e293b; font-size: 13px;">{{ \Carbon\Carbon::parse($transaction->created_at)->format('M d, Y h:i A') }}</span>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection
