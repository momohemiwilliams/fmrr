<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Application Received - {{ $planName ?? 'Academic Subscription' }}</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,600,700" rel="stylesheet" type="text/css">
    <style>
        html, body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            font-family: 'Roboto', sans-serif !important;
            font-size: 14px;
            line-height: 24px;
            color: #526484;
            background-color: #f5f6fa;
        }
        * { -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; margin: 0; padding: 0; }
        table, td { mso-table-lspace: 0pt !important; mso-table-rspace: 0pt !important; }
        table { border-spacing: 0 !important; border-collapse: collapse !important; table-layout: fixed !important; margin: 0 auto !important; }
        a { text-decoration: none; }
        .summary-box {
            background: #f8f9fc;
            border: 1px solid #e5e9f2;
            border-radius: 8px;
            padding: 18px 22px;
            margin: 20px 0;
        }
    </style>
</head>
<body width="100%" style="margin: 0; padding: 0 !important; background-color: #f5f6fa;">
    <center style="width: 100%; background-color: #f5f6fa;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#f5f6fa">
            <tr>
                <td style="padding: 40px 15px;">
                    <!-- Brand Header -->
                    <table style="width:100%; max-width:620px; margin:0 auto 20px;">
                        <tr>
                            <td style="text-align: center;">
                                <h3 style="margin: 0; color: #002060; font-size: 18px; font-weight: 700; letter-spacing: 0.5px;">
                                    Financial Markets Regulations &amp; Rules Repository
                                </h3>
                                <p style="margin: 4px 0 0; font-size: 12px; color: #ad8e4f; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                                    {{ !empty($isComplimentary) ? 'Academic Grant Program' : 'Academic Subscription Onboarding' }}
                                </p>
                            </td>
                        </tr>
                    </table>

                    <!-- Main Card -->
                    <table style="width:100%; max-width:620px; margin:0 auto; background-color:#ffffff; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden;">
                        <tr>
                            <td style="height: 5px; background: linear-gradient(90deg, #002060, #ad8e4f);"></td>
                        </tr>
                        <tr>
                            <td style="padding: 35px 35px 25px;">
                                <div style="display: inline-block; padding: 4px 12px; background: #e5f3ff; color: #002060; border-radius: 20px; font-size: 12px; font-weight: 700; margin-bottom: 15px; text-transform: uppercase;">
                                    Application Acknowledgment
                                </div>
                                <h2 style="font-size: 20px; color: #002060; font-weight: 700; margin-bottom: 12px; line-height: 1.3;">
                                    Application Received &amp; Under Review
                                </h2>
                                <p style="margin-bottom: 15px; color: #526484; font-size: 14.5px;">
                                    Dear <strong>{{ $student->name }}</strong>,
                                </p>
                                <p style="margin-bottom: 20px; color: #526484; font-size: 14px;">
                                    @if (!empty($isComplimentary))
                                        Thank you for applying for complimentary <strong>{{ $planName ?? 'Academic Subscription' }}</strong>@if(!empty($durationText)) ({{ $durationText }})@endif on the Financial Markets Regulations &amp; Rules Repository Portal.
                                    @else
                                        Thank you for submitting your onboarding and verification application for <strong>{{ $planName ?? 'Academic Subscription' }}</strong>@if(!empty($subTierName) && $subTierName !== ($planName ?? '')) ({{ $subTierName }})@endif on the Financial Markets Regulations &amp; Rules Repository Portal.
                                    @endif
                                </p>
                                <p style="margin-bottom: 20px; color: #526484; font-size: 14px;">
                                    We have received your uploaded proof of academic affiliation and onboarding details. Our compliance team is currently reviewing your submission to verify your academic eligibility.
                                </p>

                                <!-- Summary Box -->
                                <div class="summary-box">
                                    <h4 style="margin: 0 0 12px; font-size: 14px; color: #1c2b46; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Submitted Details:
                                    </h4>
                                    <table style="width: 100%; font-size: 13.5px;">
                                        <tr>
                                            <td style="color: #8094ae; padding: 4px 0; width: 45%;">Institution:</td>
                                            <td style="color: #1c2b46; font-weight: 600; padding: 4px 0;">{{ $verification->institution_name }}</td>
                                        </tr>
                                        @if ($verification->faculty_department)
                                            <tr>
                                                <td style="color: #8094ae; padding: 4px 0;">Faculty / Department:</td>
                                                <td style="color: #1c2b46; font-weight: 600; padding: 4px 0;">{{ $verification->faculty_department }}</td>
                                            </tr>
                                        @endif
                                        @if ($verification->role_within_institution)
                                            <tr>
                                                <td style="color: #8094ae; padding: 4px 0;">Academic Role:</td>
                                                <td style="color: #1c2b46; font-weight: 600; padding: 4px 0;">{{ $verification->role_within_institution }}</td>
                                            </tr>
                                        @endif
                                        @if ($verification->institutional_email)
                                            <tr>
                                                <td style="color: #8094ae; padding: 4px 0;">Institutional Email:</td>
                                                <td style="color: #0c2b70; font-weight: 600; padding: 4px 0;">{{ $verification->institutional_email }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td style="color: #8094ae; padding: 4px 0;">Target Plan:</td>
                                            <td style="color: #1c2b46; font-weight: 600; padding: 4px 0;">{{ $planName ?? 'Academic Subscription' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color: #8094ae; padding: 4px 0;">Institutional / Student ID:</td>
                                            <td style="color: #1c2b46; font-weight: 600; padding: 4px 0;">{{ $verification->student_id_number ?? 'Not specified' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color: #8094ae; padding: 4px 0;">Application Date:</td>
                                            <td style="color: #1c2b46; font-weight: 600; padding: 4px 0;">{{ $verification->created_at->format('M d, Y h:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color: #8094ae; padding: 4px 0;">Status:</td>
                                            <td style="padding: 4px 0;">
                                                <span style="color: #d97706; font-weight: 700; background: #fef3c7; padding: 2px 8px; border-radius: 4px; font-size: 12px;">
                                                    Pending Verification
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div style="background: #f0fdf4; border-left: 4px solid #16a34a; border-radius: 4px; padding: 14px 18px; margin: 25px 0;">
                                    <p style="margin: 0; color: #166534; font-size: 13.5px; line-height: 1.6;">
                                        <strong>What happens next?</strong><br>
                                        Verification is typically completed within 1 to 2 business days. Once verified and approved by the compliance team, your account registration/login email will automatically transition to your institutional email address (<strong>{{ $verification->institutional_email ?? $student->email }}</strong>), and you will receive an approval confirmation email allowing you to access the academic subscription tier.
                                    </p>
                                </div>

                                <p style="margin-top: 25px; color: #526484; font-size: 14px;">
                                    If you have any questions or need to provide additional academic documentation, please reply directly to this email.
                                </p>
                                <p style="margin-top: 25px; color: #526484; font-size: 14px;">
                                    Best regards,<br>
                                    <strong>FMDQ Portal Support Team</strong>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color: #fafbfc; padding: 20px 35px; border-top: 1px solid #edf2f9; text-align: center;">
                                <p style="font-size: 12px; color: #8094ae; margin: 0;">
                                    Financial Markets Regulations &amp; Rules Repository Portal &bull; All Rights Reserved.
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </center>
</body>
</html>
