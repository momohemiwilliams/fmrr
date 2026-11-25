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
                <a href="{{ route('login') }}" class="auth-tab-modern active">Log in</a>
                <a href="{{ route('register') }}" class="auth-tab-modern">Sign up</a>
            </div>

            <form method="POST" id="groupForm" action="{{ route('login.post') }}">
                @csrf
                <div class="form-group-modern">
                    <label for="email" class="form-label-modern">
                        Email Address <span class="req-star">*</span>
                    </label>
                    <div class="input-wrapper-modern">
                        <input type="email" class="form-control-modern" placeholder="e.g. name@fmdqgroup.com" name="email" id="email" value="{{ old('email') }}" required autofocus />
                    </div>
                </div>

                <div class="form-group-modern">
                    <label for="password" class="form-label-modern">
                        Password <span class="req-star">*</span>
                    </label>
                    <div class="input-wrapper-modern">
                        <input type="password" class="form-control-modern password-input" placeholder="Enter your password" name="password" id="password" required />
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

                <div style="text-align: right; margin-bottom: 22px; margin-top: -4px;">
                    <a href="{{ route('password.request') }}" class="forgot-pass-link">Forgot Password?</a>
                </div>

                <button class="auth-submit-btn btn" id="addSubmitBtn" type="submit">
                    <i class="fas fa-spinner fa-spin" style="display:none;"></i>
                    <span class="btn-text">Log in</span>
                </button>
            </form>
        </div>
@endsection
