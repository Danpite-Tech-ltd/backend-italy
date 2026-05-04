@extends('frontend.master')

@section('maincontent')
    @section('meta')
    @endsection

    <style>
        .checkout textarea.form-control {
            min-height: 60px;
        }
        .table.table-summary tbody td {
            padding: 0;
            height: 50px;
            border-bottom: .1rem solid #ebebeb;
        }
    </style>

    @php
        use Carbon\Carbon;
        $today = Carbon::today();
        $couponCode = Session::get('coupon');

        if ($couponCode) {
            $coupon = App\Models\Coupon::where('expire_date', '>', $today)
                ->where('code', $couponCode) // note: removed extra space
                ->first();
        } else {
            $coupon = null; // better to use null instead of empty array for single record
        }
    @endphp
    <main class="main">

        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('/shop-by-category')}}">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="checkout">
                <div class="container">
                    <div class="checkout-discount">
                        <form action="#">
                            @if(isset($coupon))
                                <input type="text" onchange="setcoupon()" class="form-control" value="{{$coupon?$coupon->code:''}}" required id="checkout-discount-input">

                            @else
                                <input type="text" onchange="setcoupon()" class="form-control" value="{{$coupon?$coupon->code:''}}" required id="checkout-discount-input">
                                <label for="checkout-discount-input" class="text-truncate"> Have any coupon? <span>Click here to enter your code</span></label>
                            @endif
                        </form>
                    </div><!-- End .checkout-discount -->
                    <form action="{{route('buynow-order-place')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-9">
                                <h2 class="checkout-title">Billing Details</h2><!-- End .checkout-title -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label>Name *</label>
                                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', Auth::user()->name ?? '') }}" required>
                                            <div class="m-1">
                                                @error('name')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div><!-- End .col-sm-6 -->
                                        <div class="col-sm-12">
                                            <label>Email (optional)</label>
                                            <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email ?? '') }}" class="form-control">
                                            <div class="m-1">
                                                @error('email')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div><!-- End .col-sm-6 -->
                                        <div class="col-sm-12">
                                            <label>Phone *</label>
                                            <input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone', Auth::user()->phone ?? '') }}" required>
                                            <div class="m-1">
                                                @error('phone')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div><!-- End .col-sm-6 -->
                                        <div class="col-lg-12">
                                            <label>Address</label>
                                            <textarea class="form-control" name="address" placeholder="Enter your full address"> {{ old('address', Auth::user()->address ?? '') }}</textarea>
                                            <div class="m-1">
                                                @error('address')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <label>Order notes (optional)</label>
                                            <textarea class="form-control" name="customer_note" placeholder="Order notes"></textarea>
                                            <div class="m-1">
                                                @error('customer_note')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <label>Select Area</label>
                                            <div class="delivery-area-options">
                                                @forelse($shippingCharges as $shipping)
                                                    <div class="form-check">
                                                        <input class="form-check-input shipping-option" style="margin-top: 7px;" type="radio"
                                                            name="shipping_charge_id" data-charge="{{ $shipping->delivery_charge }}"
                                                            id="delivery_area_{{ $shipping->id }}"
                                                            value="{{ $shipping->id }}"
                                                            {{ $loop->first ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="delivery_area_{{ $shipping->id }}">
                                                            &nbsp;&nbsp;{{ $shipping->area_name }} ({{ $shipping->delivery_charge }}TK)
                                                        </label>
                                                    </div>
                                                @empty
                                                    <p>No delivery areas available.</p>
                                                @endforelse
                                            </div>

                                        </div>
                                    </div><!-- End .row -->
                            </div><!-- End .col-lg-9 -->
                            <aside class="col-lg-3">
                                <div class="summary">
                                    <h3 class="summary-title">Your Order</h3><!-- End .summary-title -->

                                    <table class="table table-summary">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse($carts as $cart)
                                                @php
                                                    $product = App\Models\Product::find($cart['product_id']);
                                                    $variant = App\Models\Productvariant::find($cart['variant_id']);
                                                @endphp

                                                <tr>
                                                    <td>
                                                        <a href="#">
                                                            {{ $product ? $product->name : 'Unknown Product' }}
                                                            ({{ $variant ? $variant->variant_name : '' }})
                                                            X {{ $cart['quantity'] }}
                                                        </a>
                                                    </td>

                                                    <td>৳{{ $cart['price'] }}</td>
                                                </tr>

                                            @empty
                                            @endforelse


                                            <tr class="summary-subtotal">
                                                <td>Subtotal:</td>
                                                <td>৳{{$totalPrice}}</td>
                                            </tr>
                                            <tr class="summary-subtotal">
                                                <td>Delivery Charge:</td>
                                                <td>৳<span id="deliverycharge">{{$shippingCharges[0]->delivery_charge }}</span></td>
                                            </tr>
                                            @if(isset($coupon))
                                                @php
                                                    if($coupon->type=='percentage'){
                                                        $discount=intval($totalPrice*($coupon->discount/100));
                                                    }else{
                                                        $discount=$totalPrice-$coupon->discount;
                                                    }
                                                @endphp
                                                <tr class="summary-subtotal">
                                                    <td>Coupon: {{$coupon->code}}</td>
                                                    <td>৳<span id="discount">{{$discount}}</span></td>
                                                </tr>
                                            @else
                                                @php
                                                    $discount=0;
                                                @endphp
                                            @endif
                                            <tr class="summary-total">
                                                <td>Total:</td>
                                                <td>৳<span id="totalamount">{{  $discount ? $discount + $shippingCharges[0]->delivery_charge : $totalPrice + $shippingCharges[0]->delivery_charge }}</span></td>
                                            </tr><!-- End .summary-total -->
                                        </tbody>
                                    </table><!-- End .table table-summary -->

                                    <div class="accordion-summary" id="accordion-payment">
                                        <div class="payment-method-options">
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="payment_method"
                                                    id="payment_cod"
                                                    value="cod" style="margin-top: 7px;"
                                                    checked>
                                                <label class="form-check-label" for="payment_cod">
                                                    &nbsp;&nbsp; Cash on Delivery
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input"
                                                    type="radio"
                                                    name="payment_method"
                                                    id="payment_bkash" style="margin-top: 7px;"
                                                    value="bkash">
                                                <label class="form-check-label" for="payment_bkash">
                                                   &nbsp;&nbsp; Bkash
                                                </label>
                                            </div>
                                        </div>

                                    </div><!-- End .accordion -->

                                    <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
                                        Proceed to Checkout
                                    </button>
                                </div><!-- End .summary -->
                            </aside><!-- End .col-lg-3 -->
                        </div><!-- End .row -->
                    </form>
                </div><!-- End .container -->
            </div><!-- End .checkout -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->


    <script>
        let discount = {{ (int) $discount }};

            let totalPrice = {{ (int) $totalPrice }};
            {{--let discount = {{ (int) $discount }};--}}

            $(window).on("load", function () {
                $(".shipping-option:checked").trigger("change");
            });

        function setcoupon(){
            $.ajax({
                url: "{{ route('set-coupon') }}",
                type: "GET",
                data:{
                    coupon_code:$('#checkout-discount-input').val()
                },
                success: function(response) {
                   location.reload();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        //update delivery charge
            $(document).on("change", ".shipping-option", function () {
                let charge = parseInt($(this).data("charge")) || 0;

                // update delivery charge
                $("#deliverycharge").text(charge);


                let total = 0;
                if(discount>0)
                {
                    total =  discount + charge;
                }
                else
                {
                    total = totalPrice + charge;
                }

                $("#totalamount").text(total);
            });

        //get delivery charge
        $(document).on("change", ".shipping-option", function () {
            let shippingId = $(this).val();

            $.ajax({
                url: "{{ url('/get-shipping-charge') }}",   // your route
                type: "GET",
                data: { id: shippingId },
                success: function (response) {
                    $("#deliverycharge").text(response.delivery_charge);
                }
            });
        });
    </script>

@endsection
