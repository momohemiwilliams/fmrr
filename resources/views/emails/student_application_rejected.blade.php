<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Update on Student Research Application</title>
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
        .reason-box {
            background: #fff5f5;
            border: 1px solid #fecaca;
            border-left: 4px solid #ef4444;
            border-radius: 6px;
            padding: 16px 20px;
            margin: 20px 0;
            color: #991b1b;
            font-size: 14px;
        }
        .btn-reapply {
            display: inline-block;
            background: #002060;
            color: #ffffff !important;
            font-size: 14px;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 6px;
            text-align: center;
            text-decoration: none;
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
                                    Academic Grant Program
                                </p>
                            </td>
                        </tr>
                    </table>

                    <!-- Main Card -->
                    <table style="width:100%; max-width:620px; margin:0 auto; background-color:#ffffff; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden;">
                        <tr>
                            <td style="height: 5px; background: linear-gradient(90deg, #ef4444, #ad8e4f);"></td>
                        </tr>
                        <tr>
                            <td style="padding: 35px 35px 25px;">
                                <div style="display: inline-block; padding: 4px 12px; background: #fee2e2; color: #991b1b; border-radius: 20px; font-size: 12px; font-weight: 700; margin-bottom: 15px; text-transform: uppercase;">
                                    Verification Update
                                </div>
                                <h2 style="font-size: 20px; color: #002060; font-weight: 700; margin-bottom: 12px; line-height: 1.3;">
                                    Update on Your Student Research Application
                                </h2>
                                <p style="margin-bottom: 15px; color: #526484; font-size: 14.5px;">
                                    Dear <strong>{{ $student->name }}</strong>,
                                </p>
                                <p style="margin-bottom: 20px; color: #526484; font-size: 14px;">
                                    Thank you for your interest in the complimentary Student Research Grant on the Financial Markets Regulations &amp; Rules Repository Portal.
                                </p>
                                <p style="margin-bottom: 20px; color: #526484; font-size: 14px;">
                                    After thorough review by our compliance team, we are unable to approve your application at this time based on the documentation provided:
                                </p>

                                <!-- Reason Box -->
                                <div class="reason-box">
                                    <strong style="display: block; margin-bottom: 6px; color: #7f1d1d;">Reason Provided by Compliance:</strong>
                                    {{ $reason }}
                                </div>

                                <div style="background: #f8f9fc; border: 1px solid #e5e9f2; border-radius: 6px; padding: 18px 20px; margin: 25px 0;">
                                    <h4 style="margin: 0 0 8px; font-size: 14px; color: #1c2b46; font-weight: 700;">
                                        How to Re-apply:
                                    </h4>
                                    <p style="margin: 0; color: #526484; font-size: 13.5px; line-height: 1.6;">
                                        You are welcome to submit a new application with updated or clearer documentation. Please ensure that your document clearly shows your full name, student ID number, current semester / academic session, and institution letterhead.
                                    </p>
                                </div>

                                <div style="text-align: center; margin: 30px 0 20px;">
                                    <a href="{{ $reapplyUrl }}" class="btn-reapply">
                                        Submit New Application &rarr;
                                    </a>
                                </div>

                                <p style="margin-top: 25px; color: #526484; font-size: 14px;">
                                    Best regards,<br>
                                    <strong>FMDQ Compliance &amp; Portal Administration</strong>
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
