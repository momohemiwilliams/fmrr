<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Application Approved - {{ optional($verification->plan)->name ?? 'Academic Subscription' }}</title>
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
        .grant-card {
            background: linear-gradient(135deg, #002060 0%, #0c2b70 100%);
            border-radius: 10px;
            padding: 25px;
            color: #ffffff;
            margin: 25px 0;
            text-align: center;
        }
        .btn-portal {
            display: inline-block;
            background: #ad8e4f;
            color: #ffffff !important;
            font-size: 14.5px;
            font-weight: 700;
            padding: 13px 34px;
            border-radius: 30px;
            text-align: center;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(173, 142, 79, 0.3);
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
                                    {{ $subscription ? 'Academic Grant Program' : 'Academic Subscription Onboarding' }}
                                </p>
                            </td>
                        </tr>
                    </table>

                    <!-- Main Card -->
                    <table style="width:100%; max-width:620px; margin:0 auto; background-color:#ffffff; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden;">
                        <tr>
                            <td style="height: 5px; background: linear-gradient(90deg, #10b981, #ad8e4f);"></td>
                        </tr>
                        <tr>
                            <td style="padding: 35px 35px 25px;">
                                <div style="display: inline-block; padding: 4px 12px; background: #d1fae5; color: #065f46; border-radius: 20px; font-size: 12px; font-weight: 700; margin-bottom: 15px; text-transform: uppercase;">
                                    {{ $subscription ? 'Access Approved • Active' : 'Affiliation Verified • Approved' }}
                                </div>
                                <h2 style="font-size: 22px; color: #002060; font-weight: 700; margin-bottom: 12px; line-height: 1.3;">
                                    @if ($subscription)
                                        Congratulations! Your Student Research Access Is Approved
                                    @else
                                        Congratulations! Your Academic Affiliation Is Verified &amp; Approved
                                    @endif
                                </h2>
                                <p style="margin-bottom: 15px; color: #526484; font-size: 14.5px;">
                                    Dear <strong>{{ $student->name }}</strong>,
                                </p>
                                <p style="margin-bottom: 20px; color: #526484; font-size: 14px;">
                                    @if ($subscription)
                                        We are pleased to inform you that your application for complimentary <strong>Student Research Access</strong> has been verified and approved by the FMDQ Portal Compliance team.
                                    @else
                                        We are pleased to inform you that your academic onboarding and affiliation verification for <strong>{{ optional($verification->plan)->name ?? 'Academic Subscription' }}</strong> has been verified and approved by the FMDQ Portal Compliance team. You are now authorized to complete your subscription.
                                    @endif
                                </p>

                                @if ($subscription)
                                    <!-- Grant Pass Box -->
                                    <div class="grant-card">
                                        <span style="font-size: 12px; text-transform: uppercase; letter-spacing: 1.5px; opacity: 0.85; display: block; margin-bottom: 5px;">
                                            Academic Research Grant
                                        </span>
                                        <h3 style="font-size: 22px; color: #f4d078; margin: 0 0 15px; font-weight: 800;">
                                            30-Day Complimentary Pass
                                        </h3>
                                        <table style="margin: 0 auto; font-size: 13.5px; text-align: left; color: #ffffff;">
                                            <tr>
                                                <td style="padding: 4px 12px; opacity: 0.8;">Institution:</td>
                                                <td style="padding: 4px 12px; font-weight: 600;">{{ $verification->institution_name }}</td>
                                            </tr>
                                            @if ($verification->faculty_department)
                                                <tr>
                                                    <td style="padding: 4px 12px; opacity: 0.8;">Faculty/Dept:</td>
                                                    <td style="padding: 4px 12px; font-weight: 600;">{{ $verification->faculty_department }}</td>
                                                </tr>
                                            @endif
                                            @if ($verification->role_within_institution)
                                                <tr>
                                                    <td style="padding: 4px 12px; opacity: 0.8;">Academic Role:</td>
                                                    <td style="padding: 4px 12px; font-weight: 600;">{{ $verification->role_within_institution }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td style="padding: 4px 12px; opacity: 0.8;">Start Date:</td>
                                                <td style="padding: 4px 12px; font-weight: 600;">{{ str_replace('May.', 'May', \Carbon\Carbon::parse($subscription->start_date)->format('M. d, Y')) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 4px 12px; opacity: 0.8;">End Date:</td>
                                                <td style="padding: 4px 12px; font-weight: 600; color: #f4d078;">{{ str_replace('May.', 'May', \Carbon\Carbon::parse($subscription->end_date)->format('M. d, Y')) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 4px 12px; opacity: 0.8;">Access Scope:</td>
                                                <td style="padding: 4px 12px; font-weight: 600;">View-Only (Downloads Disabled)</td>
                                            </tr>
                                        </table>
                                    </div>
                                @else
                                    <div class="grant-card">
                                        <span style="font-size: 12px; text-transform: uppercase; letter-spacing: 1.5px; opacity: 0.85; display: block; margin-bottom: 5px;">
                                            Academic Sub-Tier Access Authorized
                                        </span>
                                        <h3 style="font-size: 22px; color: #f4d078; margin: 0 0 15px; font-weight: 800;">
                                            {{ optional($verification->plan)->name ?? 'Academic Plan' }}
                                        </h3>
                                        <table style="margin: 0 auto; font-size: 13.5px; text-align: left; color: #ffffff;">
                                            <tr>
                                                <td style="padding: 4px 12px; opacity: 0.8;">Institution:</td>
                                                <td style="padding: 4px 12px; font-weight: 600;">{{ $verification->institution_name }}</td>
                                            </tr>
                                            @if ($verification->faculty_department)
                                                <tr>
                                                    <td style="padding: 4px 12px; opacity: 0.8;">Faculty/Dept:</td>
                                                    <td style="padding: 4px 12px; font-weight: 600;">{{ $verification->faculty_department }}</td>
                                                </tr>
                                            @endif
                                            @if ($verification->role_within_institution)
                                                <tr>
                                                    <td style="padding: 4px 12px; opacity: 0.8;">Academic Role:</td>
                                                    <td style="padding: 4px 12px; font-weight: 600;">{{ $verification->role_within_institution }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td style="padding: 4px 12px; opacity: 0.8;">Verification:</td>
                                                <td style="padding: 4px 12px; font-weight: 600; color: #a7f3d0;">Approved &bull; Authorized</td>
                                            </tr>
                                        </table>
                                    </div>
                                @endif

                                <!-- Account Email Transition Notification Box -->
                                <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 8px; padding: 14px 18px; margin: 20px 0; font-size: 13.5px; color: #065f46; text-align: left;">
                                    <strong><span style="font-size: 15px;">&#10003;</span> Account Registration Email Updated:</strong><br>
                                    As part of the mandatory academic affiliation confirmation, your account login/registration email has been updated to your verified institutional address: <strong>{{ $student->email }}</strong>. Please use this email address for all future logins to the repository portal.
                                </div>

                                <div style="text-align: center; margin: 30px 0 20px;">
                                    @if ($subscription)
                                        <a href="{{ $loginUrl }}" class="btn-portal">
                                            Sign In to Access Portal &rarr;
                                        </a>
                                    @else
                                        <a href="{{ url('/subscribe') }}" class="btn-portal">
                                            Proceed to Complete Subscription &rarr;
                                        </a>
                                    @endif
                                </div>

                                <p style="font-size: 13.5px; color: #526484; line-height: 1.6; margin-top: 25px;">
                                    You can now log in using your verified institutional account email (<strong>{{ $student->email }}</strong>) to view financial market rules, regulations, circulars, and notices.
                                </p>
                                <p style="margin-top: 20px; color: #526484; font-size: 14px;">
                                    Best regards,<br>
                                    <strong>FMDQ Portal Team</strong>
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
