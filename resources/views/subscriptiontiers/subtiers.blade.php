@extends('layouts.master')

@section('content')

    <!-- content @s -->
        <div class="nk-content ">
            <div class="container-fluid">
                <div class="nk-content-inner">
                    <div class="nk-content-body">
                        <div class="nk-block-head nk-block-head-sm">
                            <div class="nk-block-between">
                                <div class="nk-block-head-content">
                                    <h3 class="nk-block-title page-title">Subscription Sub-Tiers</h3>
                                    <div class="nk-block-des text-soft">

                                    </div>
                                </div><!-- .nk-block-head-content -->
                                <div class="nk-block-head-content">
                                    <div class="toggle-wrap nk-block-tools-toggle">
                                        <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1"
                                            data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                        <div class="toggle-expand-content" data-content="more-options">
                                            <ul class="nk-block-tools g-3">
                                                @can('subscription-tier-create')
                                                    <li class="nk-block-tools-opt">
                                                        <a href="#" class="btn btn-icon btn-primary d-md-none"><em
                                                                class="icon ni ni-plus"></em></a>
                                                        <a href="#" data-toggle="modal" data-target="#addUser"
                                                            class="btn btn-primary d-none d-md-inline-flex"><em
                                                                class="icon ni ni-plus"></em><span>Add</span></a>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head-content -->
                            </div><!-- .nk-block-between -->
                        </div><!-- .nk-block-head -->
                        <div class="nk-block nk-block-lg">

                            <div class="example-alert">
                                @if (\Session::has('success'))
                                    <div class="alert alert-success alert-icon alert-dismissible">
                                        <em class="icon ni ni-check-circle"></em> <strong> {{ \Session::get('success') }}<button
                                                class="close" data-dismiss="alert"></button>
                                    </div>
                                @endif

                                @if (\Session::has('error'))
                                    <div class="alert alert-danger alert-icon alert-dismissible">
                                        <em class="icon ni ni-check-circle"></em> <strong> {{ \Session::get('error') }}<button
                                                class="close" data-dismiss="alert"></button>
                                    </div>
                                @endif

                                @if (count($errors) > 0)
                                    <div>
                                        <div class="alert alert-danger alert-icon alert-dismissible">
                                            <strong>Opps!</strong> Something went wrong, please check below errors.<br><br>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                            <button class="close" data-dismiss="alert"></button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Filter Section -->
                            <div class="card card-bordered mb-4">
                                <div class="card-inner">
                                    <form action="{{ url()->current() }}" method="GET">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Name</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" name="name" class="form-control" value="{{ request('name') }}" placeholder="Search by name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8 text-right align-self-end">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">Filter</button>
                                                    <a href="{{ url()->current() }}" class="btn btn-light">Reset</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card card-preview">
                                <div class="card-inner">
                                    <table class="nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head">
                                                <th>#</th>
                                                <th class="nk-tb-col"><span class="sub-text">Name</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">Tier</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">Description</span></th>
                                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">Created At</span></th>
                                                <th class="nk-tb-col nk-tb-col-tools ">
                                                    Status
                                                </th>
                                                <th class="nk-tb-col nk-tb-col-tools "></th>
                                                <th class="nk-tb-col nk-tb-col-tools "></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $subTier)
                                                <tr class="nk-tb-item">
                                                    <td class="nk-tb-col nk-tb-col-check">
                                                        {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <div class="user-card">
                                                            <div class="user-info">
                                                                <span class="tb-lead">{{ $subTier->name }} <span
                                                                        class="dot dot-success d-md-none ml-1"></span></span>
                                                                @if ($subTier->isPromoActive())
                                                                    <span class="badge badge-success badge-dim ml-1" title="Promotion Active"><em class="icon ni ni-spark"></em> Promo Active</span>
                                                                @elseif ($subTier->is_promotional && $subTier->promo_status === 'scheduled')
                                                                    <span class="badge badge-info badge-dim ml-1" title="Promotion Scheduled"><em class="icon ni ni-clock"></em> Promo Scheduled</span>
                                                                @elseif ($subTier->is_promotional && $subTier->promo_status === 'expired')
                                                                    <span class="badge badge-secondary badge-dim ml-1" title="Promotion Expired"><em class="icon ni ni-calender-date"></em> Promo Expired</span>
                                                                @elseif ($subTier->is_promotional)
                                                                    <span class="badge badge-primary badge-dim ml-1"><em class="icon ni ni-tag"></em> Promo</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="tb-lead">{{ optional($subTier->tier)->name }}</span>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <span class="tb-lead">{{ $subTier->description }}</span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-lg">
                                                        <span>
                                                            @php
                                                                $postdate = date_format($subTier->created_at, 'F d,Y');
                                                            @endphp
                                                            <?php
                                                            $timestamp = strtotime($postdate);
                                                            $newDateFormat = date('M. d, Y', $timestamp);
                                                            echo $newDateFormat;
                                                            ?>
                                                        </span>
                                                    </td>
                                                    <td class="nk-tb-col tb-col-lg">
                                                        @if ($subTier->admin_status == 0)
                                                            <span class="badge fmdq_Blue">Awaiting Approval</span>
                                                        @endif
                                                        @if ($subTier->admin_status == 1)
                                                            <span class="badge badge-primary">Approved</span>
                                                        @endif
                                                        @if ($subTier->admin_status == 2)
                                                            <span class="badge badge-danger">Rejected</span>
                                                        @endif
                                                        @if ($subTier->admin_status == 3)
                                                            <span class="badge badge-warning">Awaiting approval for
                                                                delete</span>
                                                        @endif
                                                    </td>
                                                    <td class="nk-tb-col tb-col-lg">
                                                        @if ($subTier->admin_status == 2)
                                                            {{ $subTier->note }}
                                                        @endif
                                                    </td>
                                                    <td class="nk-tb-col nk-tb-col-tools">
                                                        <ul class="nk-tb-actions gx-1">
                                                            <li>
                                                                <div class="drodown">
                                                                    <a href="#"
                                                                        class="dropdown-toggle btn btn-icon btn-trigger"
                                                                        data-toggle="dropdown"><em
                                                                            class="icon ni ni-more-h"></em></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <ul class="link-list-opt no-bdr">
                                                                            <li>
                                                                                <a href="#" data-toggle="modal"
                                                                                    data-target="#viewGroup-{{ $subTier->id }}">
                                                                                    <em class="icon ni ni-eye"></em><span>View Details</span>
                                                                                </a>
                                                                            </li>
                                                                            @if ($subTier->admin_status != 3)
                                                                                @if ($subTier->admin_status != 0)
                                                                                    @can('subscription-tier-edit')
                                                                                        <li>
                                                                                            <a href="#" data-toggle="modal"
                                                                                                data-target="#editGroup-{{ $subTier->id }}">
                                                                                                <em
                                                                                                    class="icon ni ni-edit"></em><span>Edit</span>
                                                                                            </a>
                                                                                        </li>
                                                                                    @endcan
                                                                                    @can('subscription-tier-create')
                                                                                        <li>
                                                                                            <a href="#" data-toggle="modal"
                                                                                                data-target="#duplicate-{{ $subTier->id }}">
                                                                                                <em
                                                                                                    class="icon ni ni-copy"></em><span>Duplicate</span>
                                                                                            </a>
                                                                                        </li>
                                                                                    @endcan
                                                                                    @can('subscription-tier-delete')
                                                                                        <li><a href="#" data-toggle="modal"
                                                                                                data-target="#deleteGroup-{{ $subTier->id }}"><em
                                                                                                    class="icon ni ni-trash"></em><span>Delete</span></a>
                                                                                        </li>
                                                                                    @endcan
                                                                                @endif
                                                                            @endif
                                                                            @if ($subTier->admin_status == 0)
                                                                                @can('subscription-tier-approve')
                                                                                    <li><a href="#" id="submit"
                                                                                            onclick="document.getElementById('approve-{{ $subTier->id }}').submit();"><em
                                                                                                class="icon ni ni-check-round-fill"></em><span>Approve</span></a>
                                                                                    </li>
                                                                                @endcan
                                                                                @can('subscription-tier-reject')
                                                                                    <li><a href="#" data-toggle="modal"
                                                                                            data-target="#reject-{{ $subTier->id }}"><em
                                                                                                class="icon ni ni-cross-circle-fill"></em><span>Reject</span></a>
                                                                                    </li>
                                                                                @endcan
                                                                            @endif
                                                                            @if ($subTier->admin_status == 3)
                                                                                @can('subscription-tier-approve')
                                                                                    <li><a href="#" id="submit"
                                                                                            onclick="document.getElementById('approve-{{ $subTier->id }}').submit();"><em
                                                                                                class="icon ni ni-check-round-fill"></em><span>Approve</span></a>
                                                                                    </li>
                                                                                @endcan
                                                                                @can('subscription-tier-reject')
                                                                                    <li><a href="#" data-toggle="modal"
                                                                                            data-target="#reject-{{ $subTier->id }}"><em
                                                                                                class="icon ni ni-cross-circle-fill"></em><span>Reject</span></a>
                                                                                    </li>
                                                                                @endcan
                                                                            @endif
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <form id="approve-{{ $subTier->id }}"
                                                            action="{{ route('subscriptionSubTierStatus', $subTier->id) }}" method="POST"
                                                            class="d-none" style="display: none">
                                                            @csrf
                                                            <input name="status" value="1">
                                                        </form>
                                                        <div class="modal fade" role="dialog"
                                                            id="reject-{{ $subTier->id }}">
                                                            <div class="modal-dialog modal-dialog-centered modal-lg"
                                                                role="document">
                                                                <div class="modal-content">
                                                                    <a href="#" class="close" data-dismiss="modal"><em
                                                                            class="icon ni ni-cross-sm"></em></a>
                                                                    <div class="modal-body modal-body-md">
                                                                        <h5 class="title">{{ $subTier->name }}</h5>
                                                                        <form method="POST"
                                                                            action="{{ route('subscriptionSubTierStatus', $subTier->id) }}"
                                                                            id="rejectForm-{{ $subTier->id }}">
                                                                            @csrf
                                                                            <div class="tab-content">
                                                                                <div class="tab-pane active" id="infomation">
                                                                                    <div class="row gy-4">
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label>Rejection Note</label>
                                                                                                <input hidden name="status"
                                                                                                    value="2">
                                                                                                <textarea required class="form-control" name="note"></textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-12">
                                                                                            <ul
                                                                                                class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                                                                <li>
                                                                                                    <button
                                                                                                        class="btn btn-lg btn-primary btn-block"
                                                                                                        id="rejectSubmitBtn-{{ $subTier->id }}"
                                                                                                        type="submit">
                                                                                                        <i class="fas fa-spinner fa-spin"
                                                                                                            style="display:none;"></i>
                                                                                                        <span
                                                                                                            class="btn-text">Submit</span>
                                                                                                    </button>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>
                                                                                </div><!-- .tab-pane -->
                                                                            </div><!-- .tab-content -->
                                                                        </form>
                                                                    </div><!-- .modal-body -->
                                                                </div><!-- .modal-content -->
                                                            </div><!-- .modal-dialog -->
                                                        </div><!-- .modal -->
                                                        <div class="modal fade" id="duplicate-{{ $subTier->id }}">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross"></em></a>
                                                                    <div class="modal-body modal-body-sm text-center">
                                                                        <form method="POST" action="{{ route('duplicateSubscriptionSubTier', $subTier->id) }}">
                                                                            @csrf
                                                                            <div class="nk-modal py-4">
                                                                                <h4 class="nk-modal-title">Duplicate "{{ $subTier->name }}"?</h4>
                                                                                <div class="nk-modal-text mt-n2">
                                                                                    <p class="text-soft">A copy will be created under the same tier as a new pending sub-tier awaiting approval.</p>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">Select Authoriser <span style="color: red;">*</span></label>
                                                                                        <div class="form-control-wrap">
                                                                                            <select required name="authorizer_id" class="form-select form-control">
                                                                                                <option value="">---</option>
                                                                                                @foreach ($authoriser as $auth)
                                                                                                    <option value="{{ $auth->id }}">{{ $auth->name }}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <ul class="d-flex justify-content-center gx-4 mt-4">
                                                                                    <li>
                                                                                        <button type="submit" class="btn btn-success">Yes, Duplicate</button>
                                                                                    </li>
                                                                                    <li>
                                                                                        <button data-dismiss="modal" class="btn btn-danger btn-dim">Cancel</button>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr><!-- .nk-tb-item  -->
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-inner">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted small">
                                            Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries
                                        </div>
                                        @if ($data->hasPages())
                                            <div>
                                                {{ $data->appends(request()->input())->links('vendor.pagination.bootstrap-4') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div><!-- .card-preview -->
                        </div><!-- .nk-block -->
                    </div>
                </div>
            </div>
        </div>
        <!-- content @e -->
        <!-- @@ Add Modal @e -->
        <div class="modal fade" role="dialog" id="addUser">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                    <div class="modal-body modal-body-md">
                        <h5 class="title">Add Subscription Sub-Tier</h5>
                        <form id="subTierForm" method="POST" action="{{ route('subscription-sub-tiers.store') }}">
                            @csrf
                            <div class="tab-content">
                                <div class="tab-pane active" id="infomation">
                                    <div class="row gy-4">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Main Tier <span style="color: red">*</span></label>
                                                <div class="form-control-wrap">
                                                    <select required class="form-select form-control" name="subscription_tier_id">
                                                        <option value="">---</option>
                                                        @foreach ($tiers as $tier)
                                                            <option value="{{ $tier->id }}">{{ $tier->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="lead-name">Name <span style="color: red">*</span></label>
                                                <div class="form-control-wrap">
                                                    <input required name="name" type="text" class="form-control" id="lead-name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="lead-desc">Description</label>
                                                <div class="form-control-wrap">
                                                    <textarea class="form-control" name="description" id="lead-desc"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Promotional Configuration Section -->
                                        <div class="col-md-12">
                                            <div class="card card-bordered bg-light">
                                                <div class="card-inner py-3">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input promo-toggle-input" id="promoToggle-add" name="is_promotional" value="1">
                                                        <label class="custom-control-label font-weight-bold text-dark" for="promoToggle-add">
                                                            <em class="icon ni ni-spark text-warning mr-1"></em> Enable Promotional Tab & Features
                                                        </label>
                                                    </div>
                                                    <div class="form-text text-muted small mt-1">
                                                        Append a promotional tab, attach targeted promotional features, and define a validity schedule window for this sub-tier.
                                                    </div>

                                                    <div class="promo-fields-container mt-3" id="promoFields-add" style="display: none;">
                                                        <div class="row g-3">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="promo_tab_title_add">Promotional Tab Title</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" class="form-control" name="promo_tab_title" id="promo_tab_title_add" placeholder="e.g., Special Offer, Research Discount">
                                                                    </div>
                                                                    <div class="form-text text-muted small">Label shown on the promotional tab button.</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="promo_badge_add">Promotional Badge</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" class="form-control" name="promo_badge" id="promo_badge_add" placeholder="e.g., Limited Time 20% Off, Exclusive">
                                                                    </div>
                                                                    <div class="form-text text-muted small">Badge tag displayed alongside sub-tier title.</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="discount_percentage_add">Discount Percentage (%)</label>
                                                                    <div class="form-control-wrap">
                                                                        <div class="form-icon form-icon-right"><em class="icon ni ni-percent"></em></div>
                                                                        <input type="number" step="0.01" min="0" max="100" class="form-control" name="discount_percentage" id="discount_percentage_add" placeholder="e.g. 20">
                                                                    </div>
                                                                    <div class="form-text text-muted small">Auto-deducted at payment gateway.</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="promo_start_at_add">Promotion Start Date & Time</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="datetime-local" class="form-control" name="promo_start_at" id="promo_start_at_add">
                                                                    </div>
                                                                    <div class="form-text text-muted small">When promotion becomes active (optional).</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="promo_end_at_add">Promotion End Date & Time</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="datetime-local" class="form-control" name="promo_end_at" id="promo_end_at_add">
                                                                    </div>
                                                                    <div class="form-text text-muted small">When promotion expires (optional).</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="promo_features_add">Targeted Promotional Features</label>
                                                                    <div class="form-control-wrap">
                                                                        <textarea class="form-control" name="promo_features" id="promo_features_add" rows="3" placeholder="Enter one promotional feature per line, e.g.:&#10;Free 1-Month API Sandbox Access&#10;Dedicated Technical Account Manager&#10;Unlimited Export Requests"></textarea>
                                                                    </div>
                                                                    <div class="form-text text-muted small">Enter one targeted feature per line. These will be highlighted on the promotional plan cards.</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="add-account">Select Authoriser <span
                                                        style="color: red;">*</span></label>
                                                <div class="form-control-wrap">
                                                    <select required name="authorizer_id" class="form-select form-control"
                                                        data-placeholder="Select one">
                                                        <option value="">---</option>
                                                        @foreach ($authoriser as $auth)
                                                            <option value="{{ $auth->id }}">
                                                                {{ $auth->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                <li>
                                                    <button class="btn btn-lg btn-primary btn-block" id="addSubmitBtn"
                                                        type="submit">
                                                        <i class="fas fa-spinner fa-spin" style="display:none;"></i>
                                                        <span class="btn-text">Submit</span>
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div><!-- .tab-pane -->
                            </div><!-- .tab-content -->
                        </form>
                    </div><!-- .modal-body -->
                </div><!-- .modal-content -->
            </div><!-- .modal-dialog -->
        </div><!-- .modal -->

        @foreach ($data as $subTier)
            <div class="modal fade" role="dialog" id="editGroup-{{ $subTier->id }}">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                        <div class="modal-body modal-body-md">
                            <h5 class="title">{{ $subTier->name }}</h5>
                            <form id="editForm-{{ $subTier->id }}" method="POST"
                                action="{{ route('subscriptionSubTierUpdate', $subTier->id) }}">
                                @csrf
                                <div class="tab-content">
                                    <div class="tab-pane active" id="infomation">
                                        <div class="row gy-4">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Main Tier</label>
                                                    <div class="form-control-wrap">
                                                        <select required class="form-select form-control" name="subscription_tier_id">
                                                            @foreach ($tiers as $tier)
                                                                <option value="{{ $tier->id }}" @if ($tier->id == $subTier->subscription_tier_id) selected @endif>
                                                                    {{ $tier->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Name</label>
                                                    <div class="form-control-wrap">
                                                        <input required value="{{ $subTier->name }}" name="name" type="text"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Description</label>
                                                    <div class="form-control-wrap">
                                                        <textarea class="form-control" name="description">{{ $subTier->description }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Promotional Configuration Section -->
                                            <div class="col-md-12">
                                                <div class="card card-bordered bg-light">
                                                    <div class="card-inner py-3">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input promo-toggle-input" id="promoToggle-edit-{{ $subTier->id }}" name="is_promotional" value="1" {{ $subTier->is_promotional ? 'checked' : '' }}>
                                                            <label class="custom-control-label font-weight-bold text-dark" for="promoToggle-edit-{{ $subTier->id }}">
                                                                <em class="icon ni ni-spark text-warning mr-1"></em> Enable Promotional Tab & Features
                                                            </label>
                                                        </div>
                                                        <div class="form-text text-muted small mt-1">
                                                            Append a promotional tab, attach targeted promotional features, and define a validity schedule window for this sub-tier.
                                                        </div>

                                                        <div class="promo-fields-container mt-3" id="promoFields-edit-{{ $subTier->id }}" style="{{ $subTier->is_promotional ? '' : 'display: none;' }}">
                                                            <div class="row g-3">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="promo_tab_title_edit_{{ $subTier->id }}">Promotional Tab Title</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text" class="form-control" name="promo_tab_title" id="promo_tab_title_edit_{{ $subTier->id }}" value="{{ $subTier->promo_tab_title }}" placeholder="e.g., Special Offer, Research Discount">
                                                                        </div>
                                                                        <div class="form-text text-muted small">Label shown on the promotional tab button.</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="promo_badge_edit_{{ $subTier->id }}">Promotional Badge</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text" class="form-control" name="promo_badge" id="promo_badge_edit_{{ $subTier->id }}" value="{{ $subTier->promo_badge }}" placeholder="e.g., Limited Time 20% Off, Exclusive">
                                                                        </div>
                                                                        <div class="form-text text-muted small">Badge tag displayed alongside sub-tier title.</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="discount_percentage_edit_{{ $subTier->id }}">Discount Percentage (%)</label>
                                                                        <div class="form-control-wrap">
                                                                            <div class="form-icon form-icon-right"><em class="icon ni ni-percent"></em></div>
                                                                            <input type="number" step="0.01" min="0" max="100" class="form-control" name="discount_percentage" id="discount_percentage_edit_{{ $subTier->id }}" value="{{ $subTier->discount_percentage }}" placeholder="e.g. 20">
                                                                        </div>
                                                                        <div class="form-text text-muted small">Auto-deducted at payment gateway.</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="promo_start_at_edit_{{ $subTier->id }}">Promotion Start Date & Time</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="datetime-local" class="form-control" name="promo_start_at" id="promo_start_at_edit_{{ $subTier->id }}" value="{{ $subTier->promo_start_at ? $subTier->promo_start_at->format('Y-m-d\TH:i') : '' }}">
                                                                        </div>
                                                                        <div class="form-text text-muted small">When promotion becomes active (optional).</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="promo_end_at_edit_{{ $subTier->id }}">Promotion End Date & Time</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="datetime-local" class="form-control" name="promo_end_at" id="promo_end_at_edit_{{ $subTier->id }}" value="{{ $subTier->promo_end_at ? $subTier->promo_end_at->format('Y-m-d\TH:i') : '' }}">
                                                                        </div>
                                                                        <div class="form-text text-muted small">When promotion expires (optional).</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="promo_features_edit_{{ $subTier->id }}">Targeted Promotional Features</label>
                                                                        <div class="form-control-wrap">
                                                                            <textarea class="form-control" name="promo_features" id="promo_features_edit_{{ $subTier->id }}" rows="3" placeholder="Enter one promotional feature per line...">{{ $subTier->promo_features }}</textarea>
                                                                        </div>
                                                                        <div class="form-text text-muted small">Enter one targeted feature per line. These will be highlighted on the promotional plan cards.</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="add-account">Select Authoriser <span
                                                            style="color: red;">*</span></label>
                                                    <div class="form-control-wrap">
                                                        <select required name="authorizer_id" class="form-select form-control"
                                                            data-placeholder="Select one">
                                                            <option value="">---</option>
                                                            @foreach ($authoriser as $auth)
                                                                <option value="{{ $auth->id }}">
                                                                    {{ $auth->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                    <li>
                                                        <button class="btn btn-lg btn-primary btn-block"
                                                            id="editSubmitBtn-{{ $subTier->id }}" type="submit">
                                                            <i class="fas fa-spinner fa-spin" style="display:none;"></i>
                                                            <span class="btn-text">Update</span>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!-- .tab-pane -->
                                </div><!-- .tab-content -->
                            </form>
                        </div><!-- .modal-body -->
                    </div><!-- .modal-content -->
                </div><!-- .modal-dialog -->
            </div><!-- .modal -->
        @endforeach

        <!-- @@  Delete Modal @e -->
        @foreach ($data as $subTier)
            <div class="modal fade" role="dialog" id="viewGroup-{{ $subTier->id }}">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                        <div class="modal-body modal-body-md">
                            <h5 class="title mb-3">Subscription Sub-Tier Details</h5>
                            <div class="row gy-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label text-muted">Sub-Tier Name</label>
                                        <div class="font-weight-bold font-size-16">{{ $subTier->name }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label text-muted">Parent Tier</label>
                                        <div class="font-weight-bold">{{ optional($subTier->tier)->name ?: 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label text-muted">Approval Status</label>
                                        <div>
                                            @if ($subTier->admin_status == 0)
                                                <span class="badge fmdq_Blue">Awaiting Approval</span>
                                            @elseif ($subTier->admin_status == 1)
                                                <span class="badge badge-primary">Approved</span>
                                            @elseif ($subTier->admin_status == 2)
                                                <span class="badge badge-danger">Rejected</span>
                                            @elseif ($subTier->admin_status == 3)
                                                <span class="badge badge-warning">Awaiting approval for delete</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label text-muted">Created Date</label>
                                        <div>{{ $subTier->created_at ? $subTier->created_at->format('M d, Y') : 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label text-muted">Description</label>
                                        <div>{{ $subTier->description ?: 'No description provided.' }}</div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="card card-bordered bg-light">
                                        <div class="card-inner">
                                            <h6 class="overline-title text-primary mb-2">Promotional Configuration</h6>
                                            <div class="row gy-3">
                                                <div class="col-md-4">
                                                    <span class="text-muted d-block small">Promotional Mode:</span>
                                                    @if ($subTier->isPromoActive())
                                                        <span class="badge badge-success"><em class="icon ni ni-spark"></em> Active Promotion</span>
                                                    @elseif ($subTier->is_promotional && $subTier->promo_status === 'scheduled')
                                                        <span class="badge badge-info"><em class="icon ni ni-clock"></em> Scheduled Promotion</span>
                                                    @elseif ($subTier->is_promotional && $subTier->promo_status === 'expired')
                                                        <span class="badge badge-secondary"><em class="icon ni ni-calender-date"></em> Expired Promotion</span>
                                                    @elseif ($subTier->is_promotional)
                                                        <span class="badge badge-primary">Enabled</span>
                                                    @else
                                                        <span class="badge badge-light text-muted">Disabled</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-3">
                                                    <span class="text-muted d-block small">Tab Title:</span>
                                                    <span class="font-weight-bold">{{ $subTier->promo_tab_title ?: 'Standard' }}</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <span class="text-muted d-block small">Badge:</span>
                                                    <span class="font-weight-bold">{{ $subTier->promo_badge ?: 'None' }}</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <span class="text-muted d-block small">Auto Discount:</span>
                                                    <span class="font-weight-bold text-success">{{ $subTier->discount_percentage ? $subTier->discount_percentage . '% OFF' : 'None' }}</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <span class="text-muted d-block small">Validity Window (Start):</span>
                                                    <span>{{ $subTier->promo_start_at ? $subTier->promo_start_at->format('M d, Y h:i A') : 'Immediately / Indefinite' }}</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <span class="text-muted d-block small">Validity Window (End):</span>
                                                    <span>{{ $subTier->promo_end_at ? $subTier->promo_end_at->format('M d, Y h:i A') : 'No Expiration / Indefinite' }}</span>
                                                </div>
                                                <div class="col-md-12">
                                                    <span class="text-muted d-block small mb-1">Attached Promotional Features:</span>
                                                    @if (!empty($subTier->promo_features_list))
                                                        <ul class="list-checked">
                                                            @foreach ($subTier->promo_features_list as $feature)
                                                                <li><em class="icon ni ni-check text-success mr-1"></em> {{ $feature }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <span class="text-muted font-italic">No promotional features attached.</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 text-right">
                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @foreach ($data as $subTier)
            <div class="modal fade" id="deleteGroup-{{ $subTier->id }}">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross"></em></a>
                        <div class="modal-body modal-body-sm text-center">
                            <form method="POST" action="{{ route('deleteSubscriptionSubTier', $subTier->id) }}">
                                @csrf
                                <div class="nk-modal py-4">
                                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-cross bg-danger"></em>
                                    <h4 class="nk-modal-title">Are You Sure ?</h4>
                                    <div class="nk-modal-text mt-n2">
                                        <p class="text-soft">This will delete the subscription sub-tier permanently, pending approval.</p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="add-account">Select Authoriser <span
                                                    style="color: red;">*</span></label>
                                            <div class="form-control-wrap">
                                                <select required name="authorizer_id" class="form-select form-control"
                                                    data-placeholder="Select one">
                                                    <option value="">---</option>
                                                    @foreach ($authoriser as $auth)
                                                        <option value="{{ $auth->id }}">
                                                            {{ $auth->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="d-flex justify-content-center gx-4 mt-4">
                                        <li>
                                            <button type="submit" class="btn btn-success">Yes, Delete it</button>
                                        </li>
                                        <li>
                                            <button data-dismiss="modal" class="btn btn-danger btn-dim">Cancel</button>
                                        </li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <script>
            function loading(buttonId) {
                $("#" + buttonId + " .fa-spinner").show();
                $("#" + buttonId + " .btn-text").html("Processing...");
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Promotional toggle handler
                $(document).on('change', '.promo-toggle-input', function() {
                    var containerId = $(this).attr('id').replace('promoToggle-', 'promoFields-');
                    if ($(this).is(':checked')) {
                        $('#' + containerId).slideDown(200);
                    } else {
                        $('#' + containerId).slideUp(200);
                    }
                });

                document.getElementById('subTierForm').addEventListener('submit', function(event) {
                    if (this.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        loading('addSubmitBtn');
                        document.getElementById('addSubmitBtn').disabled = true;
                    }
                    this.classList.add('was-validated');
                }, false);
            });
        </script>

    @endsection
