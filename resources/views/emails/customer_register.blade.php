<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ config('app.name') }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f4f6f8;
            padding-bottom: 40px;
            padding-top: 40px;
        }
        .main-table {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-spacing: 0;
            font-family: sans-serif;
            color: #4a4a4a;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        .header {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            padding: 40px 20px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .content {
            padding: 40px 30px;
            background-color: #ffffff;
        }
        .content h2 {
            color: #1f2937;
            font-size: 22px;
            margin-top: 0;
            margin-bottom: 15px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.6;
            color: #4b5563;
            margin-bottom: 25px;
        }
        .info-box {
            background-color: #f9fafb;
            border-left: 4px solid #4f46e5;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 0 6px 6px 0;
        }
        .info-box table {
            width: 100%;
        }
        .info-box td {
            padding: 5px 0;
            font-size: 15px;
        }
        .info-label {
            font-weight: 600;
            color: #374151;
            width: 120px;
        }
        .info-value {
            color: #6b7280;
        }
        .btn-container {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 20px;
        }
        .btn {
            background-color: #4f46e5;
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 6px;
            display: inline-block;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }
        .footer {
            background-color: #f9fafb;
            padding: 25px 20px;
            text-align: center;
            font-size: 13px;
            color: #9ca3af;
            border-top: 1px solid #f3f4f6;
        }
        .footer a {
            color: #4f46e5;
            text-decoration: none;
        }
    </style>
</head>
<body>

<center class="wrapper">
    <table class="main-table">
        <tr>
            <td class="header">
                <h1>{{ config('app.name') }}</h1>
            </td>
        </tr>

        <tr>
            <td class="content">
                <h2>Welcome aboard, {{ $user->name }}!</h2>
                <p>Thank you for creating an account with us. We are absolutely thrilled to have you in our community. Your account is now fully active and ready to go.</p>

                <div class="info-box">
                    <table>
                        <tr>
                            <td class="info-label">Account Name:</td>
                            <td class="info-value">{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Phone Number:</td>
                            <td class="info-value">{{ $user->phone }}</td>
                        </tr>
                        @if($user->email)
                        <tr>
                            <td class="info-label">Email Address:</td>
                            <td class="info-value">{{ $user->email }}</td>
                        </tr>
                        @endif
                    </table>
                </div>

                <p>To get started and explore your dashboard, please click the button below:</p>

                <div class="btn-container">
                    <a href="{{ url('/') }}" class="btn" target="_blank">Go to Dashboard</a>
                </div>

                <p style="margin-top: 30px; margin-bottom: 0;">Best regards,<br><strong>The {{ config('app.name') }} Team</strong></p>
            </td>
        </tr>

        <tr>
            <td class="footer">
                <p style="margin: 0 0 10px 0;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                <p style="margin: 0;">You received this email because you registered on our platform. If this wasn't you, please disregard this email.</p>
            </td>
        </tr>
    </table>
</center>

</body>
</html>
