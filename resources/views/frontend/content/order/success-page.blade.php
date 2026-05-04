@extends('frontend.master')

@section('meta')


@endsection

@section('maincontent')


<div class="text-center">
    <div class="container py-5">
        <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="border-0 card rounded-4">
            <div class="p-5 card-body" style="    font-weight: bold;">

                <!-- Success Icon -->
                <div class="mb-2 text-center">
                    <div class="mb-2 success-icon" style="text-align: -webkit-center;">
                        <img src="{{asset('public/success.png')}}" alt="" style="width:70px;">
                    </div>
                    <h2 class="fw-bold text-dark">Thank You!</h2>
                    <p class="text-dark">Your order has been placed successfully.</p>
                </div>

                <!-- Order Summary -->
                <h5 class="mb-1 text-left fw-semibold" style="text-transform: uppercase">Order Summary</h5>
                <div class="p-3 mb-2 border bg-light rounded-3">
                <div class="mb-0 d-flex justify-content-between">
                    <span class="text-dark">Order ID:</span>
                    <span class="fw-medium">{{$order->invoiceID}}</span>
                </div>
                <div class="mb-0 d-flex justify-content-between">
                    <span class="text-dark">Date:</span>
                    <span class="fw-medium">{{$order->order_date->format('Y-m-d')}}</span>
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
                            <div class="col-12 mb-2">
                                <div class="d-flex align-items-center">
                                    <img style="width: 60px;border-radiu:4px;" src="{{App\Models\Product::where('id',$orderproduct->product_id)->first()->thumbnail_img}}" class="rounded me-3" alt="Product">
                                    <div class="text-left ps-3 mx-4">
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
    </div>

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</div>


@endsection
