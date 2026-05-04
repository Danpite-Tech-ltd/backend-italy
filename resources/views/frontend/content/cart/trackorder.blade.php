@extends('frontend.master')

@section('maincontent')
    @section('meta')
    @endsection

    <style>
        .table td {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
    </style>
    <main class="main">
        <nav aria-label="breadcrumb" class="mb-2 breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('/shop-by-category')}}">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Track Order</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content" id="loadlist">
            <div class="cart">
                <div class="container">
                    <div class="row">
                        <div class="m-auto col-lg-8">
                            <form action="{{url('track-order')}}" method="GET">
                                <div class="form-group">
                                    <label for="">Invoice ID</label>
                                    <input type="text" placeholder="Enter Invoice ID" name="invoice_id" id="invoice_id" class="form-control">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </form>
                        </div><!-- End .col-lg-9 -->
                    </div><!-- End .row -->
                    @if($order)
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="border-0 card rounded-4">
                                <div class="p-5 card-body" style="    font-weight: bold;">

                                    <!-- Order Summary -->
                                    <h5 class="mb-1 text-left fw-semibold" style="text-transform: uppercase">Order Summary</h5>
                                    <div class="p-3 mb-2 border bg-light rounded-3">
                                    <div class="mb-0 d-flex justify-content-between">
                                        <span class="text-dark">Order ID:</span>
                                        <span class="fw-medium">{{$order->invoiceID}}</span>
                                    </div>
                                    <div class="mb-0 d-flex justify-content-between">
                                        <span class="text-dark">Date:</span>
                                        <span class="fw-medium">{{$order->order_date}}</span>
                                    </div>
                                    <div class="mb-0 d-flex justify-content-between">
                                        <span class="text-dark">Payment Method:</span>
                                        <span class="fw-medium" style="text-transform: uppercase">{{$order->payment_method}}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-dark">Total Amount:</span>
                                        <span class="fw-bold text-success">{{$order->total}} TK</span>
                                    </div>
                                    </div>

                                    <!-- Ordered Items -->
                                    <h5 class="mb-1 text-left fw-semibold">Your Items</h5>
                                    <div class="p-2 mb-2 border ordered-item d-flex justify-content-between align-items-center rounded-3 bg-light">
                                        <div class="row">
                                            @php
                                                $orderproducts=App\Models\OrderProduct::where('order_id',$order->id)->get();
                                                $customer=App\Models\Customer::where('id',$order->customer_id)->first();
                                            @endphp
                                            @forelse($orderproducts as $orderproduct)
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center">
                                                        <img style="width: 60px;border-radiu:4px;" src="{{App\Models\Product::where('id',$orderproduct->product_id)->first()->thumbnail_img}}" class="rounded me-3" alt="Product">
                                                        <div class="text-left ps-3">
                                                            <h6 class="mb-0">{{$orderproduct->product_name}}</h6>
                                                            <span class="fw-medium">{{$orderproduct->quantity}} x {{$orderproduct->product_price}} TK</span>
                                                        </div>
                                                    </div>

                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>

                                    <!-- Delivery Info -->
                                    <h5 class="mb-1 text-left fw-semibold">Delivery Address</h5>
                                    <div class="p-3 mb-4 text-left border bg-light rounded-3">
                                        <p class="mb-0 text-dark"><b>Name: {{$customer->name}}</b></p>
                                        <p class="mb-0 text-dark"><b>Address: {{$customer->address}}</b></p>
                                        <p class="mb-0 text-dark"><b>Phone: {{$customer->phone}}</b></p>
                                    </div>

                                    <!-- CTA Buttons -->
                                    <div class="gap-3 d-flex justify-content-center">
                                    <a href="{{url('/')}}" class="px-4 btn btn-outline-secondary">Continue Shopping</a>
                                    </div>

                                </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div><!-- End .container -->
            </div><!-- End .cart -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->

@endsection