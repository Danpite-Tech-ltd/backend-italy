<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Update</title>
    @php
        $status = strtolower(trim($order_status));

        $themeColor = '#64748b';
        $bgColor = '#f8fafc';

        // 1. Pending / Processing Statuses
        if (str_contains($status, 'pending') || str_contains($status, 'processing')) {
            $themeColor = '#3b82f6'; // Bright Blue
            $bgColor = '#eff6ff';
        }
        // 2. Shipping / Courier Statuses
        elseif (str_contains($status, 'shipped') || str_contains($status, 'in courier')) {
            $themeColor = '#f59e0b'; // Amber / Orange
            $bgColor = '#fef3c7';
        }
        // 3. Delivered Status
        elseif (str_contains($status, 'delivered')) {
            $themeColor = '#10b981'; // Vibrant Green
            $bgColor = '#ecfdf5';
        }
        // 4. Cancelled Status
        elseif (str_contains($status, 'cancelled') || str_contains($status, 'cancel')) {
            $themeColor = '#ef4444'; // Red
            $bgColor = '#fef2f2';
        }
        // 5. Returned / Refund Statuses
        elseif (str_contains($status, 'returned') || str_contains($status, 'refund')) {
            $themeColor = '#a855f7'; // Premium Purple
            $bgColor = '#faf5ff';
        }
    @endphp
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
            padding: 40px 0;
        }
        .main-table {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-spacing: 0;
            color: #4a4a4a;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: {{ $themeColor }};
            padding: 35px 20px;
            text-align: center;
            color: #ffffff;
            transition: background-color 0.3s ease;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .content {
            padding: 40px 30px;
            background-color: #ffffff;
        }
        .greeting {
            color: #1f2937;
            font-size: 20px;
            font-weight: 600;
            margin: 0 0 15px 0;
        }
        .status-badge {
            display: inline-block;
            background-color: {{ $bgColor }};
            color: {{ $themeColor }};
            font-weight: 700;
            font-size: 15px;
            padding: 10px 24px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 20px 0 25px 0;
            border: 1px solid {{ $themeColor }}33;
        }
        .btn-container {
            text-align: center;
            margin: 30px 0;
        }
        .btn {
            background-color: {{ $themeColor }};
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 32px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 8px;
            display: inline-block;
            transition: opacity 0.2s ease;
        }
        .footer {
            background-color: #f9fafb;
            padding: 25px 20px;
            text-align: center;
            font-size: 13px;
            color: #9ca3af;
            border-top: 1px solid #f3f4f6;
        }
    </style>
</head>
<body>

<center class="wrapper">
    <table class="main-table">
        <tr>
            <td class="header">
                <h1>Order Status Update</h1>
            </td>
        </tr>

        <tr>
            <td class="content">
                <p class="greeting">Hello {{ $customer->name }},</p>
                <p style="font-size: 16px; line-height: 1.6; color: #4b5563; margin: 0;">
                    We are writing to inform you that there has been an update regarding your recent order status. Our team is processing everything meticulously to deliver the best experience.
                </p>

                <div style="text-align: center;">
                    <span class="status-badge">
                        Current Status: {{ $order_status }}
                    </span>
                </div>

                <p style="font-size: 16px; line-height: 1.6; color: #4b5563; margin-bottom: 25px;">
                    You can easily keep track of your parcel timeline, live updates, or invoices inside your personal account area.
                </p>

                <p style="font-size: 15px; color: #6b7280; margin-top: 30px; margin-bottom: 0;">
                    Have questions or spotted an issue? Just hit reply to this email, our friendly customer service desk is always happy to assist.
                </p>

                <p style="margin-top: 25px; margin-bottom: 0; font-size: 15px; color: #1f2937;">
                    Best regards,<br>
                    <strong>The {{ config('app.name') }} Team</strong>
                </p>
            </td>
        </tr>

        <tr>
            <td class="footer">
                <p style="margin: 0 0 8px 0;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                <p style="margin: 0;">This is a system-generated transactional alert regarding your security & orders.</p>
            </td>
        </tr>
    </table>
</center>

</body>
</html>
