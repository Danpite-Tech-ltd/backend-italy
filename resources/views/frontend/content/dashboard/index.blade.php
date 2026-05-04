@extends('frontend.content.dashboard.layout.app')

@push('css')

<style>
    a{
        text-decoration: none;
        font-weight: 600;
    }
</style>
@endpush


@section('content')
@php
$user = Auth::user();
@endphp
    <div class="main-content">
        <!-- Main Content Area -->
        <div class="p-4">
            <!-- Stats Cards -->
            @role('user')
            <div class="row g-4 mb-4">
                <div class="col-12">
                    <h4>Overall</h4>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-primary me-3">
                                <i class="bi bi-cart"></i>
                            </div>
                            <div>
                                <div class="fs-2 fw-bold text-dark">{{ $totalOrders ?? 0 }}</div>
                                <div class="text-muted">Total Orders</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-success me-3">
                                <span class="fs-3">৳</span>
                            </div>
                            <div>
                                <div class="fs-2 fw-bold text-dark"> {{ $pendingOrders ?? 0 }}</div>
                                <div class="text-muted">Pending Orders</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-warning me-3">
                                <i class="bi bi-heart"></i>
                            </div>
                            <div>
                                <div class="fs-2 fw-bold text-dark">{{ $wish ?? 0 }}</div>
                                <div class="text-muted">Wishlist Items</div>
                            </div>
                        </div>
                    </div>
                </div>
{{--                <div class="col-sm-6 col-xl-3">--}}
{{--                    <div class="stats-card">--}}
{{--                        <div class="d-flex align-items-center">--}}
{{--                            <div class="stats-icon bg-info me-3">--}}
{{--                                <i class="bi bi-people"></i>--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                <div class="fs-2 fw-bold text-dark">1,234</div>--}}
{{--                                <div class="text-muted">Customers</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>

            <div class="row g-4 mb-4">
                <div class="col-12">
                    <h4>Today</h4>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-primary me-3">
                                <i class="bi bi-cart"></i>
                            </div>
                            <div>
                                <div class="fs-2 fw-bold text-dark">{{ $todayTotalOrders ?? 0 }}</div>
                                <div class="text-muted">Total Orders</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-success me-3">
                                <span class="fs-3">৳</span>
                            </div>
                            <div>
                                <div class="fs-2 fw-bold text-dark"> {{ $todayPendingOrders ?? 0 }}</div>
                                <div class="text-muted">Pending Orders</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-warning me-3">
                                <i class="bi bi-heart"></i>
                            </div>
                            <div>
                                <div class="fs-2 fw-bold text-dark">{{ $todayWish ?? 0 }}</div>
                                <div class="text-muted">Wishlist Items</div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--                <div class="col-sm-6 col-xl-3">--}}
                {{--                    <div class="stats-card">--}}
                {{--                        <div class="d-flex align-items-center">--}}
                {{--                            <div class="stats-icon bg-info me-3">--}}
                {{--                                <i class="bi bi-people"></i>--}}
                {{--                            </div>--}}
                {{--                            <div>--}}
                {{--                                <div class="fs-2 fw-bold text-dark">1,234</div>--}}
                {{--                                <div class="text-muted">Customers</div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>
            @endrole


            @role('affiliate')

            <div class="row g-4 mb-4">
                <div class="col-12">
                    <h4>Overall</h4>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <a class="" href="{{ route('pos-order') }}">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-warning me-3">
                                <i class="bi bi-bag-heart"></i>
                            </div>
                            <div>
{{--                                <div class="fs-2 fw-bold text-dark"> {{ $pendingOrders ?? 0 }}</div>--}}
                                <div class="text-muted">POS Order</div>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <a class="" href="{{ route('affiliate-shop') }}">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-secondary me-3">
                                    <i class="bi bi-bag"></i>
                                </div>
                                <div>
                                    <div class="fs-2 fw-bold text-dark">{{ $myShop }}</div>
                                    <div class="text-muted">My Shop</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <a class="" href="{{ route('affiliate-order', ['id'=> $user->id]) }}">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-info me-3">
                                    <i class="bi bi-cart"></i>
                                </div>

                                <div>
                                    <div class="fs-2 fw-bold text-dark"> {{ $totalOrders  }}</div>
                                    <div class="text-muted">Total Orders</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <a class="" href="{{ route('affiliate-order', ['id'=> $user->id, 'status_id'=> '1']) }}">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-primary me-3">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div>
                                    <div class="fs-2 fw-bold text-dark">{{ $totalPendingOrders }}</div>
                                    <div class="text-muted">Pending Orders</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <a class="" href="{{ route('affiliate-order', ['id'=> $user->id, 'status_id'=> '3']) }}">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-primary me-3">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div>
                                    <div class="fs-2 fw-bold text-dark">{{ $totalShippedOrders }}</div>
                                    <div class="text-muted">Shipped Orders</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <a class="" href="{{ route('affiliate-order', ['id'=> $user->id, 'status_id'=> '5']) }}">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-primary me-3">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div>
                                    <div class="fs-2 fw-bold text-dark"> {{ $totalCancelledOrders }}</div>
                                    <div class="text-muted">Canceled Orders</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <a class="" href="{{ route('affiliate-order', ['id'=> $user->id, 'status_id'=> '6']) }}">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-primary me-3">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div>
                                     <div class="fs-2 fw-bold text-dark"> {{ $totalReturnOrders }}</div>
                                    <div class="text-muted">Return Orders</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <a class="" href=" {{ route('affiliate-order', ['id'=> $user->id, 'status_id'=> '4']) }}">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-primary me-3">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div>
                                    <div class="fs-2 fw-bold text-dark">{{ $totalDeliveredOrders }}</div>
                                    <div class="text-muted">Delivered Orders</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <a class="" href="javascript:void(0);">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-primary me-3">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div>
                                    <div class="fs-2 fw-bold text-dark"> {{ $totalSale }}</div>
                                    <div class="text-muted">Total Sales</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <a class="" href="javascript:void(0);">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-success me-3">
                                    <i class="bi bi-coin"></i>
                                </div>
                                <div>
                                    <div class="fs-2 fw-bold text-dark"> {{ $accountBalance }}</div>
                                    <div class="text-muted">Account Balance</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <a class="" href="{{ route('affiliate-withdrawal-history', ['id'=> $user->id]) }}">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-danger me-3">
                                    <i class="bi bi-cart"></i>
                                </div>

                                <div>
                                    <div class="fs-2 fw-bold text-dark">{{ $withdrawalBalance }}</div>
                                    <div class="text-muted">Withdraw Amount</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>


            </div>

            {{--  Today --}}

            <div class="row g-4 mb-4">
                <div class="col-12">
                    <h4>Today</h4>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <a class="" href="javascript:void(0);">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-info me-3">
                                    <i class="bi bi-cart"></i>
                                </div>

                                <div>
                                    <div class="fs-2 fw-bold text-dark"> {{ $todayTotalOrders  }}</div>
                                    <div class="text-muted">Total Orders</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <a class="" href="javascript:void(0);">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-primary me-3">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div>
                                    <div class="fs-2 fw-bold text-dark">{{ $todayPendingOrders }}</div>
                                    <div class="text-muted">Pending Orders</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <a class="" href="javascript:void(0);">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-primary me-3">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div>
                                    <div class="fs-2 fw-bold text-dark">{{ $todayShippedOrders }}</div>
                                    <div class="text-muted">Shipped Orders</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <a class="" href="javascript:void(0);">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-primary me-3">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div>
                                    <div class="fs-2 fw-bold text-dark"> {{ $todayCancelledOrders }}</div>
                                    <div class="text-muted">Canceled Orders</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <a class="" href="javascript:void(0);">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-primary me-3">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div>
                                    <div class="fs-2 fw-bold text-dark"> {{ $todayReturnOrders }}</div>
                                    <div class="text-muted">Return Orders</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <a class="" href="javascript:void(0);">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-primary me-3">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div>
                                    <div class="fs-2 fw-bold text-dark">{{ $todayDeliveredOrders }}</div>
                                    <div class="text-muted">Delivered Orders</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>

            @endrole




            <!-- Recent Activity -->
{{--            <div class="row">--}}
{{--                <div class="col-12">--}}
{{--                    <div class="recent-activity">--}}
{{--                        <h5 class="mb-3">Recent Activity</h5>--}}
{{--                        <div class="activity-item">--}}
{{--                            <div class="d-flex align-items-center">--}}
{{--                                <div class="activity-icon bg-success text-white me-3">--}}
{{--                                    <i class="bi bi-check2"></i>--}}
{{--                                </div>--}}
{{--                                <div class="flex-grow-1">--}}
{{--                                    <div class="fw-medium">Order #12345 completed</div>--}}
{{--                                    <small class="text-muted">2 hours ago</small>--}}
{{--                                </div>--}}
{{--                                <div class="text-success fw-medium">৳ 299.00</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="activity-item">--}}
{{--                            <div class="d-flex align-items-center">--}}
{{--                                <div class="activity-icon bg-primary text-white me-3">--}}
{{--                                    <i class="bi bi-cart-plus"></i>--}}
{{--                                </div>--}}
{{--                                <div class="flex-grow-1">--}}
{{--                                    <div class="fw-medium">New order received</div>--}}
{{--                                    <small class="text-muted">4 hours ago</small>--}}
{{--                                </div>--}}
{{--                                <div class="text-primary fw-medium">৳ 156.50</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="activity-item">--}}
{{--                            <div class="d-flex align-items-center">--}}
{{--                                <div class="activity-icon bg-warning text-white me-3">--}}
{{--                                    <i class="bi bi-heart"></i>--}}
{{--                                </div>--}}
{{--                                <div class="flex-grow-1">--}}
{{--                                    <div class="fw-medium">Item added to wishlist</div>--}}
{{--                                    <small class="text-muted">1 day ago</small>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>

@endsection


@section('js')

@endsection

