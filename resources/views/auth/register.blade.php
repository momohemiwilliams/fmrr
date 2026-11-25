@extends('layouts.auth')

@section('content')
    <div class="onb-bg">
        <div class="login-card">
            <div class="logo-container">
                <img src="{{ asset('public/users/assets/FMDQ-Logo.png') }}" alt="FMDQ Logo" />
            </div>
            <div class="app-name">
                Financial Markets Rules &amp; Regulations Portal
            </div>

            <div class="auth-tabs-modern">
                <a href="{{ route('login') }}" class="auth-tab-modern">Log in</a>
                <a href="{{ route('register') }}" class="auth-tab-modern active">Sign up</a>
            </div>

            <form method="POST" id="groupForm" action="{{ route('register.post') }}">
                @csrf
                <div class="form-row-2col">
                    <div class="form-group-modern">
                        <label for="fname" class="form-label-modern">
                            First Name <span class="req-star">*</span>
                        </label>
                        <div class="input-wrapper-modern">
                            <input type="text" class="form-control-modern" placeholder="First Name" name="fname" id="fname" value="{{ old('fname', old('name')) }}" required autofocus />
                        </div>
                    </div>

                    <div class="form-group-modern">
                        <label for="lname" class="form-label-modern">
                            Last Name <span class="req-star">*</span>
                        </label>
                        <div class="input-wrapper-modern">
                            <input type="text" class="form-control-modern" placeholder="Last Name" name="lname" id="lname" value="{{ old('lname') }}" required />
                        </div>
                    </div>
                </div>

                <div class="form-group-modern">
                    <label for="email" class="form-label-modern">
                        Email Address <span class="req-star">*</span>
                    </label>
                    <div class="input-wrapper-modern">
                        <input type="email" class="form-control-modern" placeholder="name@company.com" name="email" id="email" value="{{ old('email') }}" required />
                    </div>
                </div>

                <div class="form-group-modern">
                    <label for="phone" class="form-label-modern">
                        Phone Number <span class="req-star">*</span>
                    </label>
                    <div class="input-wrapper-modern">
                        <input type="tel" class="form-control-modern" placeholder="0801 234 5678" name="phone" id="phone" value="{{ old('phone') }}" required />
                    </div>
                </div>

                <div class="form-group-modern">
                    <label for="company_name" class="form-label-modern">
                        Company Name <span style="font-weight: 400; color: #94a3b8; font-size: 12px;">(Optional)</span>
                    </label>
                    <div class="input-wrapper-modern">
                        <input type="text" class="form-control-modern" placeholder="Your Organization or Institution" name="company_name" id="company_name" value="{{ old('company_name') }}" />
                    </div>
                </div>

                <div class="form-group-modern">
                    <label for="password" class="form-label-modern">
                        Choose Password <span class="req-star">*</span>
                    </label>
                    <div class="input-wrapper-modern">
                        <input type="password" class="form-control-modern password-input" placeholder="Create strong password" name="password" id="password" required />
                        <button type="button" class="password-toggle-btn" aria-label="Toggle password visibility">
                            <svg class="eye-icon eye-open" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            <svg class="eye-icon eye-closed d-none" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                <line x1="1" y1="1" x2="23" y2="23"></line>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="password-policy-box">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <span>Password must have at least 8 characters, one uppercase, one lowercase, one number and one special character.</span>
                </div>

                <button class="auth-submit-btn btn" id="addSubmitBtn" type="submit">
                    <i class="fas fa-spinner fa-spin" style="display:none;"></i>
                    <span class="btn-text">Sign Up</span>
                </button>
            </form>
        </div>
@endsection
