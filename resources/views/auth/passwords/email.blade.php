@extends('layouts.auth')

@section('content')
    <div class="onb-bg">
        <div class="login-card">
            <div class="logo-container">
                <img src="{{ asset('public/users/assets/FMDQ-Logo.png') }}" alt="FMDQ Logo" />
            </div>
            <div class="app-name" style="font-size: 20px; margin-bottom: 8px;">
                Forgot Password?
            </div>
            <p class="auth-subtitle-modern">
                Enter the email address associated with your account and we will email you instructions to reset your password.
            </p>

            <form method="POST" id="groupForm" action="{{ route('forgetpassword') }}">
                @csrf
                <div class="form-group-modern">
                    <label for="email" class="form-label-modern">
                        Enter Your Email <span class="req-star">*</span>
                    </label>
                    <div class="input-wrapper-modern">
                        <input type="email" class="form-control-modern" placeholder="e.g. name@fmdqgroup.com" name="email" id="email" value="{{ old('email') }}" required autofocus />
                    </div>
                </div>

                <button class="auth-submit-btn btn" id="addSubmitBtn" type="submit" style="margin-top: 10px;">
                    <i class="fas fa-spinner fa-spin" style="display:none;"></i>
                    <span class="btn-text">Send Email</span>
                </button>

                <p class="auth-footer-link">
                    Remember Password? <a href="{{ route('login') }}">Login</a>
                </p>
            </form>
        </div>
@endsection
