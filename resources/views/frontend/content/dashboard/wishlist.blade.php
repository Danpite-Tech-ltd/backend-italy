@extends('frontend.content.dashboard.layout.app')

@section('css')


@endsection


@section('content')

    <div class="main-content">
        <!-- Content Header -->
        <div class="content-header">
            <h2 class="mb-0">Whistlist</h2>
            <p class="mb-0">Your whistlist items</p>
        </div>

        <!-- Main Content Area -->
        <div class="p-4">
            <div class="section-content text-center">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 ">
                    <!-- Product Card 1 -->
                    @forelse($wishlists as $wishlist)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product">
                            <figure class="product-media">
                                <a href="{{ route('product-details',$wishlist->product->slug) }}">
                                    <img src="{{ asset($wishlist->product->thumbnail_img) }}" width="200" height="200" alt="Product image" class="product-image">
                                </a>
                            </figure>
                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="javascript:void(0)">{{ $wishlist->product->category->name ?? '' }}</a>
                                </div>
                                <h3 class="product-title">
                                    <a href="{{ route('product-details',$wishlist->product->slug) }}">{{ $wishlist->product->name ?? '' }}</a>
                                </h3>

                            </div>
                        </div>
                    </div>

                    @empty
                    @endforelse

                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')

@endsection

