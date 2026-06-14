<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - {{ $order->invoiceID }}</title>
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
            max-width: 650px;
            border-spacing: 0;
            color: #4a4a4a;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .header {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            padding: 35px 30px;
            color: #ffffff;
        }

        .header-title {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .header-subtitle {
            font-size: 14px;
            color: #94a3b8;
            margin: 5px 0 0 0;
        }

        .content {
            padding: 40px 30px;
            background-color: #ffffff;
        }

        .greeting {
            color: #1f2937;
            font-size: 20px;
            font-weight: 600;
            margin: 0 0 10px 0;
        }

        .intro-text {
            font-size: 15px;
            line-height: 1.6;
            color: #4b5563;
            margin: 0 0 30px 0;
        }

        /* Grid System for Tables */
        .meta-table {
            width: 100%;
            margin-bottom: 30px;
        }

        .meta-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            vertical-align: top;
            width: 48%;
        }

        .card-title {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            margin: 0 0 10px 0;
            letter-spacing: 0.5px;
        }

        .card-text {
            font-size: 14px;
            line-height: 1.5;
            color: #334155;
            margin: 0;
        }

        /* Product Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table th {
            background-color: #f1f5f9;
            color: #475569;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 12px 10px;
            text-align: left;
            border-bottom: 2px solid #cbd5e1;
        }

        .items-table td {
            padding: 15px 10px;
            font-size: 14px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
        }

        .product-meta {
            font-size: 12px;
            color: #64748b;
            margin-top: 4px;
        }

        /* Pricing Summary */
        .summary-table {
            width: 280px;
            float: right;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .summary-table td {
            padding: 6px 10px;
            font-size: 14px;
            color: #475569;
        }

        .summary-label {
            text-align: right;
        }

        .summary-value {
            text-align: right;
            font-weight: 600;
            color: #1e293b;
        }

        .total-row td {
            padding-top: 12px;
            border-top: 2px solid #e2e8f0;
            font-size: 16px;
            font-weight: 700;
            color: #0f172a !important;
        }

        .total-value {
            color: #4f46e5 !important;
            font-size: 18px;
        }

        .clear {
            clear: both;
        }

        .footer {
            background-color: #f8fafc;
            padding: 25px 20px;
            text-align: center;
            font-size: 13px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>

<body>

    <center class="wrapper">
        <table class="main-table">
            <tr>
                <td class="header">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <h1 class="header-title">{{ config('app.name') }}</h1>
                                <p class="header-subtitle">Thank you for your purchase!</p>
                            </td>
                            <td align="right" style="vertical-align: middle;">
                                <span
                                    style="background-color: #4f46e5; color: #ffffff; padding: 8px 15px; font-size: 13px; font-weight: 700; border-radius: 4px; text-transform: uppercase;">
                                    Confirmed
                                </span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td class="content">
                    <p class="greeting">Hello {{ $customer->name }},</p>
                    <p class="intro-text">
                        Your order has been successfully received and is now being processed. Below you will find the
                        complete breakdown of your invoice details and purchased items.
                    </p>

                    <table class="meta-table" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="meta-card">
                                <p class="card-title">Order Info</p>
                                <p class="card-text">
                                    <strong>Invoice ID:</strong> #{{ $order->invoiceID }}<br>
                                    <strong>Date:</strong>
                                    {{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y h:i A') }}<br>
                                    <strong>Payment:</strong>
                                    {{ $order->payment_method ?? strtoupper($order->payment) }}
                                </p>
                            </td>
                            <td width="4%">&nbsp;</td>
                            <td class="meta-card">
                                <p class="card-title">Shipping Address</p>
                                <p class="card-text">
                                    <strong>{{ $customer->name }}</strong><br>
                                    {{ $customer->address }}<br>
                                    Phone: {{ $customer->phone }}
                                </p>
                            </td>
                        </tr>
                    </table>

                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Item Details</th>
                                <th style="text-align: center; width: 60px;">Qty</th>
                                <th style="text-align: right; width: 100px;">Price</th>
                                <th style="text-align: right; width: 100px;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderProducts as $product)
                                <tr>
                                    <td>
                                        <div style="font-weight: 600; color: #1e293b;">{{ $product->product_name }}
                                        </div>
                                        <div class="product-meta">
                                            SKU: {{ $product->product_SKU }}
                                            @if ($product->variant)
                                                | Variant: {{ $product->variant }}
                                            @endif
                                            @if ($product->color)
                                                | Color: {{ $product->color }}
                                            @endif
                                        </div>
                                    </td>
                                    <td align="center">{{ $product->quantity }}</td>
                                    <td align="right">€{{ number_format($product->product_price, 2) }}</td>
                                    <td align="right">
                                        <strong>€{{ number_format($product->product_price * $product->quantity, 2) }}</strong>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <table class="summary-table" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="summary-label">Subtotal:</td>
                            <td class="summary-value">€{{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="summary-label">Delivery Charge:</td>
                            <td class="summary-value">+€{{ number_format($order->delivery_charge, 2) }}</td>
                        </tr>
                        @if ($order->vat > 0)
                            <tr>
                                <td class="summary-label">VAT ({{ $order->vat_percentage }}%):</td>
                                <td class="summary-value">+€{{ number_format($order->vat, 2) }}</td>
                            </tr>
                        @endif
                        @if ($order->tax > 0)
                            <tr>
                                <td class="summary-label">Tax ({{ $order->tax_percentage }}%):</td>
                                <td class="summary-value">+€{{ number_format($order->tax, 2) }}</td>
                            </tr>
                        @endif
                        @if ($order->coupon_discount > 0)
                            <tr>
                                <td class="summary-label" style="color: #10b981;">Discount ({{ $order->coupon_name }}):
                                </td>
                                <td class="summary-value" style="color: #10b981;">
                                    -€{{ number_format($order->coupon_discount, 2) }}</td>
                            </tr>
                        @endif

                        @if ($order->points_amount > 0)
                            <tr>
                                <td class="summary-label" style="color: #10b981;">Points Redeem:</td>
                                <td class="summary-value" style="color: #10b981;">
                                    -€{{ number_format($order->points_amount, 2) }}</td>
                            </tr>
                        @endif

                        {{-- Total Row --}}
                        <tr class="total-row">
                            <td class="summary-label">Grand Total:</td>
                            <td class="summary-value total-value">€{{ number_format($order->total, 2) }}</td>
                        </tr>
                    </table>

                    <div class="clear"></div>

                    @if ($order->customer_note)
                        <div
                            style="background-color: #fff7ed; border-left: 4px solid #ea580c; padding: 15px; margin-top: 20px; border-radius: 4px;">
                            <p
                                style="margin: 0; font-size: 13px; font-weight: 700; color: #c2410c; text-transform: uppercase;">
                                Your Note:</p>
                            <p style="margin: 5px 0 0 0; font-size: 14px; color: #9a3412; font-style: italic;">
                                "{{ $order->customer_note }}"</p>
                        </div>
                    @endif

                    @if ($order->reward_point > 0)
                        <p style="font-size: 14px; color: #4f46e5; font-weight: 600; margin-top: 20px;">
                            🎉 Congratulations! You have earned <strong>{{ $order->reward_point }}</strong> reward
                            points from this order.
                        </p>
                    @endif

                    <p style="margin-top: 40px; margin-bottom: 0; font-size: 15px; color: #1f2937;">
                        Best regards,<br>
                        <strong>The {{ config('app.name') }} Team</strong>
                    </p>
                </td>
            </tr>

            <tr>
                <td class="footer">
                    <p style="margin: 0 0 8px 0;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights
                        reserved.</p>
                    <p style="margin: 0;">If you have any questions or queries regarding this invoice, please reach out
                        to our helpdesk.</p>
                </td>
            </tr>
        </table>
    </center>

</body>

</html>
