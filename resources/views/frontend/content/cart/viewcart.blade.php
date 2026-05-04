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
                    <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content" id="loadlist">
            <div class="cart">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9">
                            <table class="table table-cart table-mobile">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($carts as $cart)
                                        <tr>
                                            <td class="product-col">
                                                <div class="product">
                                                    <figure class="product-media">
                                                        <a href="#">
                                                            <img src="{{asset(App\Models\Productcolor::where('id',$cart->color_id)->first()->image)}}"
                                                                alt="Product image">
                                                        </a>
                                                    </figure>

                                                    <h3 class="product-title">
                                                        <a href="#">{{App\Models\Product::where('id',$cart->product_id)->first()->name}}</a>
                                                    </h3><!-- End .product-title -->
                                                </div><!-- End .product -->
                                            </td>
                                            <td class="price-col">৳{{$cart->price}}</td>
                                            <td class="quantity-col">
                                                <div class="cart-product-quantity">
                                                    {{$cart->quantity}}
                                                </div><!-- End .cart-product-quantity -->
                                            </td>
                                            <td class="total-col">৳{{$cart->price*$cart->quantity}}</td>
                                            <td class="remove-col"><button class="btn-remove" type="button" onclick="removefronlist('{{$cart->id}}')"><i
                                                        class="icon-close"></i></button></td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table><!-- End .table table-wishlist -->


                        </div><!-- End .col-lg-9 -->
                        <aside class="col-lg-3">
                            <div class="summary summary-cart">
                                <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

                                <table class="table table-summary">
                                    <tbody>
                                        <tr class="summary-subtotal">
                                            <td>Subtotal:</td>
                                            <td>৳{{$totalPrice}}</td>
                                        </tr><!-- End .summary-subtotal -->

                                    </tbody>
                                </table><!-- End .table table-summary -->

                                <a href="{{url('checkout')}}"
                                    class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>
                            </div><!-- End .summary -->

                            <a href="{{url('/')}}" class="mb-3 btn btn-outline-dark-2 btn-block"><span>CONTINUE
                                    SHOPPING</span><i class="icon-refresh"></i></a>
                        </aside><!-- End .col-lg-3 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .cart -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->

@endsection