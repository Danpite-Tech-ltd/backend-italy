@extends('frontend.master')

@section('meta')
    <!-- HTML Meta Tags -->
    <title>{{$product->meta_title ?? ''}}</title>
    <meta name="description" content="{{$product->meta_description ?? ''}}"/>
    <meta name="keywords" content="{{$product->meta_keywords ?? ''}}"/>

    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="{{$product->meta_title ?? ''}}"/>
    <meta itemprop="description" content="{{$product->meta_description ?? ''}}"/>
    <meta itemprop="image" content="{{asset($product->meta_image ?? '')}}"/>

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="{{url('/')}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{$product->meta_title ?? ''}}"/>
    <meta property="og:description" content="{{$product->meta_description ?? ''}}"/>
    <meta property="og:image" content="{{asset($product->meta_image ?? '')}}"/>

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="{{$product->meta_title ?? ''}}"/>
    <meta name="twitter:description" content="{{$product->meta_description ?? ''}}"/>
    <meta name="twitter:image" content="{{asset($product->meta_image ?? '')}}"/>

    <!-- Schema -->
    <script type="application/ld+json">
        {!! $product->google_schema ?? '' !!}
    </script>

@endsection

@section('maincontent')


    <style>
        .intro-title {
            font-size: 5rem;
            width: 80%;
        }

        .banner-title {
            color: #999;
            font-weight: 400;
            font-size: 1.6rem;
            line-height: 1.25;
            letter-spacing: -.01em;
            margin-bottom: 1.2rem;
            width: 70%;
        }

        .varient {
            position: relative;
            display: inline-block;
            padding: 8px 15px;
            background: #f4f4f4;
            border-radius: 6px;
            text-decoration: none;
            transition: 0.3s;
            margin: 3px;
            font-weight: bold;
            color: black;
        }

        .varient.active {
            background: #0062d3;
            border: 1px solid #2709c7;
            color: white;
            font-weight: bold;
        }

        .varient.active::after {
            content: "✔";
            position: absolute;
            top: -8px;
            right: -5px;
            background: #3cb371;
            color: #fff;
            font-size: 12px;
            padding: 0px 4px;
            border-radius: 50%;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.5);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .product-nav-thumbs .thumb-item {
            position: relative;
            display: inline-block;
            margin: 5px;
            border: 2px solid transparent;
            border-radius: 6px;
            overflow: hidden;
            transition: 0.3s;
        }

        .product-nav-thumbs .thumb-item img {
            display: block;
            width: 50px;
            height: 50px;
            border-radius: 4px;
        }

        .product-nav-thumbs .thumb-item.active {
            border-color: #3cb371; /* Active border */
        }

        .product-nav-thumbs .thumb-item.active::after {
            content: "✔";
            position: absolute;
            top: -6px;
            right: 8px;
            color: #0e8f33;
            font-size: 28px;
            padding: 0px 0px;
            font-weight: bold;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.5);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .product-gallery-item:before {
            border-color: #fff !important;
        }

        #ajax-loader-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.7);
            z-index: 9999;

            display: flex;
            justify-content: center;
            align-items: center;
        }


        #ajax-loader-overlay .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #ddd;
            border-top: 5px solid #3cb371;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        .input-group {
            display: flex;
            align-items: center;
            /*max-width: 120px;*/
        }

        .input-group input {
            text-align: center;
            width: 60px;
            margin: 0 5px;
        }

        .btn-qty {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            width: 30px;
            height: 30px;
            cursor: pointer;
            font-size: 18px;
            line-height: 1;
            text-align: center;
        }

        .btn-qty:hover {
            background-color: #ddd;
        }

        #ordernow {
            background: green;
            color: white;
            text-decoration: none;
            border: 1px solid;
            font-size: 1.4rem;
            text-transform: uppercase;
            box-shadow: none;
            transition: box-shadow .35s ease, color 0s ease;
            padding: 13px;
        }

        #ordernow:hover {
            background: green;
            color: white;
            text-decoration: none;
            border: 1px solid;
        }

        @media screen and (max-width: 580px) {
            .product-details-action .btn-cart, .product-details-centered .product-details-action .btn-cart {
                min-width: 100%;
            }
        }

        .flying-img {
            position: fixed;
            width: 50px;
            height: 50px;
            z-index: 9999;
            pointer-events: none;
            transition: all 1s ease-in-out;
            border-radius: 5px;
        }

        #add-to-cart-btn:hover span {
            color: white !important; /* Change text to white on hover */
        }

    </style>

    <main class="main">
        <div class="pt-2 page-content">
            <div class="container">
                <div class="product-details-top">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="product-gallery product-gallery-vertical">
                                <div class="row">

                                    <figure class="product-main-image">
                                        <img id="product-zoom" src="{{ asset($product->thumbnail_img) }}"
                                             data-zoom-image="{{ asset($product->thumbnail_img) }}">
                                        <a href="{{ asset($product->thumbnail_img) }}" id="btn-product-gallery"></a>
                                    </figure>

                                    <div id="product-zoom-gallery" class="product-image-gallery">
                                        @php
                                            $images = $firstcolor->images ? json_decode($firstcolor->images, true) : [];
                                        @endphp
                                        <a class="product-gallery-item active"
                                           href="javascript:void(0)"
                                           data-image="{{ asset($product->thumbnail_img) }}"
                                           data-zoom-image="{{ asset($product->thumbnail_img) }}">
                                            <img src="{{ asset($product->thumbnail_img) }}"
                                                 alt="{{ $product->name ?? '' }}">
                                        </a>
                                        @if(!empty($images))
                                            @foreach ($images as $image)
                                                <a class="product-gallery-item"
                                                   href="javascript:void(0)"
                                                   data-image="{{ asset($image) }}"
                                                   data-zoom-image="{{ asset($image) }}">
                                                    <img src="{{ asset($image) }}" alt="{{ $product->name ?? '' }}">
                                                </a>
                                            @endforeach
                                        @endif
                                    </div><!-- End .product-image-gallery -->
                                </div><!-- End .row -->
                            </div><!-- End .product-gallery -->
                        </div><!-- End .col-md-6 -->

                        <div class="col-md-6">
                            {{--                            <form class="product-details">--}}
                            <h1 class="mb-2 product-title">{{$product->name}}</h1><!-- End .product-title -->

{{--                            <div class="ratings-container">--}}
{{--                                <div class="ratings">--}}
{{--                                    <div class="ratings-val" style="width: 100%;"></div><!-- End .ratings-val -->--}}
{{--                                </div><!-- End .ratings -->--}}
{{--                                <a class="ratings-text" href="#product-review-link" id="review-link">( 2 Reviews )</a>--}}
{{--                            </div><!-- End .rating-container -->--}}

                            <div class="product-price">
                                <del style="color:red;font-size:16px;">৳<span
                                        id="regularprice">{{intval($firstvarient->regular_price)}}</span></del>
                                &nbsp;<b>৳<span id="saleprice">{{intval($firstvarient->sale_price)}}</span></b>
                            </div><!-- End .product-price -->
                            @if(isset($product->short_description))
                                <div class="product-content">
                                    <p>{{$product->short_description}}</p>
                                </div><!-- End .product-content -->
                            @endif
                            {{-- ===================== COLOR SECTION ===================== --}}
                            @if($firstcolor->color_id==1)

                            @else
                                <label class="mb-0"><b>Color:</b></label>
                                <div class="mb-0 details-filter-row details-row-size">
                                    <div class="product-nav product-nav-thumbs">
                                        @foreach ($product->productcolors as $color)
                                            <a href="javascript:void(0)"
                                            class="thumb-item {{ $loop->first ? 'active' : '' }}"
                                            data-id="{{ $color->id }}"
                                            data-image="{{ asset($color->image) }}"
                                            data-zoom-image="{{ asset($color->image) }}">
                                                <img src="{{ asset($color->image) }}" alt="{{ $product->name ?? '' }}">
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif


                            {{-- ===================== VARIANT SECTION ===================== --}}
                            @if($firstvarient->variant_id == 1)
                                <input type="hidden" value="{{ $firstvarient->id }}" name="from_varient" id="from_varient">
                            @else
                                <label class="mb-0"><b>Choose Variant:</b></label>
                                <div class="details-filter-row details-row-size">
                                    <div class="d-flex">

                                        @foreach($varients as $varient)
                                            <a href="javascript:void(0)"
                                            class="mr-2 varient {{ $loop->first ? 'active' : '' }}"
                                            data-id="{{ $varient->id }}"
                                            style="{{ $varient->total_stock == 0 ? 'pointer-events:none; opacity:0.4;' : '' }}">

                                                {{ $varient->variant_name }}

                                                {{-- STOCK BADGE --}}
                                                @if($varient->total_stock == 0)
                                                    <span class="ml-1 badge badge-danger">Stock Out</span>
                                                @endif

                                            </a>
                                        @endforeach

                                    </div>
                                </div>

                                <input type="hidden" value="{{ $firstvarient->id }}" name="from_varient" id="from_varient">
                            @endif



                            {{-- ===================== ORDER FORM ===================== --}}
                            <form action="{{ route('order-now') }}" method="post">
                                @csrf
                                <input type="hidden" name="variant_id" value="{{ $firstvarient->id }}" id="variant_id">


                                {{-- Stock Message for First Variant --}}
                                @if($firstvarient->total_stock == 0)
                                    <p class="text-danger"><b>Stock Out</b></p>
                                @endif


                                {{-- ===================== QTY SECTION ===================== --}}
                                <div class="details-filter-row details-row-size">
                                    <label for="qty">Qty:</label>
                                    <div class="product-details-quantity">
                                        <div class="input-group">
                                            <button type="button" class="btn-qty btn-decrement d-none">-</button>
                                            <input type="number" name="quantity" id="qty" class="form-control"
                                                value="1" min="1" max="10" step="1" required>
                                            <button type="button" class="btn-qty btn-increment d-none">+</button>
                                        </div>
                                    </div>
                                </div>


                                {{-- ===================== ACTION BUTTONS ===================== --}}
                                <div class="product-details-action">

                                    {{-- Add to Cart --}}
                                    @if($firstvarient->total_stock == 0)
                                        <a class="mb-1 btn-product btn-cart w-100 mr-lg-2"
                                        style="pointer-events:none; opacity:0.4;">
                                            <span>Stock Out</span>
                                        </a>
                                    @else
                                        <a type="button" class="mb-1 btn-product btn-cart w-100 mr-lg-2"
                                        id="add-to-cart-btn">
                                            <span>Add to Cart</span>
                                        </a>
                                    @endif


                                    {{-- Order Now --}}
                                    @if($firstvarient->total_stock == 0)
                                        <button type="button" class="mb-1 btn-product btn-cart w-100"
                                                style="opacity:0.4;" disabled>
                                            Stock Out
                                        </button>
                                    @else
                                        <button type="submit" class="mb-1 btn-product btn-cart w-100" id="ordernow">
                                            Order Now
                                        </button>
                                    @endif


                                    <div class="details-action-wrapper">
                                        <a href="javascript:void(0)"
                                        class="mb-1 btn-product btn-wishlist add-to-wishlist"
                                        data-id="{{ $product->id }}"
                                        title="Wishlist">
                                            <span>Add to Wishlist</span>
                                        </a>
                                    </div>

                                </div>
                            </form>

                            <div class="product-details-action">
                                @if($authAff)
                                    @if(auth()->check() && App\Models\AffiliateProduct::where('product_id', $product->id)
                                            ->where('affiliate_id', auth()->id())
                                             ->exists())
                                        {{-- The affiliate product exists --}}
                                        <button type="submit" class="mb-1 btn-product btn-cart w-100 mr-lg-2" disabled>
                                            <span>Added to Shop</span>
                                        </button>
                                    @else

                                        <form action="{{ route('add-product-affiliate') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                            <button type="submit" class="mb-1 btn-product btn-cart w-100 mr-lg-2">
                                                <span>Add to Shop</span>
                                            </button>
                                        </form>

                                    @endif
                                @endif
                            </div>
                            <div class="product-details-footer">
                                <div class="product-cat">
                                    <span>Category:</span> <a
                                        href="{{url('category',$product->category->slug)}}">{{$product->category->name}}</a>
                                </div><!-- End .product-cat -->

                                <div class="social-icons social-icons-sm">
                                    <span class="social-label">Share:</span>
                                    <a href="{{ $shareLinks['facebook'] }}"
                                       class="social-icon" title="Facebook" target="_blank">
                                        <i class="icon-facebook-f"></i>
                                    </a>

                                    <a href="{{ $shareLinks['twitter'] }}"
                                       class="social-icon" title="Twitter" target="_blank">
                                        <i class="icon-twitter"></i>
                                    </a>

                                    <a href="{{ $shareLinks['pinterest'] }}"
                                       class="social-icon" title="Pinterest" target="_blank">
                                        <i class="icon-pinterest"></i>
                                    </a>
                                    <a href="{{ $shareLinks['whatsapp'] }}"
                                       class="social-icon" title="WhatsApp" target="_blank">
                                        <i class="icon-whatsapp"></i>
                                    </a>
                                </div>
                            </div><!-- End .product-details-footer -->
                        </div><!-- End .product-details -->
                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
                <div id="ajax-loader-overlay" style="display: none;">
                    <div class="spinner"></div>
                </div>
                <script>
                    $(document).ready(function () {
                        $(".product-nav-thumbs").on("click", ".thumb-item", function (e) {
                            e.preventDefault();

                            $(".thumb-item").removeClass("active");
                            $(this).addClass("active");

                            let colorId = $(this).data("id");

                            $.ajax({
                                url: "{{ route('change-color') }}",
                                type: "GET",
                                data: {
                                    color_id: colorId
                                },
                                beforeSend: function () {
                                    $("#ajax-loader-overlay").show();
                                },
                                success: function (response) {
                                    $("#ajax-loader-overlay").hide();
                                    $('.product-details-top').empty().append(response);
                                    initProductGallery();
                                },
                                error: function (xhr) {
                                    console.error(xhr.responseText);
                                }
                            });
                        });
                    });

                    document.addEventListener('DOMContentLoaded', function () {
                        const mainImg = document.getElementById('product-zoom');
                        const galleryLink = document.getElementById('btn-product-gallery');
                        const galleryItems = document.querySelectorAll('.product-gallery-item');

                        galleryItems.forEach(item => {
                            item.addEventListener('click', function (e) {
                                e.preventDefault();

                                // Get clicked thumbnail image
                                let newImage = this.getAttribute('data-image');
                                let zoomImage = this.getAttribute('data-zoom-image');

                                // Update main image src and zoom image
                                mainImg.setAttribute('src', newImage);
                                mainImg.setAttribute('data-zoom-image', zoomImage);
                                galleryLink.setAttribute('href', newImage);

                                // Remove active class from all thumbnails
                                galleryItems.forEach(i => i.classList.remove('active'));
                                // Add active class to clicked one
                                this.classList.add('active');
                            });
                        });
                    });

                    document.addEventListener("DOMContentLoaded", function () {
                        const variants = document.querySelectorAll(".varient");

                        variants.forEach(variant => {
                            variant.addEventListener("click", function (e) {
                                e.preventDefault();

                                variants.forEach(v => v.classList.remove("active"));
                                this.classList.add("active");

                                let variantId = this.dataset.id;
                                $('#from_varient').val(variantId);
                                $.ajax({
                                    url: "{{ route('change-variant') }}",
                                    type: "GET",
                                    data: {
                                        variant_id: variantId
                                    },
                                    success: function (response) {
                                        $("#saleprice").text(parseInt(response.sale_price));
                                        $("#regularprice").text(parseInt(response.regular_price));

                                        $('#variant_id').val(variantId);
                                    },
                                    error: function (xhr) {
                                        console.error(xhr.responseText);
                                    }
                                });
                            });
                        });
                    });

                    document.addEventListener("DOMContentLoaded", function () {
                        const qtyInput = document.getElementById("qty");
                        const btnIncrement = document.querySelector(".btn-increment");
                        const btnDecrement = document.querySelector(".btn-decrement");

                        btnIncrement.addEventListener("click", function () {
                            let current = parseInt(qtyInput.value) || 1;
                            let max = parseInt(qtyInput.getAttribute("max")) || 10;
                            if (current < max) {
                                qtyInput.value = current + 1;
                            }
                        });

                        btnDecrement.addEventListener("click", function () {
                            let current = parseInt(qtyInput.value) || 1;
                            let min = parseInt(qtyInput.getAttribute("min")) || 1;
                            if (current > min) {
                                qtyInput.value = current - 1;
                            }
                        });
                    });

                    document.getElementById("add-to-cart-btn").addEventListener("click", function (e) {
                        const productImg = document.getElementById("product-zoom");
                        const cartIcon = document.getElementById("cart-icon");

                        // Clone the image
                        const flyingImg = productImg.cloneNode(true);
                        flyingImg.classList.add("flying-img");
                        document.body.appendChild(flyingImg);

                        // Set starting position
                        const rect = productImg.getBoundingClientRect();
                        flyingImg.style.top = rect.top + "px";
                        flyingImg.style.left = rect.left + "px";

                        $.ajax({
                            url: "{{ route('add-to-cart') }}",
                            type: "GET",
                            data: {
                                variant_id: $('#from_varient').val(),
                                quantity: $('#qty').val(),
                            },
                            success: function (response) {
                                $('.cart-count').html(response.item);
                                loadcart();
                            },
                            error: function (xhr) {
                                console.error(xhr.responseText);
                            }
                        });

                        // Get cart position
                        const cartRect = cartIcon.getBoundingClientRect();

                        // Trigger animation
                        setTimeout(() => {
                            flyingImg.style.top = cartRect.top + "px";
                            flyingImg.style.left = cartRect.left + "px";
                            flyingImg.style.width = "20px";
                            flyingImg.style.height = "20px";
                            flyingImg.style.opacity = "0.5";
                        }, 10);

                        // Remove the image after animation
                        flyingImg.addEventListener("transitionend", function () {
                            flyingImg.remove();
                        });
                    });


                </script>
            </div><!-- End .product-details-top -->

            <div class="product-details-tab">
                <ul class="nav nav-pills justify-content-center" role="tablist">
                    @if(isset($product->long_description))
                        <li class="nav-item">
                            <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab"
                               role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                        </li>
                    @endif


                    @if(isset($product->additional_info_text))
                        <li class="nav-item">
                            <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab"
                               role="tab" aria-controls="product-info-tab" aria-selected="false">Additional
                                information</a>
                        </li>
                    @endif

                    @if(isset($product->shipping_return_text))
                        <li class="nav-item">
                            <a class="nav-link" id="product-shipping-link" data-toggle="tab"
                               href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab"
                               aria-selected="false">Shipping & Returns</a>
                        </li>
                    @endif

                    {{--                        <li class="nav-item">--}}
                    {{--                            <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab" role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews (2)</a>--}}
                    {{--                        </li>--}}
                </ul>
                <div class="tab-content">
                    @if(isset($product->long_description))
                        <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel"
                             aria-labelledby="product-desc-link">
                            <div class="product-desc-content">
                                {!!$product->long_description!!}
                            </div><!-- End .product-desc-content -->
                        </div><!-- .End .tab-pane -->
                    @endif

                    @if(isset($product->additional_info_text))
                        <div class="tab-pane fade" id="product-info-tab" role="tabpanel"
                             aria-labelledby="product-info-link">
                            <div class="product-desc-content">
                                {!! $product->additional_info_text !!}
                            </div><!-- End .product-desc-content -->
                        </div><!-- .End .tab-pane -->
                    @endif

                    @if(isset($product->shipping_return_text))
                        <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel"
                             aria-labelledby="product-shipping-link">
                            <div class="product-desc-content">
                                {!!$product->shipping_return_text!!}
                            </div><!-- End .product-desc-content -->
                        </div><!-- .End .tab-pane -->
                    @endif

                    {{--                        <div class="tab-pane fade" id="product-review-tab" role="tabpanel" aria-labelledby="product-review-link">--}}
                    {{--                            <div class="reviews">--}}
                    {{--                                <h3>Reviews (2)</h3>--}}
                    {{--                                <div class="review">--}}
                    {{--                                    <div class="row no-gutters">--}}
                    {{--                                        <div class="col-auto">--}}
                    {{--                                            <h4><a href="#">Samanta J.</a></h4>--}}
                    {{--                                            <div class="ratings-container">--}}
                    {{--                                                <div class="ratings">--}}
                    {{--                                                    <div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->--}}
                    {{--                                                </div><!-- End .ratings -->--}}
                    {{--                                            </div><!-- End .rating-container -->--}}
                    {{--                                            <span class="review-date">6 days ago</span>--}}
                    {{--                                        </div><!-- End .col -->--}}
                    {{--                                        <div class="col">--}}
                    {{--                                            <h4>Good, perfect size</h4>--}}

                    {{--                                            <div class="review-content">--}}
                    {{--                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus cum dolores assumenda asperiores facilis porro reprehenderit animi culpa atque blanditiis commodi perspiciatis doloremque, possimus, explicabo, autem fugit beatae quae voluptas!</p>--}}
                    {{--                                            </div><!-- End .review-content -->--}}

                    {{--                                            <div class="review-action">--}}
                    {{--                                                <a href="#"><i class="icon-thumbs-up"></i>Helpful (2)</a>--}}
                    {{--                                                <a href="#"><i class="icon-thumbs-down"></i>Unhelpful (0)</a>--}}
                    {{--                                            </div><!-- End .review-action -->--}}
                    {{--                                        </div><!-- End .col-auto -->--}}
                    {{--                                    </div><!-- End .row -->--}}
                    {{--                                </div><!-- End .review -->--}}

                    {{--                            </div><!-- End .reviews -->--}}
                    {{--                        </div><!-- .End .tab-pane -->--}}
                </div><!-- End .tab-content -->
            </div><!-- End .product-details-tab -->

            <h2 class="mb-4 text-center title">You May Also Like</h2><!-- End .title text-center -->

            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                 data-owl-options='{
                            "nav": false,
                            "dots": true,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":1
                                },
                                "480": {
                                    "items":2
                                },
                                "768": {
                                    "items":3
                                },
                                "992": {
                                    "items":5
                                },
                                "1200": {
                                    "items":5,
                                    "nav": true,
                                    "dots": false
                                }
                            }
                        }'>
                @forelse($recomands as $recomand)
                    @include('frontend.content.product.view',['product'=>$recomand])
                @empty
                @endforelse
            </div><!-- End .owl-carousel -->
        </div><!-- End .container -->
        </div><!-- End .page-content -->
    </main>

@endsection
