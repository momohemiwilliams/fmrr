@extends('layouts.auth')

@section('content')
    <div class="onb-bg">
        <div class="login-card">
            <div class="logo-container">
                <img src="{{ asset('public/users/assets/FMDQ-Logo.png') }}" alt="FMDQ Logo" />
            </div>
            <div class="app-name" style="font-size: 19px; margin-bottom: 8px;">
                Two-Factor Authentication
            </div>
            
            <p class="auth-subtitle-modern">
                Please enter the OTP sent to your email address to complete the login process.
            </p>

            @if (session('success'))
                <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 10px 14px; border-radius: 10px; font-size: 13px; text-align: center; margin-bottom: 16px; font-weight: 500;">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 10px 14px; border-radius: 10px; font-size: 13px; text-align: center; margin-bottom: 16px; font-weight: 500;">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" id="groupForm" action="{{ route('otp.verify.submit') }}">
                @csrf
                <div class="form-group-modern">
                    <label for="otp" class="form-label-modern">
                        One-Time Password (OTP) <span class="req-star">*</span>
                    </label>
                    <div class="input-wrapper-modern">
                        <input type="text" class="form-control-modern" placeholder="Enter 6-digit OTP code" name="otp" id="otp" required autofocus style="letter-spacing: 2px; font-weight: 600;" />
                    </div>
                </div>

                <div style="text-align: right; margin-bottom: 22px; margin-top: -4px;">
                    <a href="{{ route('otp.resend') }}" class="forgot-pass-link">Resend OTP?</a>
                </div>

                <button class="auth-submit-btn btn" id="addSubmitBtn" type="submit">
                    <i class="fas fa-spinner fa-spin" style="display:none;"></i>
                    <span class="btn-text">Verify and Login</span>
                </button>
            </form>
        </div>
@endsection
