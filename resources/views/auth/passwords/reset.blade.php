@extends('layouts.auth')

@section('content')
    <div class="onb-bg">
        <div class="login-card">
            <div class="logo-container">
                <img src="{{ asset('public/users/assets/FMDQ-Logo.png') }}" alt="FMDQ Logo" />
            </div>
            <div class="app-name" style="font-size: 20px; margin-bottom: 8px;">
                Recover your Password
            </div>
            <p class="auth-subtitle-modern">
                Create a new, strong password to secure your account.
            </p>

            <form method="POST" id="groupForm" action="{{ route('resetpasswordsubmit') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="form-group-modern">
                    <label for="password" class="form-label-modern">
                        New Password <span class="req-star">*</span>
                    </label>
                    <div class="input-wrapper-modern">
                        <input type="password" class="form-control-modern password-input" placeholder="New Password" name="password" id="password" required autofocus />
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

                <div class="form-group-modern">
                    <label for="new-password" class="form-label-modern">
                        Confirm Password <span class="req-star">*</span>
                    </label>
                    <div class="input-wrapper-modern">
                        <input type="password" class="form-control-modern password-input" placeholder="Confirm Password" name="password_confirmation" id="new-password" required />
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
                    <span class="btn-text">Reset Password</span>
                </button>
            </form>
        </div>
@endsection
