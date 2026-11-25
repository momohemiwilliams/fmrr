@extends('layouts.master')

@section('content')
@php
    $words = explode(' ', trim($user->name));
    $initials = '';
    foreach ($words as $w) {
        if (!empty($w)) {
            $initials .= strtoupper(substr($w, 0, 1));
        }
        if (strlen($initials) >= 2) break;
    }
    if (empty($initials)) {
        $initials = 'PA';
    }
@endphp

<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <!-- Page Header -->
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Profile Settings</h3>
                            <div class="nk-block-des text-soft">
                                <p>Manage your internal user account details, corporate information, and security credentials.</p>
                            </div>
                        </div>
                        <div class="nk-block-head-content">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                                <em class="icon ni ni-arrow-left"></em><span>Back to Dashboard</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-icon alert-dismissible">
                        <em class="icon ni ni-check-circle"></em>
                        <strong>Success!</strong> {{ session('success') }}
                        <button class="close" data-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-icon alert-dismissible">
                        <em class="icon ni ni-cross-circle"></em>
                        <strong>Error!</strong> {{ session('error') }}
                        <button class="close" data-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-icon alert-dismissible">
                        <em class="icon ni ni-alert-circle"></em>
                        <strong>Please check the form:</strong>
                        <ul class="mb-0 mt-1 pl-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button class="close" data-dismiss="alert"></button>
                    </div>
                @endif

                <div class="nk-block">
                    <div class="row g-gs">
                        <!-- Left Column: User Summary Card -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card card-bordered">
                                <div class="card-inner text-center border-bottom pb-4" style="background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);">
                                    <div class="user-avatar-custom mb-3 mx-auto">
                                        <div style="width: 86px; height: 86px; border-radius: 50%; background: linear-gradient(135deg, #0c2b70 0%, #1a3a8f 100%); color: #ffffff; font-size: 28px; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; border: 3px solid #d5a73b; box-shadow: 0 4px 12px rgba(12, 43, 112, 0.25);">
                                            {{ $initials }}
                                        </div>
                                    </div>
                                    <h5 class="card-title mb-1" style="color: #0c2b70; font-weight: 700;">{{ $user->name }}</h5>
                                    <span class="sub-text text-muted d-block mb-3">{{ $user->email }}</span>
                                    
                                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-1 mb-2">
                                        <span class="badge badge-dim badge-primary mr-1 mb-1" style="font-weight: 600;">Internal User</span>
                                        <span class="badge badge-dim badge-success mr-1 mb-1">Active</span>
                                        @if($user->group)
                                            <span class="badge badge-dim badge-secondary mr-1 mb-1">{{ $user->group->name }}</span>
                                        @endif
                                    </div>

                                    @if($user->roles && $user->roles->count() > 0)
                                        <div class="mt-2">
                                            @foreach($user->roles as $role)
                                                <span class="badge badge-pill badge-outline-primary mr-1 mb-1" style="font-size: 11px;">
                                                    <em class="icon ni ni-shield-check mr-1"></em>{{ $role->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <div class="card-inner">
                                    <h6 class="overline-title text-primary-alt mb-3">Account Overview</h6>
                                    <ul class="data-list is-compact">
                                        <li class="data-item">
                                            <div class="data-col">
                                                <div class="data-label">User ID</div>
                                                <div class="data-value font-weight-bold">#{{ $user->id }}</div>
                                            </div>
                                        </li>
                                        <li class="data-item">
                                            <div class="data-col">
                                                <div class="data-label">Phone</div>
                                                <div class="data-value">{{ $user->phone ?? 'Not set' }}</div>
                                            </div>
                                        </li>
                                        <li class="data-item">
                                            <div class="data-col">
                                                <div class="data-label">Organization</div>
                                                <div class="data-value">{{ $user->company_name ?? 'FMDQ Group PLC' }}</div>
                                            </div>
                                        </li>
                                        <li class="data-item">
                                            <div class="data-col">
                                                <div class="data-label">Session Timeout</div>
                                                <div class="data-value text-primary font-weight-bold">{{ $sessionTimeout }} minutes</div>
                                            </div>
                                        </li>
                                        <li class="data-item">
                                            <div class="data-col">
                                                <div class="data-label">Last Password Change</div>
                                                <div class="data-value text-soft">
                                                    {{ $user->password_changed_at ? $user->password_changed_at->format('M d, Y') : 'Never' }}
                                                </div>
                                            </div>
                                        </li>
                                        <li class="data-item">
                                            <div class="data-col">
                                                <div class="data-label">Account Created</div>
                                                <div class="data-value text-soft">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Settings Forms -->
                        <div class="col-xl-8 col-lg-7">
                            <!-- Card 1: Personal Details Form -->
                            <div class="card card-bordered mb-4">
                                <div class="card-inner">
                                    <div class="card-title-group mb-3">
                                        <div class="card-title">
                                            <h6 class="title" style="color: #0c2b70;">Personal &amp; Contact Details</h6>
                                            <p class="text-soft">Update your display name and contact phone number.</p>
                                        </div>
                                    </div>

                                    <form method="POST" action="{{ route('admin.profile.update') }}">
                                        @csrf
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="profile_name">Full Name <span class="text-danger">*</span></label>
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-left">
                                                            <em class="icon ni ni-user"></em>
                                                        </div>
                                                        <input type="text" class="form-control" id="profile_name" name="name" value="{{ old('name', $user->name) }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="profile_email">
                                                        Email Address 
                                                        <span class="badge badge-dim badge-light ml-1" style="font-size: 10px;">Corporate ID</span>
                                                    </label>
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-left">
                                                            <em class="icon ni ni-mail"></em>
                                                        </div>
                                                        <input type="email" class="form-control bg-light" id="profile_email" value="{{ $user->email }}" readonly title="Corporate emails are managed by Administrator">
                                                    </div>
                                                    <span class="form-note">Corporate email cannot be changed directly.</span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="profile_phone">Phone Number</label>
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-left">
                                                            <em class="icon ni ni-call"></em>
                                                        </div>
                                                        <input type="text" class="form-control" id="profile_phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g. +234 801 234 5678">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="profile_company">Company / Department</label>
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-left">
                                                            <em class="icon ni ni-building"></em>
                                                        </div>
                                                        <input type="text" class="form-control bg-light" id="profile_company" value="{{ $user->company_name ?? 'FMDQ Group PLC' }}" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 mt-3">
                                                <button type="submit" class="btn btn-primary">
                                                    <em class="icon ni ni-check mr-1"></em> Save Profile Changes
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Card 2: Security & Password Update -->
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="card-title-group mb-3">
                                        <div class="card-title">
                                            <h6 class="title" style="color: #0c2b70;">Account Security &amp; Password</h6>
                                            <p class="text-soft">Ensure your account is protected with a secure, complex password.</p>
                                        </div>
                                    </div>

                                    <!-- Policy Alert Box -->
                                    <div class="alert alert-light border mb-4" style="background: #f8fafc;">
                                        <div class="d-flex align-items-center mb-1">
                                            <em class="icon ni ni-shield-alert text-primary mr-2" style="font-size: 18px;"></em>
                                            <strong style="color: #0c2b70; font-size: 13px;">Corporate Password Policy</strong>
                                        </div>
                                        <ul class="text-muted mb-0 pl-4" style="font-size: 12px; line-height: 1.6;">
                                            <li>Minimum of <strong>8 characters</strong> in length</li>
                                            <li>Must contain at least <strong>one uppercase letter (A-Z)</strong> and <strong>one lowercase letter (a-z)</strong></li>
                                            <li>Must contain at least <strong>one numeric digit (0-9)</strong></li>
                                            <li>Must contain at least <strong>one special symbol</strong> (@, $, !, %, *, #, ?, &amp;, .)</li>
                                        </ul>
                                    </div>

                                    <form method="POST" action="{{ route('admin.profile.password') }}">
                                        @csrf
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="current_password">Current Password <span class="text-danger">*</span></label>
                                                    <div class="form-control-wrap">
                                                        <a href="#" class="form-icon form-icon-right passcode-switch" data-target="current_password">
                                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                        </a>
                                                        <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter your current password" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="new_password">New Password <span class="text-danger">*</span></label>
                                                    <div class="form-control-wrap">
                                                        <a href="#" class="form-icon form-icon-right passcode-switch" data-target="new_password">
                                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                        </a>
                                                        <input type="password" class="form-control" id="new_password" name="password" placeholder="Enter new strong password" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="password_confirmation">Confirm New Password <span class="text-danger">*</span></label>
                                                    <div class="form-control-wrap">
                                                        <a href="#" class="form-icon form-icon-right passcode-switch" data-target="password_confirmation">
                                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                        </a>
                                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 mt-3">
                                                <button type="submit" class="btn btn-primary">
                                                    <em class="icon ni ni-shield-check mr-1"></em> Update Password
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
@endsection

