<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Happy Birthday!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .email-wrapper {
            width: 100%;
            background-color: #f9f9f9;
            padding: 20px 0;
        }
        .email-content {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #FF6F61;
            color: #ffffff;
            text-align: center;
            padding: 30px 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .body {
            padding: 30px 20px;
            color: #333333;
            line-height: 1.6;
            text-align: center;
        }
        .body h2 {
            color: #FF6F61;
            margin-bottom: 10px;
        }
        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777777;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            margin-top: 20px;
            background-color: #FF6F61;
            color: #ffffff;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="email-wrapper">
    <div class="email-content">
        <div class="header">
            <h1>Happy Birthday, {{ $user->name ?? 'default' }}!</h1>
        </div>
        <div class="body">
            <h2>🎉 Celebrate Your Special Day! 🎉</h2>
            <p>We at <strong>{{ config('app.name') }}</strong> wish you a wonderful birthday filled with happiness and joy.</p>
            <p>To make your day extra special, enjoy a little surprise from us!</p>
            <a href="{{ url('/') }}" class="button">Visit Our Website</a>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>If you didn't expect this email, you can safely ignore it.</p>
        </div>
    </div>
</div>
</body>
</html>
