@extends('layouts.headerexternal')

@section('content')
<link href="{{ asset('public/admin/css/dashlite.css') }}" rel="stylesheet" type="text/css" />

<style>
    .apply-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        padding: 40px 20px 80px;
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .apply-nav-bar {
        width: 100%;
        max-width: 680px;
        margin-bottom: 20px;
        display: flex;
        justify-content: flex-start;
    }

    .btn-apply-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.95);
        color: #0c2b70 !important;
        font-weight: 600;
        font-size: 13.5px;
        padding: 8px 16px;
        border-radius: 30px;
        text-decoration: none !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: all 0.25s ease;
        border: 1px solid rgba(255, 255, 255, 0.8);
    }

    .btn-apply-back:hover {
        background: #ffffff;
        color: #0c2b70 !important;
        transform: translateX(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }

    .apply-card {
        width: 100%;
        max-width: 680px;
        background: #ffffff;
        border-radius: 24px;
        padding: 44px 40px;
        box-shadow: 0 20px 50px -10px rgba(0, 0, 0, 0.35), 0 10px 20px -5px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.8);
        position: relative;
    }

    @media (max-width: 576px) {
        .apply-card {
            padding: 30px 20px;
            border-radius: 18px;
        }
    }

    .academic-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fef9ed;
        color: #92400e;
        border: 1px solid #fde68a;
        font-size: 12px;
        font-weight: 700;
        padding: 4px 14px;
        border-radius: 30px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 14px;
    }

    .apply-header {
        text-align: center;
        margin-bottom: 26px;
    }

    .apply-header h2 {
        color: #0c2b70;
        font-size: 26px;
        font-weight: 800;
        margin-bottom: 8px;
        letter-spacing: -0.3px;
    }

    .apply-header p {
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
        margin: 0 auto;
        max-width: 540px;
    }

    /* Benefits Strip */
    .benefits-strip {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 14px;
        margin-bottom: 28px;
    }

    @media (max-width: 576px) {
        .benefits-strip {
            grid-template-columns: 1fr;
            gap: 8px;
        }
    }

    .benefit-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 4px 6px;
    }

    .benefit-icon {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: #eff6ff;
        color: #1a3a8f;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
        border: 1px solid #dbeafe;
    }

    .benefit-text {
        font-size: 12px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.3;
    }

    .benefit-subtext {
        font-size: 11px;
        font-weight: 400;
        color: #64748b;
    }

    /* Form Fields */
    .apply-form .form-group {
        margin-bottom: 22px;
    }

    .apply-form label {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #1e293b;
        font-weight: 600;
        font-size: 13.5px;
        margin-bottom: 8px;
    }

    .apply-form label em {
        color: #0c2b70;
        font-size: 16px;
    }

    .input-wrap-custom {
        position: relative;
    }

    .apply-form input[type="text"],
    .apply-form input[type="email"],
    .apply-form select {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        font-size: 14px;
        font-family: inherit;
        background: #ffffff;
        outline: none;
        transition: all 0.2s ease;
    }

    .apply-form input[type="text"]:focus,
    .apply-form input[type="email"]:focus,
    .apply-form select:focus {
        border-color: #0c2b70;
        box-shadow: 0 0 0 3px rgba(12, 43, 112, 0.12);
    }

    /* Elevated File Dropzone Area */
    .file-dropzone-box {
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        background: #fafbfc;
        padding: 24px 20px;
        text-align: center;
        cursor: pointer;
        position: relative;
        transition: all 0.25s ease;
    }

    .file-dropzone-box:hover {
        border-color: #0c2b70;
        background: #f0f7ff;
    }

    .file-dropzone-box.has-file {
        border-color: #10b981;
        background: #f0fdf4;
    }

    .file-dropzone-box input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
    }

    .dropzone-icon-circle {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: #eff6ff;
        color: #1a3a8f;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 12px;
        transition: all 0.2s ease;
    }

    .file-dropzone-box:hover .dropzone-icon-circle {
        transform: translateY(-2px);
        background: #0c2b70;
        color: #ffffff;
    }

    .file-dropzone-box.has-file .dropzone-icon-circle {
        background: #ecfdf5;
        color: #059669;
    }

    .dropzone-main-text {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .dropzone-sub-text {
        font-size: 12.5px;
        color: #64748b;
        margin-bottom: 8px;
    }

    .dropzone-specs {
        display: inline-block;
        background: #e2e8f0;
        color: #475569;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
    }

    .file-selected-indicator {
        display: none;
        margin-top: 10px;
        padding: 8px 14px;
        background: #ffffff;
        border: 1px solid #a7f3d0;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        color: #065f46;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    /* Privacy Security Callout */
    .privacy-notice {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px 16px;
        margin-bottom: 26px;
        font-size: 12.5px;
        color: #64748b;
        line-height: 1.5;
    }

    .privacy-notice em {
        color: #10b981;
        font-size: 18px;
        flex-shrink: 0;
        margin-top: 1px;
    }

    /* Submit Button */
    .apply-submit {
        width: 100% !important;
        background: linear-gradient(135deg, #0c2b70 0%, #1a3a8f 100%);
        color: #ffffff !important;
        border: none !important;
        border-radius: 30px !important;
        padding: 15px 24px !important;
        font-weight: 700 !important;
        font-size: 15px !important;
        cursor: pointer !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        transition: all 0.25s ease !important;
        box-shadow: 0 8px 20px rgba(12, 43, 112, 0.28) !important;
    }

    .apply-submit:hover {
        background: linear-gradient(135deg, #143ca3 0%, #204dbf 100%) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 12px 26px rgba(12, 43, 112, 0.38) !important;
    }

    .apply-submit.is-loading,
    .apply-submit:disabled {
        opacity: 0.85 !important;
        cursor: not-allowed !important;
        pointer-events: none !important;
        transform: none !important;
        box-shadow: 0 4px 12px rgba(12, 43, 112, 0.2) !important;
    }

    .btn-apply-back.is-disabled {
        pointer-events: none !important;
        opacity: 0.55 !important;
        cursor: not-allowed !important;
        transform: none !important;
    }

    .apply-form.is-submitting .form-group {
        opacity: 0.72;
        pointer-events: none !important;
        user-select: none;
    }

    .apply-form.is-submitting input,
    .apply-form.is-submitting select,
    .apply-form.is-submitting .file-dropzone-box {
        background-color: #f1f5f9 !important;
        cursor: not-allowed !important;
        pointer-events: none !important;
    }

    /* Custom Alert */
    .custom-alert {
        border-radius: 14px;
        padding: 14px 18px;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13.5px;
    }
</style>

<div class="apply-container">
    <!-- Back to Subscriptions Navigation -->
    <div class="apply-nav-bar">
        <a href="{{ url('subscribe') }}" id="applyBackBtn" class="btn-apply-back">
            <em class="icon ni ni-arrow-left"></em> Back to Subscription Plans
        </a>
    </div>

    <div class="apply-card">
        <!-- Header -->
        <div class="apply-header">
            <div class="academic-badge">
                <em class="icon ni ni-cap"></em> Academic Onboarding &amp; Verification
            </div>
            <h2>Academic Onboarding &amp; Affiliation Profiling</h2>
            <p>
                Subscribing to an Academic Subscription mandates an academic onboarding profile and verification of institutional affiliation. Please provide your academic institution details, academic role, official institutional email, and upload a valid means of identification below.
            </p>
        </div>

        <!-- Benefits Strip -->
        <div class="benefits-strip">
            <div class="benefit-item">
                <div class="benefit-icon">
                    <em class="icon ni ni-building"></em>
                </div>
                <div>
                    <div class="benefit-text">Academic Profiling</div>
                    <div class="benefit-subtext">Institution, Faculty &amp; Role</div>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon">
                    <em class="icon ni ni-mail"></em>
                </div>
                <div>
                    <div class="benefit-text">Institutional Domain</div>
                    <div class="benefit-subtext">Mandatory email transition</div>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon">
                    <em class="icon ni ni-shield-check"></em>
                </div>
                <div>
                    <div class="benefit-text">Verified Access</div>
                    <div class="benefit-subtext">Authorized compliance review</div>
                </div>
            </div>
        </div>

        <!-- Flash Alerts -->
        @if (\Session::has('success'))
            <div class="alert alert-success custom-alert">
                <em class="icon ni ni-check-circle" style="font-size: 18px;"></em>
                <div>{{ \Session::get('success') }}</div>
            </div>
        @endif

        @if (\Session::has('error'))
            <div class="alert alert-danger custom-alert">
                <em class="icon ni ni-alert-circle" style="font-size: 18px;"></em>
                <div>{{ \Session::get('error') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger custom-alert" style="display: block;">
                <div class="d-flex align-items-center mb-1">
                    <em class="icon ni ni-cross-circle mr-1" style="font-size: 18px;"></em>
                    <strong>Please review the following errors:</strong>
                </div>
                <ul style="margin: 0; padding-left: 22px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Academic Affiliation Information Note -->
        <div class="alert alert-light border mb-4" style="border-radius: 14px; background: #f8fafc; font-size: 13px; color: #475569; border-left: 4px solid #0c2b70 !important;">
            <div class="d-flex align-items-center mb-1 font-weight-bold" style="color: #0c2b70;">
                <em class="icon ni ni-info-fill mr-1" style="font-size: 16px;"></em> Mandatory Academic Onboarding Requirement
            </div>
            Your current account registration email is <strong>{{ Auth::user()->email }}</strong>. Please complete the institutional profile below. Upon confirmation of your academic affiliation by the FMDQ portal administration, <strong>your account registration and login email will automatically transition to your verified institutional email address</strong>.
        </div>

        <!-- Application Form -->
        <form class="apply-form" id="applyOnboardingForm" method="POST" action="{{ route('studentVerification.store') }}" enctype="multipart/form-data">
            @csrf

            @if (isset($selectedPlan) && $selectedPlan)
                <div class="alert alert-primary d-flex align-items-center mb-4" style="background: #eef2ff; border: 1px solid #c7d2fe; border-radius: 14px; color: #1e1b4b; padding: 14px 18px;">
                    <em class="icon ni ni-cap mr-3" style="font-size: 28px; color: #4338ca;"></em>
                    <div>
                        <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #6366f1; letter-spacing: 0.5px;">Target Academic Plan</div>
                        <div style="font-size: 16px; font-weight: 700; color: #1e1b4b;">{{ $selectedPlan->name }}</div>
                        <div style="font-size: 12.5px; color: #475569; margin-top: 2px;">
                            Sub-Tier: <strong>{{ optional($selectedPlan->subTier)->name ?? 'Academic' }}</strong> &bull;
                            @if ((float)$selectedPlan->price <= 0)
                                Complimentary 30-Day Grant
                            @else
                                ₦{{ number_format($selectedPlan->price, 2) }} / {{ $selectedPlan->duration }} Days
                            @endif
                        </div>
                    </div>
                </div>
                <input type="hidden" name="subscription_plan_id" value="{{ $selectedPlan->id }}">
            @elseif (isset($academicPlans) && count($academicPlans) > 0)
                <div class="form-group">
                    <label for="subscription_plan_id">
                        <em class="icon ni ni-layers"></em> Target Academic Plan / Sub-Tier <span class="text-danger">*</span>
                    </label>
                    <div class="input-wrap-custom">
                        <select name="subscription_plan_id" id="subscription_plan_id" class="form-control" style="border-radius: 12px; height: 46px; border: 1.5px solid #e2e8f0; font-size: 14px; font-weight: 500;" required>
                            @foreach ($academicPlans as $acPlan)
                                <option value="{{ $acPlan->id }}" {{ old('subscription_plan_id') == $acPlan->id ? 'selected' : '' }}>
                                    {{ $acPlan->name }} ({{ optional($acPlan->subTier)->name ?? 'Academic' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

            <!-- 1. Academic Institution Name -->
            <div class="form-group">
                <label for="institution_name">
                    <em class="icon ni ni-building"></em> Academic Institution Name <span class="text-danger">*</span>
                </label>
                <div class="input-wrap-custom">
                    <input type="text" name="institution_name" id="institution_name" required 
                        placeholder="e.g. University of Lagos, Covenant University, Pan-Atlantic University"
                        value="{{ old('institution_name', Auth::user()->company_name) }}">
                </div>
                <small class="text-muted" style="font-size: 12px;">Full official name of your university, polytechnic, college, or recognized research institution.</small>
            </div>

            <!-- 2. Faculty / Department -->
            <div class="form-group">
                <label for="faculty_department">
                    <em class="icon ni ni-folder"></em> Faculty / Department <span class="text-danger">*</span>
                </label>
                <div class="input-wrap-custom">
                    <input type="text" name="faculty_department" id="faculty_department" required 
                        placeholder="e.g. Faculty of Social Sciences / Department of Economics"
                        value="{{ old('faculty_department') }}">
                </div>
                <small class="text-muted" style="font-size: 12px;">Specify your academic faculty and underlying department, school, or division.</small>
            </div>

            <!-- 3. User Role within Institution -->
            <div class="form-group">
                <label for="role_within_institution">
                    <em class="icon ni ni-user-check"></em> User Role within Institution <span class="text-danger">*</span>
                </label>
                <div class="input-wrap-custom">
                    <select name="role_within_institution" id="role_within_institution" required>
                        <option value="" disabled {{ old('role_within_institution') ? '' : 'selected' }}>Select your academic role</option>
                        <option value="Student" {{ old('role_within_institution') == 'Student' ? 'selected' : '' }}>Student (Undergraduate / Postgraduate / Master's / PhD)</option>
                        <option value="Lecturer / Professor" {{ old('role_within_institution') == 'Lecturer / Professor' ? 'selected' : '' }}>Lecturer / Senior Lecturer / Professor / Faculty Member</option>
                        <option value="Researcher" {{ old('role_within_institution') == 'Researcher' ? 'selected' : '' }}>Researcher / Research Fellow / Postdoctoral Scholar</option>
                        <option value="Administrative / Academic Staff" {{ old('role_within_institution') == 'Administrative / Academic Staff' ? 'selected' : '' }}>Administrative / Academic Staff (Librarian, Dean, Dept Officer)</option>
                        <option value="Other Academic Staff" {{ old('role_within_institution') == 'Other Academic Staff' ? 'selected' : '' }}>Other Academic / Institutional Representative</option>
                    </select>
                </div>
            </div>

            <!-- 4. Institutional Email Address with Transition Notice -->
            <div class="form-group">
                <label for="institutional_email">
                    <em class="icon ni ni-mail"></em> Institutional Email Address (.edu / official domain) <span class="text-danger">*</span>
                </label>
                <div class="input-wrap-custom">
                    <input type="email" name="institutional_email" id="institutional_email" required 
                        placeholder="e.g. yourname@university.edu or username@institution.edu.ng"
                        value="{{ old('institutional_email', Auth::user()->hasAcademicEmailDomain() ? Auth::user()->email : '') }}">
                </div>
                <div class="p-2 mt-2 rounded" style="background: #eff6ff; border: 1px solid #bfdbfe; font-size: 12.5px; color: #1e40af;">
                    <em class="icon ni ni-alert-circle mr-1"></em>
                    <strong>Mandatory Transition:</strong> Upon administrator verification of your academic affiliation, your account registration and portal sign-in email will automatically transition to this institutional email address.
                </div>
            </div>

            <!-- 5. Institutional ID / Staff ID / Student ID Number -->
            <div class="form-group">
                <label for="student_id_number">
                    <em class="icon ni ni-id-card"></em> Institutional ID / Staff ID / Student ID Number <span class="text-muted" style="font-size: 12px; font-weight: 400;">(Optional)</span>
                </label>
                <div class="input-wrap-custom">
                    <input type="text" name="student_id_number" id="student_id_number" 
                        placeholder="e.g. MAT/2023/10892 or STAFF/ACAD/4401"
                        value="{{ old('student_id_number') }}">
                </div>
            </div>

            <!-- 6. Valid Means of Identification (Proof) -->
            <div class="form-group">
                <label for="proof">
                    <em class="icon ni ni-file-docs"></em> Valid Means of Identification (Institutional ID / Faculty Card / Student ID) <span class="text-danger">*</span>
                </label>

                <!-- Modern Drag-and-Drop Area -->
                <div class="file-dropzone-box" id="dropzoneBox">
                    <input type="file" name="proof" id="proof" required accept=".pdf,.jpg,.jpeg,.png">
                    <div class="dropzone-icon-circle">
                        <em class="icon ni ni-upload-cloud"></em>
                    </div>
                    <div class="dropzone-main-text" id="dropzoneText">
                        Click to select or drag &amp; drop your Valid Means of Identification
                    </div>
                    <div class="dropzone-sub-text">
                        Institutional ID card, faculty/staff card, student ID, or official academic affiliation letter
                    </div>
                    <span class="dropzone-specs">Accepted: PDF, JPG, PNG (Max 5MB)</span>

                    <div class="file-selected-indicator" id="fileIndicator">
                        <em class="icon ni ni-check-circle"></em>
                        <span id="selectedFileName">Document selected</span>
                    </div>
                </div>
            </div>

            <!-- Privacy & Storage Notice -->
            <div class="privacy-notice">
                <em class="icon ni ni-shield-check"></em>
                <div>
                    <strong>Data Privacy Guaranteed:</strong> Your academic onboarding details and proof of identification are stored securely and encrypted. They are reviewed exclusively by authorized FMDQ compliance administrators to confirm academic eligibility.
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" id="applySubmitBtn" class="apply-submit">
                <em class="icon ni ni-shield-check"></em> <span class="btn-text">Complete Academic Onboarding &amp; Submit Verification</span>
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('proof');
        const dropzoneBox = document.getElementById('dropzoneBox');
        const fileIndicator = document.getElementById('fileIndicator');
        const selectedFileName = document.getElementById('selectedFileName');
        const dropzoneText = document.getElementById('dropzoneText');

        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files && this.files.length > 0) {
                    const file = this.files[0];
                    const extension = file.name.split('.').pop().toLowerCase();
                    const validExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
                    if (!validExtensions.includes(extension)) {
                        const errMsg = 'The selected file format is not supported. Please upload a PDF, JPG, JPEG, or PNG document.';
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Invalid File Format',
                                text: errMsg,
                                confirmButtonColor: '#0c2b70',
                                confirmButtonText: 'Understood'
                            });
                        } else if (typeof toastr !== 'undefined') {
                            toastr.error(errMsg);
                        } else {
                            alert(errMsg);
                        }
                        this.value = '';
                        fileIndicator.style.display = 'none';
                        dropzoneBox.classList.remove('has-file');
                        dropzoneText.textContent = 'Click to select or drag & drop your student proof';
                        return;
                    }

                    const maxSizeInBytes = 5 * 1024 * 1024; // 5 MB
                    if (file.size > maxSizeInBytes) {
                        const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'File Size Exceeded',
                                html: `Your file (<strong>${fileSizeMB} MB</strong>) exceeds the maximum allowed size of <strong>5 MB</strong>.<br><br>Please select a smaller file or compress your document.`,
                                confirmButtonColor: '#0c2b70',
                                confirmButtonText: 'Understood'
                            });
                        } else if (typeof toastr !== 'undefined') {
                            toastr.error(`Your file (${fileSizeMB} MB) exceeds the maximum allowed size of 5 MB.`);
                        } else {
                            alert(`Your file (${fileSizeMB} MB) exceeds the maximum allowed size of 5 MB. Please select a smaller file.`);
                        }
                        this.value = '';
                        fileIndicator.style.display = 'none';
                        dropzoneBox.classList.remove('has-file');
                        dropzoneText.textContent = 'Click to select or drag & drop your student proof';
                        return;
                    }

                    const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                    selectedFileName.textContent = `${file.name} (${fileSizeMB} MB)`;
                    fileIndicator.style.display = 'inline-flex';
                    dropzoneBox.classList.add('has-file');
                    dropzoneText.textContent = 'File ready to upload';
                } else {
                    fileIndicator.style.display = 'none';
                    dropzoneBox.classList.remove('has-file');
                    dropzoneText.textContent = 'Click to select or drag & drop your student proof';
                }
            });

            // Drag over effects
            ['dragenter', 'dragover'].forEach(eventName => {
                dropzoneBox.addEventListener(eventName, function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzoneBox.style.borderColor = '#0c2b70';
                    dropzoneBox.style.backgroundColor = '#eff6ff';
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzoneBox.addEventListener(eventName, function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzoneBox.style.borderColor = '';
                    dropzoneBox.style.backgroundColor = '';
                }, false);
            });
        }

        // Lock all interactive elements during Academic Onboarding submission
        const onboardingForm = document.getElementById('applyOnboardingForm');
        const submitBtn = document.getElementById('applySubmitBtn');
        const backBtn = document.getElementById('applyBackBtn');
        let originalSubmitHtml = submitBtn ? submitBtn.innerHTML : '';

        if (backBtn) {
            backBtn.addEventListener('click', function(e) {
                if (this.classList.contains('is-disabled') || (onboardingForm && onboardingForm.dataset.submitting === 'true')) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
        }

        if (onboardingForm && submitBtn) {
            const blockWhileSubmitting = function(e) {
                if (onboardingForm.dataset.submitting === 'true') {
                    e.preventDefault();
                    e.stopPropagation();
                }
            };

            onboardingForm.querySelectorAll('input, select, textarea').forEach(function(el) {
                el.addEventListener('keydown', blockWhileSubmitting, true);
                el.addEventListener('mousedown', blockWhileSubmitting, true);
                el.addEventListener('change', blockWhileSubmitting, true);
            });

            if (dropzoneBox) {
                dropzoneBox.addEventListener('click', blockWhileSubmitting, true);
                dropzoneBox.addEventListener('drop', blockWhileSubmitting, true);
            }

            onboardingForm.addEventListener('submit', function(e) {
                if (onboardingForm.dataset.submitting === 'true') {
                    e.preventDefault();
                    e.stopPropagation();
                    return;
                }

                if (onboardingForm.checkValidity && !onboardingForm.checkValidity()) {
                    return;
                }

                onboardingForm.dataset.submitting = 'true';
                onboardingForm.classList.add('is-submitting');

                // Prevent user edits without disabling inputs synchronously (disabled fields are omitted from POST)
                onboardingForm.querySelectorAll('input:not([type="hidden"]), select, textarea').forEach(function(el) {
                    if (el.tagName === 'INPUT' && el.type !== 'file') {
                        el.readOnly = true;
                    }
                    el.setAttribute('aria-disabled', 'true');
                    el.setAttribute('tabindex', '-1');
                });

                if (backBtn) {
                    backBtn.classList.add('is-disabled');
                    backBtn.setAttribute('aria-disabled', 'true');
                    backBtn.setAttribute('tabindex', '-1');
                }

                submitBtn.dataset.isSubmitting = 'true';
                submitBtn.classList.add('is-loading', 'submit-btn-spinning');
                submitBtn.setAttribute('aria-busy', 'true');
                submitBtn.innerHTML = '<span class="submit-btn-spinner" aria-hidden="true"></span><span>Submitting Verification...</span>';

                setTimeout(function() {
                    submitBtn.disabled = true;
                }, 0);
            });

            window.addEventListener('pageshow', function() {
                if (onboardingForm.dataset.submitting === 'true') {
                    delete onboardingForm.dataset.submitting;
                    onboardingForm.classList.remove('is-submitting');
                    onboardingForm.querySelectorAll('input:not([type="hidden"]), select, textarea').forEach(function(el) {
                        if (el.tagName === 'INPUT' && el.type !== 'file') {
                            el.readOnly = false;
                        }
                        el.removeAttribute('aria-disabled');
                        el.removeAttribute('tabindex');
                    });
                    if (backBtn) {
                        backBtn.classList.remove('is-disabled');
                        backBtn.removeAttribute('aria-disabled');
                        backBtn.removeAttribute('tabindex');
                    }
                    submitBtn.disabled = false;
                    delete submitBtn.dataset.isSubmitting;
                    submitBtn.classList.remove('is-loading', 'submit-btn-spinning');
                    submitBtn.removeAttribute('aria-busy');
                    submitBtn.innerHTML = originalSubmitHtml;
                }
            });
        }
    });
</script>
@endsection
