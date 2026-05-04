
@php

 $total =  $carts->sum(function($cart) {
        return $cart->price * $cart->quantity;
    })
@endphp

<div class="dropdown-cart-products">
    @forelse($carts as $cart)
        <div class="product">
            <div class="product-cart-details">
                <h4 class="product-title">
                    <a href="#">{{App\Models\Product::where('id',$cart->product_id)->first()->name}}</a>
                </h4>

                <span class="cart-product-info">
                    <span class="cart-product-qty">{{$cart->quantity}}</span>
                    x ৳{{$cart->price}}
                </span>
            </div><!-- End .product-cart-details -->

            <figure class="product-image-container">
                <a href="#" class="product-image">
                    <img src="{{asset(App\Models\Productcolor::where('id',$cart->color_id)->first()->image)}}" alt="product">
                </a>
            </figure>
            <a type="button" onclick="removecart('{{$cart->id}}')" class="btn-remove" title="Remove Product"><i
                    class="icon-close"></i></a>
        </div><!-- End .product -->
    @empty
    @endforelse
</div>

<div class="dropdown-cart-total">
    <span>Total</span>

    <span class="cart-total-price">৳{{ $total }}</span>
</div><!-- End .dropdown-cart-total -->

<div class="dropdown-cart-action">
    <a href="{{url('view-cart')}}" class="btn btn-primary">View Cart</a>
    <a href="{{url('checkout')}}" class="btn btn-outline-primary-2"><span>Checkout</span><i
            class="icon-long-arrow-right"></i></a>
</div><!-- End .dropdown-cart-total -->
