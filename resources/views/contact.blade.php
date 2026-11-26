@extends('layouts.externalex')

@section('content')
<style>
/* Modern FMDQ Helpdesk & Feedback Redesign */
.hd-main-container {
    background-color: #f1f5f9 !important;
    padding: 36px 20px 64px !important;
}

.hd-container {
    max-width: 1120px !important;
    width: 100% !important;
    margin: 0 auto !important;
    display: flex !important;
    align-items: flex-start !important;
    gap: 32px !important;
}

.profile-left-side {
    width: 330px !important;
    flex-shrink: 0 !important;
}

.profile-left-side-container {
    background: #0c2b70 !important;
    color: #ffffff !important;
    border-radius: 16px !important;
    border-top: 4px solid #C79D51 !important;
    padding: 28px 24px !important;
    box-shadow: 0 10px 28px rgba(12, 43, 112, 0.16) !important;
}

.profile-left-side-header {
    color: #ffffff !important;
    font-family: straightBold, sans-serif !important;
    font-size: 19px !important;
    font-weight: 700 !important;
    margin: 0 0 6px 0 !important;
}

.hd-contact-subtitle {
    color: rgba(255, 255, 255, 0.72);
    font-size: 13px;
    line-height: 1.5;
    margin-bottom: 20px;
}

.hd-contact-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.hd-contact-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding-top: 14px;
    border-top: 1px solid rgba(255, 255, 255, 0.12);
}

.hd-contact-icon {
    width: 34px;
    height: 34px;
    border-radius: 9px;
    background: rgba(199, 157, 81, 0.18);
    border: 1px solid rgba(199, 157, 81, 0.45);
    color: #ebc277;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 2px;
}

.profile-title {
    color: #ebc277 !important;
    font-size: 11.5px !important;
    font-weight: 600 !important;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 3px !important;
}

.profile-info,
.profile-info a {
    color: #ffffff !important;
    font-size: 13.5px !important;
    line-height: 1.5 !important;
    text-decoration: none !important;
    word-break: break-word;
}

.profile-info a:hover {
    color: #ebc277 !important;
    text-decoration: underline !important;
}

.w-70 {
    flex: 1 !important;
    min-width: 0 !important;
    width: auto !important;
}

.hd-form {
    border-radius: 16px !important;
    background-color: #ffffff !important;
    padding: 32px 34px !important;
    margin: 0 !important;
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05) !important;
}

.hd-form-header {
    padding-bottom: 18px;
    margin-bottom: 24px;
    border-bottom: 1px solid #e2e8f0;
}

.git {
    font-family: straightBold, sans-serif !important;
    font-size: 24px !important;
    font-weight: 700 !important;
    color: #0c2b70 !important;
    margin: 0 0 6px 0 !important;
}

.git-desc {
    font-family: customRegular, sans-serif !important;
    font-size: 14px !important;
    color: #64748b !important;
    line-height: 1.5 !important;
    margin: 0 !important;
}

.fb-form {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.fb-row {
    display: flex;
    gap: 18px;
    width: 100%;
}

.fb-col-50 {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
}

.fb-col-100 {
    width: 100%;
    display: flex;
    flex-direction: column;
}

.fb-label {
    display: flex;
    align-items: center;
    font-family: straightBold, sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 6px;
}

.fb-req {
    color: #dc2626;
    margin-left: 3px;
    font-weight: bold;
}

.fb-opt {
    font-family: customRegular, sans-serif;
    font-size: 12px;
    color: #64748b;
    margin-left: 6px;
    font-weight: normal;
}

.fb-input,
.fb-select,
.fb-textarea {
    width: 100%;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    outline: none;
    font-family: customRegular, sans-serif;
    font-size: 13.5px;
    color: #0f172a;
    padding: 9px 12px;
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
    box-sizing: border-box;
}

.fb-input,
.fb-select {
    height: 42px;
}

.fb-input::placeholder,
.fb-textarea::placeholder {
    color: #94a3b8;
    font-size: 13px;
}

.fb-input:hover,
.fb-select:hover,
.fb-textarea:hover {
    border-color: #94a3b8;
}

.fb-input:focus,
.fb-select:focus,
.fb-textarea:focus {
    border-color: #0c2b70;
    box-shadow: 0 0 0 3px rgba(12, 43, 112, 0.1);
}

.fb-input.is-invalid,
.fb-select.is-invalid,
.fb-textarea.is-invalid {
    border-color: #dc2626 !important;
}

.fb-select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%230c2b70' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 14px;
    padding-right: 34px;
    cursor: pointer;
}

.fb-textarea {
    resize: vertical;
    min-height: 115px;
    line-height: 1.55;
    padding: 10px 12px;
}

.fb-error-msg {
    color: #dc2626;
    font-size: 12px;
    margin-top: 4px;
    display: block;
}

.fb-submit-container {
    margin-top: 6px;
    display: flex;
    justify-content: flex-end;
}

.fb-submit-btn {
    height: 44px;
    padding: 0 28px;
    border-radius: 9px;
    border: 1px solid #0c2b70;
    background: #0c2b70;
    color: #ffffff;
    font-size: 14px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(12, 43, 112, 0.2);
    transition: all 0.15s ease;
}

.fb-submit-btn:hover {
    background: #091f52;
    border-color: #091f52;
    transform: translateY(-1px);
}

@media (max-width: 900px) {
    .hd-container {
        flex-direction: column !important;
    }
    .profile-left-side {
        width: 100% !important;
    }
}

@media (max-width: 640px) {
    .fb-row {
        flex-direction: column;
        gap: 18px;
    }
    .hd-form {
        padding: 24px 20px !important;
    }
    .fb-submit-btn {
        width: 100%;
    }
}
</style>

    <section class="hd-main-container">
        <div class="hd-container">
            <div class="profile-left-side">
                <div class="profile-left-side-container">
                    <p class="profile-left-side-header">Contact Information</p>
                    <div class="hd-contact-subtitle">Reach out to our Market Regulation &amp; Helpdesk team directly.</div>

                    <div class="hd-contact-list">
                        <div class="hd-contact-item">
                            <span class="hd-contact-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            </span>
                            <div>
                                <div class="profile-title">Email</div>
                                <div class="profile-info"><a href="mailto:mbg@fmdqgroup.com">mbg@fmdqgroup.com</a></div>
                            </div>
                        </div>

                        <div class="hd-contact-item">
                            <span class="hd-contact-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            </span>
                            <div>
                                <div class="profile-title">Phone</div>
                                <div class="profile-info"><a href="tel:+2349113977152">+2349113977152</a></div>
                            </div>
                        </div>

                        <div class="hd-contact-item">
                            <span class="hd-contact-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            </span>
                            <div>
                                <div class="profile-title">Address</div>
                                <div class="profile-info">
                                   Exchange Place, 35 Idowu Taylor Street, Victoria Island, Lagos, Nigeria
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @php
                $user = Auth::user();
                $nameParts = $user ? explode(' ', $user->name, 2) : [];
                $defaultFname = $user->fname ?? ($nameParts[0] ?? '');
                $defaultLname = $user->lname ?? ($nameParts[1] ?? '');
                $defaultEmail = $user->email ?? '';
                $defaultInstitution = $user->company_name ?? ($user->institution ?? '');
            @endphp

            <div class="w-70">
                <div class="hd-form">
                    <div class="hd-form-header">
                        <div class="git">Feedback</div>
                        <div class="git-desc">
                            Please use the form below to report an issue, make a suggestion or ask a question.
                        </div>
                    </div>
                    <form method="POST" action="{{ route('contactpost') }}" class="fb-form" id="feedbackForm">
                        @csrf

                        {{-- Row 1: First Name & Last Name --}}
                        <div class="fb-row">
                            <div class="fb-col-50">
                                <label for="fname" class="fb-label">
                                    First Name <span class="fb-req">*</span>
                                </label>
                                <input type="text"
                                    class="fb-input @error('fname') is-invalid @enderror"
                                    placeholder="Enter your first name"
                                    name="fname"
                                    id="fname"
                                    required
                                    value="{{ old('fname', $defaultFname) }}" />
                                @error('fname')
                                    <span class="fb-error-msg">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="fb-col-50">
                                <label for="lname" class="fb-label">
                                    Last Name <span class="fb-req">*</span>
                                </label>
                                <input type="text"
                                    class="fb-input @error('lname') is-invalid @enderror"
                                    placeholder="Enter your last name"
                                    name="lname"
                                    id="lname"
                                    required
                                    value="{{ old('lname', $defaultLname) }}" />
                                @error('lname')
                                    <span class="fb-error-msg">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Row 2: Institution --}}
                        <div class="fb-col-100">
                            <label for="institution" class="fb-label">
                                Institution <span class="fb-req">*</span>
                            </label>
                            <input type="text"
                                class="fb-input @error('institution') is-invalid @enderror"
                                placeholder="Enter your institution or company name"
                                name="institution"
                                id="institution"
                                required
                                value="{{ old('institution', $defaultInstitution) }}" />
                            @error('institution')
                                <span class="fb-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Row 3: Member Status --}}
                        <div class="fb-col-100">
                            <label for="member_status" class="fb-label">
                                Member or Non-Member of FMDQ Securities Exchange Limited <span class="fb-opt">(Optional)</span>
                            </label>
                            <select class="fb-select @error('member_status') is-invalid @enderror"
                                name="member_status"
                                id="member_status">
                                <option value="" {{ old('member_status') ? '' : 'selected' }}>-- Select Status (Optional) --</option>
                                <option value="Member" {{ old('member_status') == 'Member' ? 'selected' : '' }}>Member</option>
                                <option value="Non-Member" {{ old('member_status') == 'Non-Member' ? 'selected' : '' }}>Non-Member</option>
                            </select>
                            @error('member_status')
                                <span class="fb-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Row 4: Email Address & Subject --}}
                        <div class="fb-row">
                            <div class="fb-col-50">
                                <label for="email" class="fb-label">
                                    Email Address <span class="fb-req">*</span>
                                </label>
                                <input type="email"
                                    class="fb-input @error('email') is-invalid @enderror"
                                    placeholder="e.g. name@company.com"
                                    name="email"
                                    id="email"
                                    required
                                    value="{{ old('email', $defaultEmail) }}" />
                                @error('email')
                                    <span class="fb-error-msg">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="fb-col-50">
                                <label for="subject" class="fb-label">
                                    Subject <span class="fb-req">*</span>
                                </label>
                                <input type="text"
                                    class="fb-input @error('subject') is-invalid @enderror"
                                    placeholder="Brief topic of your feedback"
                                    name="subject"
                                    id="subject"
                                    required
                                    value="{{ old('subject') }}" />
                                @error('subject')
                                    <span class="fb-error-msg">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Row 5: Message --}}
                        <div class="fb-col-100">
                            <label for="message" class="fb-label">
                                Message <span class="fb-req">*</span>
                            </label>
                            <textarea
                                class="fb-textarea @error('feedback') is-invalid @enderror"
                                placeholder="Please describe your issue, suggestion or question in detail..."
                                name="feedback"
                                id="message"
                                rows="4"
                                required>{{ old('feedback') }}</textarea>
                            @error('feedback')
                                <span class="fb-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Row 6: Submit Button --}}
                        <div class="fb-submit-container">
                            <button type="submit" class="fb-submit-btn" id="fbSubmitBtn">
                                <span>Submit Feedback</span>
                                <span>&rarr;</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
