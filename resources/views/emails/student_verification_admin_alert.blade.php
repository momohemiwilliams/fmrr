<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New Student Research Application</title>
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
        .details-table td { padding: 8px 12px; font-size: 13.5px; border-bottom: 1px solid #edf2f9; }
        .details-label { font-weight: 600; color: #1c2b46; width: 38%; }
        .details-value { color: #364a63; }
        .btn-action {
            display: inline-block;
            background: #002060;
            color: #ffffff !important;
            font-size: 14px;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 6px;
            text-align: center;
            text-decoration: none;
            letter-spacing: 0.3px;
        }
    </style>
</head>
<body width="100%" style="margin: 0; padding: 0 !important; background-color: #f5f6fa;">
    <center style="width: 100%; background-color: #f5f6fa;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#f5f6fa">
            <tr>
                <td style="padding: 40px 15px;">
                    <!-- Top Portal Brand Header -->
                    <table style="width:100%; max-width:620px; margin:0 auto 20px;">
                        <tr>
                            <td style="text-align: center;">
                                <h3 style="margin: 0; color: #002060; font-size: 18px; font-weight: 700; letter-spacing: 0.5px;">
                                    Financial Markets Regulations &amp; Rules Repository
                                </h3>
                                <p style="margin: 4px 0 0; font-size: 12px; color: #8094ae; text-transform: uppercase; letter-spacing: 1px;">
                                    Portal Administration Alert
                                </p>
                            </td>
                        </tr>
                    </table>

                    <!-- Main Email Card -->
                    <table style="width:100%; max-width:620px; margin:0 auto; background-color:#ffffff; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden;">
                        <!-- Colored Top Strip -->
                        <tr>
                            <td style="height: 5px; background: linear-gradient(90deg, #002060, #ad8e4f);"></td>
                        </tr>
                        <tr>
                            <td style="padding: 35px 35px 25px;">
                                <div style="display: inline-block; padding: 4px 12px; background: #e5f3ff; color: #002060; border-radius: 20px; font-size: 12px; font-weight: 700; margin-bottom: 15px; text-transform: uppercase;">
                                    Action Required
                                </div>
                                <h2 style="font-size: 20px; color: #002060; font-weight: 700; margin-bottom: 12px; line-height: 1.3;">
                                    New Student Research Verification Application
                                </h2>
                                <p style="margin-bottom: 20px; color: #526484; font-size: 14px;">
                                    Dear Portal Administrator,
                                </p>
                                <p style="margin-bottom: 25px; color: #526484; font-size: 14px;">
                                    A new application for complimentary <strong>Student Research Access (30 Days)</strong> has been submitted on the portal and requires compliance review and verification.
                                </p>

                                <!-- Details Table -->
                                <table class="details-table" style="width: 100%; margin-bottom: 30px; background: #f8f9fc; border-radius: 6px; border: 1px solid #e5e9f2;">
                                    <tr>
                                        <td class="details-label">Applicant Name</td>
                                        <td class="details-value"><strong>{{ optional($verification->applicant)->name }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="details-label">Current Account Email</td>
                                        <td class="details-value"><a href="mailto:{{ optional($verification->applicant)->email }}" style="color: #002060;">{{ optional($verification->applicant)->email }}</a></td>
                                    </tr>
                                    <tr>
                                        <td class="details-label">Target Institutional Email</td>
                                        <td class="details-value">
                                            <strong style="color: #0c2b70;">{{ $verification->institutional_email ?? 'Not specified' }}</strong>
                                            <span style="font-size: 11px; color: #059669; display: block;">(Account will transition to this email upon approval)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="details-label">Academic Institution</td>
                                        <td class="details-value"><strong>{{ $verification->institution_name }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="details-label">Faculty / Department</td>
                                        <td class="details-value">{{ $verification->faculty_department ?? 'Not specified' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="details-label">Academic Role</td>
                                        <td class="details-value"><span style="background: #eef2ff; color: #4338ca; padding: 2px 8px; border-radius: 4px; font-weight: 600; font-size: 12px;">{{ $verification->role_within_institution ?? 'Student' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="details-label">ID / Staff / Matric No.</td>
                                        <td class="details-value">{{ $verification->student_id_number ?? 'Not specified' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="details-label">Target Plan</td>
                                        <td class="details-value">{{ optional($verification->plan)->name ?? 'Academic Subscription Tier' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="details-label">Submitted On</td>
                                        <td class="details-value">{{ $verification->created_at->format('M d, Y h:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="details-label">Current Status</td>
                                        <td class="details-value">
                                            <span style="color: #d97706; font-weight: 700; background: #fef3c7; padding: 2px 8px; border-radius: 4px; font-size: 12px;">
                                                Pending Review
                                            </span>
                                        </td>
                                    </tr>
                                </table>

                                <!-- CTA Button -->
                                <div style="text-align: center; margin: 30px 0 20px;">
                                    <a href="{{ $reviewUrl }}" class="btn-action">
                                        Review Application &amp; Proof Document &rarr;
                                    </a>
                                </div>

                                <p style="font-size: 12.5px; color: #8094ae; text-align: center; margin-top: 15px;">
                                    You can approve or reject this request with notes directly from the Student Verification management console.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color: #fafbfc; padding: 20px 35px; border-top: 1px solid #edf2f9; text-align: center;">
                                <p style="font-size: 12px; color: #8094ae; margin: 0;">
                                    This is an automated notification from Financial Markets Regulations &amp; Rules Repository Portal.
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
