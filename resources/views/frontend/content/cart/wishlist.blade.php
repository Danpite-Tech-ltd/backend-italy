@extends('frontend.master')

@section('maincontent')
    @section('meta')
    @endsection

    <style>
        .table td {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .btn {
            min-width: 0px !important;
        }
    </style>
    <
    <main class="main">
        <nav aria-label="breadcrumb" class="mb-2 breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('/shop-by-category')}}">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Wish List</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content" id="loadlist">
            <div class="cart">
                <div class="container">
                    <div class="row">
                        <div class="m-auto col-lg-8">
                            <table class="table table-cart table-mobile">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse($wishlists as $wishlist)
                                    @php
                                        $product=App\Models\Product::where('id',$wishlist->product_id)->first();
                                    @endphp
                                    <tr>
                                        <td class="product-col">
                                            <div class="product">
                                                <figure class="product-media">
                                                    <a href="{{url('product-details',$product->slug)}}">
                                                        <img src="{{asset($product->thumbnail_img)}}"
                                                             style="border-radius:4px;"
                                                             alt="Product image">
                                                    </a>
                                                </figure>

                                                <h3 class="product-title">
                                                    <a href="{{url('product-details',$product->slug)}}">{{$product->name}}</a>
                                                </h3><!-- End .product-title -->
                                            </div><!-- End .product -->
                                        </td>
                                        <td class="remove-col">
                                            <a href="{{url('product-details',$product->slug)}}"
                                               class="btn btn-info btn-sm">
                                                <i class="la la-eye"></i>
                                            </a>

                                            <form action="{{ route('remove-wish') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $wishlist->id}}">

                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="la la-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                                </tbody>
                            </table><!-- End .table table-wishlist -->


                        </div><!-- End .col-lg-9 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .cart -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->

@endsection
