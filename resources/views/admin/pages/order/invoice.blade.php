<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice Print</title>
    <style>
        :root {
            --ink: #1f2937;
            --muted: #6b7280;
            --line: #e5e7eb;
            --soft: #f9fafb;
            --accent: #0f766e;
            --paper: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: var(--ink);
            background: #eef0f2;
            font-size: 14px;
            line-height: 1.5;
        }

        .invoice-page {
            max-width: 800px;
            margin: 30px auto;
            background: var(--paper);
            padding: 48px;
            border: 1px solid var(--line);
        }

        /* Header */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 14px;
            border-bottom: 2px solid var(--ink);
        }

        .company-info h1 {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .company-info p {
            font-size: 12.5px;
            color: var(--muted);
            line-height: 1.6;
        }

        .company-logo img {
            width: 90px;
            height: 90px;
            object-fit: contain;
            display: block;
            border: 1px solid var(--line);
            background: var(--soft);
        }

        /* Invoice meta */
        .invoice-meta {
            display: flex;
            justify-content: space-between;
            margin-top: 14px;
            gap: 32px;
        }

        .invoice-title {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 2px;
            color: var(--accent);
            text-transform: uppercase;
            text-align: center;
        }

        .meta-table {
            font-size: 13px;
        }

        .meta-table .row {
            display: flex;
            justify-content: space-between;
            gap: 24px;
            padding: 3px 0;
        }

        .meta-table .label {
            color: var(--muted);
        }

        .meta-table .value {
            font-weight: 600;
            text-align: right;
        }

        /* Bill to */
        .billing-section {
            display: flex;
            justify-content: space-between;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--line);
            gap: 32px;
        }

        .billing-block h3 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--muted);
            margin-bottom: 8px;
            font-weight: 600;
        }

        .billing-block p {
            font-size: 13.5px;
            line-height: 1.6;
        }

        .billing-block .name {
            font-weight: 700;
            font-size: 15px;
            margin-bottom: 2px;
        }

        .note-block {
            max-width: 280px;
        }

        .note-block p {
            font-size: 12.5px;
            color: var(--muted);
            font-style: italic;
        }

        /* Items table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 32px;
        }

        .items-table thead th {
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--paper);
            background: var(--ink);
            padding: 10px 12px;
            font-weight: 600;
        }

        .items-table thead th:last-child,
        .items-table tbody td:last-child,
        .items-table thead th.num,
        .items-table tbody td.num {
            text-align: right;
        }

        .items-table tbody td {
            padding: 14px 12px;
            border-bottom: 1px solid var(--line);
            font-size: 13.5px;
            vertical-align: top;
        }

        .items-table tbody tr:nth-child(even) {
            background: var(--soft);
        }

        .product-name {
            font-weight: 600;
        }

        .product-meta {
            font-size: 11.5px;
            color: var(--muted);
            margin-top: 2px;
        }

        /* Totals */
        .totals-wrap {
            display: flex;
            justify-content: space-between;
            margin-top: 24px;
        }

        .totals-table {
            width: 320px;
            font-size: 13.5px;
        }

        .totals-table .row {
            display: flex;
            justify-content: space-between;
            padding: 7px 0;
            border-bottom: 1px solid var(--line);
        }

        .totals-table .row.discount .value {
            color: #b91c1c;
        }

        .totals-table .row.grand-total {
            border-bottom: none;
            border-top: 2px solid var(--ink);
            margin-top: 6px;
            padding-top: 12px;
            font-size: 17px;
            font-weight: 700;
        }

        .totals-table .row.grand-total .value {
            color: var(--accent);
        }

        .totals-table .label {
            color: var(--muted);
        }

        .totals-table .value {
            font-weight: 600;
        }

        /* Footer */
        .invoice-footer {
            margin-top: 48px;
            padding-top: 20px;
            border-top: 1px solid var(--line);
            text-align: center;
        }

        .invoice-footer p {
            font-size: 12px;
            color: var(--muted);
        }

        .invoice-footer .thanks {
            font-size: 14px;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 6px;
        }

        @media print {
            body {
                background: var(--paper);
            }

            .invoice-page {
                margin: 0;
                border: none;
                padding: 24px;
            }

            .page-break {
                page-break-after: always;
            }
        }

        @media (max-width: 600px) {
            .invoice-page {
                padding: 20px;
            }

            .invoice-header,
            .invoice-meta,
            .billing-section,
            .totals-wrap {
                flex-direction: column;
                gap: 16px;
            }

            .invoice-meta .meta-table .row,
            .invoice-meta {
                text-align: left;
            }

            .totals-table {
                width: 100%;
            }

            .items-table {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>
    @foreach ($orders as $order)
        @php
            $customer = $order->customer;
            $products = $order->orderProducts;
            $status = App\Models\OrderStatus::where('id', $order->order_status_id)->first();
        @endphp

        <div class="invoice-page @if (!$loop->last) page-break @endif">

            <div class="invoice-title">Invoice</div>
            {{-- Header --}}
            <div class="invoice-header">
                <div class="company-info">
                    <h1>{{ $basicInfo->site_name ?? '' }}</h1>
                    <p>
                        {{ $basicInfo->address ?? '' }}<br>
                        Phone: {{ $basicInfo->phone_1 ?? '' }} &nbsp;|&nbsp; Email: {{ $basicInfo->mail ?? '' }}<br>
                        Website: {{ $basicInfo->website_url ?? '' }}
                    </p>
                </div>
                <div class="company-logo">
                    <img src="{{ asset($basicInfo->dark_logo) ?? '' }}" alt="Company Logo">
                </div>
            </div>

            {{-- Invoice meta --}}
            <div class="invoice-meta">

                <div class="meta-table">
                    <div class="row">
                        <span class="label">Invoice No:</span>
                        <span class="value">{{ $order->invoiceID }}</span>
                    </div>
                    <div class="row">
                        <span class="label">Order Date:</span>
                        <span class="value">{{ \Carbon\Carbon::parse($order->order_date)->format('d M, Y') }}</span>
                    </div>
                    <div class="row">
                        <span class="label">Payment Method:</span>
                        <span class="value">{{ $order->payment_method ?? 'N/A' }}</span>
                    </div>
                    <div class="row">
                        <span class="label">Status:</span>
                        <span class="value">{{ $status->status_name }}</span>
                    </div>
                </div>
                <div class="billing-block">
                    <h3>Bill To</h3>
                    <p class="name">{{ $customer->name ?? 'N/A' }}</p>
                    <p>
                        {{ $customer->address ?? '' }}<br>
                        Phone: {{ $customer->phone ?? '' }}<br>
                        Email: {{ $customer->email ?? '' }}
                    </p>
                </div>
            </div>


            {{-- Items --}}
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="num">Price</th>
                        <th class="num">Qty</th>
                        <th class="num">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $item)
                        <tr>
                            <td>
                                <div class="product-name">{{ $item->product_name }}</div>
                                <div class="product-meta">
                                    SKU: {{ $item->product_SKU }}
                                    @if ($item->color && $item->color != 'No Variant')
                                        | Color: {{ $item->color }}
                                    @endif
                                    @if ($item->variant && $item->variant != 'No Variant')
                                        | Variant: {{ $item->variant }}
                                    @endif
                                </div>
                            </td>
                            <td class="num">€{{ number_format($item->product_price, 2) }}</td>
                            <td class="num">{{ $item->quantity }}</td>
                            <td class="num">€{{ number_format($item->product_price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Totals --}}
            <div class="totals-wrap">
                @if ($order->customer_note)
                    <div class="billing-block note-block">
                        <h3>Customer Note</h3>
                        <p>"{{ $order->customer_note }}"</p>
                    </div>
                @endif
                <div class="totals-table">
                    <div class="row">
                        <span class="label">Subtotal</span>
                        <span class="value">€{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="row">
                        <span class="label">VAT ({{ $order->vat_percentage }}%)</span>
                        <span class="value">€{{ number_format($order->vat, 2) }}</span>
                    </div>
                    <div class="row">
                        <span class="label">Tax ({{ $order->tax_percentage }}%)</span>
                        <span class="value">€{{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="row">
                        <span class="label">Delivery Charge</span>
                        <span class="value">€{{ number_format($order->delivery_charge, 2) }}</span>
                    </div>
                    @if ($order->coupon_discount > 0)
                        <div class="row discount">
                            <span class="label">Coupon ({{ $order->coupon_name }} -
                                {{ $order->coupon_amount }}{{ $order->coupon_type == 'percentage' ? '%' : '€' }})</span>
                            <span class="value">-€{{ number_format($order->coupon_discount, 2) }}</span>
                        </div>
                    @endif
                    @if ($order->points_amount > 0)
                        <div class="row discount">
                            <span class="label">Points ({{ $order->points_used }})</span>
                            <span class="value">-€{{ number_format($order->points_amount, 2) }}</span>
                        </div>
                    @endif

                    <div class="row grand-total">
                        <span class="label">Total</span>
                        <span class="value">€{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="invoice-footer">
                <p class="thanks">Thank you for your order!</p>
                {{-- <p>This is a computer-generated invoice and does not require a signature.</p>
            <p>For any queries, contact us at info@yourcompany.com or +880 1XXX-XXXXXX</p> --}}
            </div>

        </div>
    @endforeach
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
