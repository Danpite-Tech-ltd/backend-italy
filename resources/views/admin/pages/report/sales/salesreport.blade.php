@extends('admin.layout.app')



@section('content')

<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: #1a1a2e;">
                <i class="fas fa-chart-line me-2" style="color: #4f46e5;"></i> Sales Report
            </h2>
            <small class="text-muted">Track your sales, purchases and profit</small>
        </div>
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-print me-1"></i> Print
        </button>
    </div>

    {{-- Date Filter Card --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-body">
            <form method="GET" action="{{ url()->current() }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-muted small text-uppercase tracking-wide">
                            Start Date
                        </label>
                        <input
                            type="date"
                            name="start_date"
                            class="form-control"
                            value="{{ request('start_date') }}"
                            style="border-radius: 8px;"
                        >
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-muted small text-uppercase tracking-wide">
                            End Date
                        </label>
                        <input
                            type="date"
                            name="end_date"
                            class="form-control"
                            value="{{ request('end_date') }}"
                            style="border-radius: 8px;"
                        >
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100" style="border-radius: 8px; background: #4f46e5; border-color: #4f46e5;">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            <a href="{{ url()->current() }}" class="btn btn-outline-secondary w-100" style="border-radius: 8px;">
                                <i class="fas fa-redo me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>

                @if(request('start_date') || request('end_date'))
                <div class="mt-3">
                    <span class="badge" style="background: #eef2ff; color: #4f46e5; font-size: 0.8rem; padding: 6px 12px; border-radius: 6px;">
                        <i class="fas fa-calendar-alt me-1"></i>
                        Showing results
                        @if(request('start_date')) from <strong>{{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }}</strong> @endif
                        @if(request('end_date')) to <strong>{{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}</strong> @endif
                    </span>
                </div>
                @endif
            </form>
        </div>
    </div>

    {{-- Sales Table Card --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <h5 class="fw-semibold mb-0" style="color: #1a1a2e;">
                Order Details
                <span class="badge ms-2" style="background: #eef2ff; color: #4f46e5; font-size: 0.75rem;">
                    {{ $orderProducts->count() }} records
                </span>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: #f8f9ff;">
                        <tr>
                            <th class="ps-4 py-3 text-muted small fw-semibold text-uppercase">#</th>
                            <th class="py-3 text-muted small fw-semibold text-uppercase">Product Name</th>
                            <th class="py-3 text-muted small fw-semibold text-uppercase">Code</th>
                            <th class="py-3 text-muted small fw-semibold text-uppercase">Purchase Price</th>
                            <th class="py-3 text-muted small fw-semibold text-uppercase">Sale Price</th>
                            <th class="py-3 text-muted small fw-semibold text-uppercase">Qty</th>
                            <th class="py-3 pe-4 text-muted small fw-semibold text-uppercase text-end">Total Sale</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orderProducts as $orderProduct)
                            @php
                                $purchase = \App\Models\PurchaseProduct::where('product_id', $orderProduct->product_id)
                                    ->latest()
                                    ->first();
                                $purchasePrice = $purchase ? $purchase->product_price : 0;
                                $rowTotal = $orderProduct->quantity * $orderProduct->product_price;
                            @endphp
                            <tr>
                                <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                                <td class="fw-semibold" style="color: #1a1a2e;">{{ $orderProduct->product_name }}</td>
                                <td>
                                    <span class="badge" style="background: #f1f5f9; color: #475569; font-size: 0.78rem;">
                                        {{ $orderProduct->product_SKU ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="text-danger">৳ {{ number_format($purchasePrice, 2) }}</td>
                                <td class="text-success">৳ {{ number_format($orderProduct->product_price, 2) }}</td>
                                <td>
                                    <span class="badge bg-light text-white">{{ $orderProduct->quantity }}</span>
                                </td>
                                <td class="pe-4 text-end fw-semibold" style="color: #1a1a2e;">
                                    ৳ {{ number_format($rowTotal, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block" style="color: #cbd5e1;"></i>
                                    No records found for the selected period.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Profit Summary Cards --}}
    <div class="row g-3 mb-2">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #10b981 !important;">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width: 52px; height: 52px; background: #ecfdf5;">
                        <i class="fas fa-arrow-up" style="color: #10b981; font-size: 1.2rem;"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-muted small fw-semibold text-uppercase">Total Sale</p>
                        <h4 class="fw-bold mb-0" style="color: #10b981;">৳ {{ number_format($totalSale, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #ef4444 !important;">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width: 52px; height: 52px; background: #fef2f2;">
                        <i class="fas fa-arrow-down" style="color: #ef4444; font-size: 1.2rem;"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-muted small fw-semibold text-uppercase">Total Purchase Cost</p>
                        <h4 class="fw-bold mb-0" style="color: #ef4444;">৳ {{ number_format($totalPurchase, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid {{ $totalProfit >= 0 ? '#4f46e5' : '#f97316' }} !important;">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width: 52px; height: 52px; background: {{ $totalProfit >= 0 ? '#eef2ff' : '#fff7ed' }};">
                        <i class="fas fa-{{ $totalProfit >= 0 ? 'chart-line' : 'exclamation-triangle' }}"
                           style="color: {{ $totalProfit >= 0 ? '#4f46e5' : '#f97316' }}; font-size: 1.2rem;"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-muted small fw-semibold text-uppercase">Net Profit</p>
                        <h4 class="fw-bold mb-0" style="color: {{ $totalProfit >= 0 ? '#4f46e5' : '#f97316' }};">
                            ৳ {{ number_format(abs($totalProfit), 2) }}
                            @if($totalProfit < 0) <small class="fs-6">(Loss)</small> @endif
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
