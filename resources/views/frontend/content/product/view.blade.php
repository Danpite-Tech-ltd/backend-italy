{{--<style>--}}

{{--</style>--}}
{{--<div class="product product-2">--}}
{{--    <figure class="product-media">--}}

{{--        <a href="{{ route('product-details', $product->slug) }}">--}}
{{--            <img src="{{ asset($product->thumbnail_img) }}" alt="Product image"--}}
{{--                class="product-image">--}}
{{--        </a>--}}

{{--        <div class="product-action-vertical">--}}
{{--            <a href="javascript:void(0)"--}}
{{--                class="add-to-wishlist"--}}
{{--                data-id="{{ $product->id }}"--}}
{{--                title="Add to wishlist" style="">--}}
{{--                <i class="fa-regular fa-heart"></i>--}}
{{--            </a>--}}
{{--        </div><!-- End .product-action -->--}}

{{--        <div class="product-action">--}}
{{--            <a href="{{ url('product-details',$product->slug) }} " class="btn-product btn-cart" title="Add to cart"><span>add to--}}
{{--                    cart</span></a>--}}
{{--            <a href="{{ url('product-details',$product->slug) }}" class="btn-product"--}}
{{--                title="Quick view"><i class="la la-eye" aria-hidden="true"></i></a>--}}
{{--        </div><!-- End .product-action -->--}}
{{--    </figure><!-- End .product-media -->--}}

{{--    <div class="product-body">--}}
{{--        <div class="product-cat">--}}
{{--            <a href="{{ route('product-details', $product->slug) }}">{{ $product->category->name ?? '' }}</a>--}}
{{--        </div><!-- End .product-cat -->--}}
{{--        <h3 class="product-title"><a href="{{url('product-details',$product->slug)}}">{{ $product->name ?? '' }}</a>--}}
{{--        </h3>--}}
{{--        <!-- End .product-title -->--}}
{{--        <div class="product-price">--}}
{{--            ৳{{ $product->productvariants[0]->sale_price ?? '' }}--}}
{{--        </div><!-- End .product-price -->--}}
{{--        <div class="ratings-container">--}}
{{--            <div class="ratings">--}}
{{--                <div class="ratings-val" style="width: 100%;"></div>--}}
{{--                <!-- End .ratings-val -->--}}
{{--            </div><!-- End .ratings -->--}}
{{--            <span class="ratings-text">( 4 Reviews )</span>--}}
{{--        </div><!-- End .rating-container -->--}}
{{--    </div><!-- End .product-body -->--}}
{{--</div>--}}


{{--Alternate--}}

<div class="product product-2">
    <figure class="product-media">

        <a href="{{ route('product-details', $product->slug) }}" >
            <img src="{{ asset($product->thumbnail_img) }}"
                 alt="Product image" class="product-image" width="218" height="218" style="height: 218px!important;">
        </a>

                <div class="product-action-vertical">
                    <a href="javascript:void(0)"
                        class="add-to-wishlist"
                        data-id="{{ $product->id }}"
                        title="Add to wishlist" style="">
                        @if(\App\Models\Wishlist::where('ip',request()->ip())->where('product_id',$product->id )->first())
                        <i class="fa-solid fa-heart"></i>
                        @else
                            <i class="fa-regular fa-heart"></i>
                        @endif
                    </a>
                </div>

                <div class="product-action">
                    <a href="{{ url('product-details',$product->slug) }} " class="btn-product btn-cart" title="Add to cart"><span>add to
                            cart</span></a>
                    <a href="{{ url('product-details',$product->slug) }}" class="btn-product"
                        title="Quick view"><i class="la la-eye" aria-hidden="true"></i></a>
                </div><!-- End .product-action -->
    </figure>

    <div class="product-body">
        <div class="product-cat">
            <a href="{{ route('categoryproduct',$product->category->slug) }}">{{ $product->category->name ?? '' }}</a>
        </div><!-- End .product-cat -->
        <h3 class="product-title"><a href="{{ route('product-details', $product->slug) }}">{{ $product->name ?? '' }}</a></h3><!-- End .product-title -->
        <div class="product-price">
            ৳{{ $product->productvariants[0]->sale_price ?? '' }}
        </div>
    </div><!-- End .product-body -->
</div>
