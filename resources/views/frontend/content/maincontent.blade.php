@extends('frontend.master')

@section('meta')
    <!-- HTML Meta Tags -->
    <title>{{$settings->meta_title ?? ''}}</title>
    <meta name="description" content="{{$settings->meta_description ?? ''}}"/>
    <meta name="keywords" content="{{$settings->meta_keywords ?? ''}}"/>

    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="{{$settings->meta_title ?? ''}}"/>
    <meta itemprop="description" content="{{$settings->meta_description ?? ''}}"/>
    <meta itemprop="image" content="{{asset($settings->meta_image ?? '')}}"/>

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="{{url('/')}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{$settings->meta_title ?? ''}}"/>
    <meta property="og:description" content="{{$settings->meta_description ?? ''}}"/>
    <meta property="og:image" content="{{asset($settings->meta_image ?? '')}}"/>

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="{{$settings->meta_title ?? ''}}"/>
    <meta name="twitter:description" content="{{$settings->meta_description ?? ''}}"/>
    <meta name="twitter:image" content="{{asset($settings->meta_image ?? '')}}"/>

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

        @media (max-width: 480px) {
            .intro-slide {
                background-size: contain !important;
                background-position: center !important;
                background-repeat: no-repeat !important;
                min-height: 300px; /* adjust for mobile height */
            }
        }

    </style>
    <script type="application/ld+json">
        {!! $settings->google_schema ?? '' !!}
    </script>

@endsection

@section('maincontent')

    <main class="main">
        {{--   Slider Container Starts     --}}
        <div class="mb-5 intro-slider-container">
            <div class="intro-slider owl-carousel owl-theme owl-nav-inside owl-light" data-toggle="owl"
                 data-owl-options='{
                        "dots": true,
                        "nav": false,
                        "loop": true,
                        "autoplay": true,
                        "autoplayTimeout": 3000,
                        "responsive": {
                            "1200": {
                                "nav": true,
                                "dots": false
                            }
                        }
                    }'>

                @forelse($sliders as $slider)
                    <a href="{{ $slider->link ?? '#' }}">
                        <div class="intro-slide"
                             style="background-image: url({{asset($slider->image)}});">
                            <div class="container intro-content">
                                <div class="row justify-content-end">
                                    <div class="col-auto col-sm-7 col-md-6 col-lg-5">

                                    </div><!-- End .col-lg-11 offset-lg-1 -->
                                </div><!-- End .row -->
                            </div><!-- End .intro-content -->
                        </div>
                    </a>
                @empty
                @endforelse
            </div><!-- End .intro-slider owl-carousel owl-simple -->

            <span class="slider-loader"></span><!-- End .slider-loader -->
        </div>
        {{--   Slider Container Starts     --}}

        {{--    Offer Banner    --}}
        <div class="container">
            <div class="row justify-content-center">
                @forelse($offerBanners->take(2) as $banner)
                    <div class="col-md-6 col-lg-6">
                        <div class="banner banner-overlay banner-overlay-light">
                            <a href="{{$banner->btn_link}}">
                                <img src="{{asset($banner->image)}}" alt="Banner">
                            </a>
                        </div><!-- End .banner -->
                    </div><!-- End .col-md-4 -->
                @empty

                @endforelse
            </div><!-- End .row -->
        </div>

        <div class="container">
            <h2 class="mb-4 text-center title">Explore Popular Categories</h2><!-- End .title text-center -->

            <div class="cat-blocks-container">
                <div class="row justify-content-center">
                    @forelse($popularCategories->take(6) as $category)
                        <div class="col-6 col-sm-4 col-lg-2">
                            <a href="{{url('category',$category->slug)}}" class="cat-block">
                                <figure>
                                    <span>
                                        <img src="{{asset($category->image)}}" alt="{{$category->name}}"
                                             style="    border-radius: 6px;">
                                    </span>
                                </figure>
                                <h3 class="cat-block-title">{{$category->name}}</h3>
                            </a>
                        </div>
                    @empty
                    @endforelse
                </div><!-- End .row -->
            </div><!-- End .cat-blocks-container -->
        </div><!-- End .container -->

        <div class="mb-4"></div><!-- End .mb-4 -->

        <div class="container">
            <div class="row justify-content-center">
                @forelse($banners->take(3) as $banner)
                    <div class="col-md-6 col-lg-4">
                        <div class="banner banner-overlay banner-overlay-light">
                            <a href="{{$banner->btn_link}}">
                                <img src="{{asset($banner->image)}}" alt="Banner">
                            </a>
                        </div><!-- End .banner -->
                    </div><!-- End .col-md-4 -->
                @empty

                @endforelse
            </div><!-- End .row -->
        </div>

        <div class="mb-3"></div><!-- End .mb-5 -->

        <div class="container new-arrivals">
            <div class="mb-3 heading heading-flex">
                <div class="heading-left">
                    <h2 class="title">New Arrivals</h2><!-- End .title -->
                </div><!-- End .heading-left -->

{{--                <div class="heading-right">--}}
{{--                    <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">--}}
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link active" id="new-all-link" data-toggle="tab" href="#new-all-tab"--}}
{{--                               role="tab" aria-controls="new-all-tab" aria-selected="true">All</a>--}}
{{--                        </li>--}}
{{--                        --}}{{--                        @forelse($categories->where('front_status',1) as $category)--}}
{{--                        --}}{{--                            <li class="nav-item">--}}
{{--                        --}}{{--                                <a class="nav-link" id="new-acc-link" data-toggle="tab" href="#tab{{$category->id}}"--}}
{{--                        --}}{{--                                   role="tab"--}}
{{--                        --}}{{--                                   aria-controls="tab{{$category->id}}" aria-selected="false">{{$category->name}}</a>--}}
{{--                        --}}{{--                            </li>--}}
{{--                        --}}{{--                        @empty--}}
{{--                        --}}{{--                        @endforelse--}}
{{--                    </ul>--}}
{{--                </div><!-- End .heading-right -->--}}
            </div><!-- End .heading -->

            <div class="tab-content tab-content-carousel just-action-icons-sm">
                <div class="p-0 tab-pane fade show active" id="new-all-tab" role="tabpanel"
                     aria-labelledby="new-all-link">
                    <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow" data-toggle="owl"
                         data-owl-options='{
                                "nav": true,
                                "dots": true,
                                "margin": 20,
                                "loop": false,
                                "responsive": {
                                    "0": {
                                        "items":2
                                    },
                                    "480": {
                                        "items":2
                                    },
                                    "768": {
                                        "items":3
                                    },
                                    "992": {
                                        "items":4
                                    },
                                    "1200": {
                                        "items":5
                                    }
                                }
                            }'>

                        @forelse($newarrivels as $newarrivel)
                            @if($newarrivel->productvariants->count() > 0)
                                @include('frontend.content.product.view',['product'=>$newarrivel])
                            @endif
                        @empty
                        @endforelse

                    </div><!-- End .owl-carousel -->
                </div><!-- .End .tab-pane -->


                @forelse($categories->where('front_status',1) as $cates)
                    @php
                        $cproducts = App\Models\Product::where('category_id',$cates->id)->where('product_type_id', 1)->where('status', 1)->get();
                    @endphp
                    <div class="p-0 tab-pane fade" id="tab{{ $cates->id }}" role="tabpanel"
                         aria-labelledby="new-tv-link">
                        <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow" data-toggle="owl"
                             data-owl-options='{
                                    "nav": true,
                                    "dots": true,
                                    "margin": 20,
                                    "loop": false,
                                    "responsive": {
                                        "0": {
                                            "items":2
                                        },
                                        "480": {
                                            "items":2
                                        },
                                        "768": {
                                            "items":3
                                        },
                                        "992": {
                                            "items":4
                                        },
                                        "1200": {
                                            "items":5
                                        }
                                    }
                                }'>

                            @forelse($trandyproducts as $cproduct)
                                @if($cproduct->productvariants->count() > 0)
                                    @include('frontend.content.product.view',['product'=>$cproduct])
                                @endif
                            @empty
                            @endforelse
                        </div><!-- End .owl-carousel -->
                    </div><!-- .End .tab-pane -->
                @empty
                @endforelse
            </div><!-- End .tab-content -->
        </div><!-- End .container -->

        <div class="mb-6"></div><!-- End .mb-6 -->

        {{--        <div class="container">--}}
        {{--            <div class="mb-5 cta cta-border" style="background-image: url({{asset('public/frontend/assets')}}/images/demos/demo-4/bg-1.jpg);">--}}
        {{--                <img src="{{asset('public/frontend/assets')}}/images/demos/demo-4/camera.png" alt="camera" class="cta-img">--}}
        {{--                <div class="row justify-content-center">--}}
        {{--                    <div class="col-md-12">--}}
        {{--                        <div class="cta-content">--}}
        {{--                            <div class="text-right text-white cta-text">--}}
        {{--                                <p>Shop Today’s Deals <br><strong>Awesome Made Easy. HERO7 Black</strong></p>--}}
        {{--                            </div><!-- End .cta-text -->--}}
        {{--                            <a href="#" class="btn btn-primary btn-round"><span>Shop Now - ৳429.99</span><i--}}
        {{--                                    class="icon-long-arrow-right"></i></a>--}}
        {{--                        </div><!-- End .cta-content -->--}}
        {{--                    </div><!-- End .col-md-12 -->--}}
        {{--                </div><!-- End .row -->--}}
        {{--            </div><!-- End .cta -->--}}
        {{--        </div><!-- End .container -->--}}


{{--        <div class="pt-5 pb-6 bg-light">--}}
{{--            <div class="container trending-products">--}}
{{--                <div class="mb-3 heading heading-flex">--}}
{{--                    <div class="heading-left">--}}
{{--                        <h2 class="title">Trending Products</h2><!-- End .title -->--}}
{{--                    </div><!-- End .heading-left -->--}}
{{--                </div><!-- End .heading -->--}}

{{--                <div class="row">--}}
{{--                    <div class="col-lg 12">--}}
{{--                        <div class="tab-content tab-content-carousel just-action-icons-sm">--}}
{{--                            <div class="p-0 tab-pane fade show active" id="trending-top-tab" role="tabpanel"--}}
{{--                                 aria-labelledby="trending-top-link">--}}
{{--                                <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow"--}}
{{--                                     data-toggle="owl" data-owl-options='{--}}
{{--                                            "nav": true,--}}
{{--                                            "dots": false,--}}
{{--                                            "margin": 20,--}}
{{--                                            "loop": false,--}}
{{--                                            "responsive": {--}}
{{--                                                "0": {--}}
{{--                                                    "items":2--}}
{{--                                                },--}}
{{--                                                "480": {--}}
{{--                                                    "items":2--}}
{{--                                                },--}}
{{--                                                "768": {--}}
{{--                                                    "items":3--}}
{{--                                                },--}}
{{--                                                "992": {--}}
{{--                                                    "items":5--}}
{{--                                                }--}}
{{--                                            }--}}
{{--                                        }'>--}}

{{--                                    @forelse($trandyproducts as $trandyproduct)--}}
{{--                                        @if($trandyproduct->productvariants->count()>0)--}}
{{--                                            @include('frontend.content.product.view',['product'=>$trandyproduct])--}}
{{--                                        @endif--}}
{{--                                    @empty--}}
{{--                                    @endforelse--}}

{{--                                </div><!-- End .owl-carousel -->--}}
{{--                            </div><!-- .End .tab-pane -->--}}
{{--                        </div><!-- End .tab-content -->--}}
{{--                    </div><!-- End .col-xl-4-5col -->--}}
{{--                </div><!-- End .row -->--}}
{{--            </div><!-- End .container -->--}}
{{--        </div><!-- End .bg-light pt-5 pb-6 -->--}}

        {{-- Trending Products Starts --}}
        <div class="bg-light pt-5 pb-6">
            <div class="container trending-products">
                <div class="heading heading-flex mb-3">
                    <div class="heading-left">
                        <h2 class="title">Trending Products</h2>
                    </div><!-- End .heading-left -->
                </div><!-- End .heading -->

                <div class="row">
{{--                    <div class="col-xl-5col d-none d-xl-block">--}}
{{--                        <div class="banner">--}}
{{--                            <a href="#">--}}
{{--                                <img src="assets/images/demos/demo-4/banners/banner-4.jpg" alt="banner">--}}
{{--                            </a>--}}
{{--                        </div><!-- End .banner -->--}}
{{--                    </div><!-- End .col-xl-5col -->--}}

                    <div class="col-xl-4-5col">
                        <div class="tab-content tab-content-carousel just-action-icons-sm">
                            <div class="tab-pane p-0 fade show active" id="trending-top-tab" role="tabpanel"
                                 aria-labelledby="trending-top-link">
                                <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow"
                                     data-toggle="owl" data-owl-options='{
                                                "nav": true,
                                                "dots": false,
                                                "margin": 20,
                                                "loop": false,
                                                "responsive": {
                                                    "0": {
                                                        "items":2
                                                    },
                                                    "480": {
                                                        "items":2
                                                    },
                                                    "768": {
                                                        "items":3
                                                    },
                                                    "992": {
                                                        "items":4
                                                    }
                                                }
                                            }'>
                                    @forelse($trandyproducts as $trandyproduct)
                                        @if($trandyproduct->productvariants->count()>0)
                                            @include('frontend.content.product.view',['product'=>$trandyproduct])
                                        @endif
                                    @empty
                                    @endforelse
                                </div><!-- End .owl-carousel -->
                            </div><!-- .End .tab-pane -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Trending Products Ends --}}
        <div class="mb-5"></div><!-- End .mb-5 -->

        {{--Recommendation For You--}}
        <div class="container for-you">
            <div class="mb-3 heading heading-flex">
                <div class="heading-left">
                    <h2 class="title">Recommendation For You</h2><!-- End .title -->
                </div><!-- End .heading-left -->

                <div class="heading-right">
                    <a href="{{url('recommendation')}}" class="title-link">View All Recommendation <i
                            class="icon-long-arrow-right"></i></a>
                </div><!-- End .heading-right -->
            </div><!-- End .heading -->

            <div class="products">
                <div class="row justify-content-center">

                    @forelse($recomands as $recomand)
                        @if($recomand->productvariants->count() > 0)
                            <div class="col-6 col-md-4 col-lg-3">
                                @include('frontend.content.product.view',['product'=>$recomand])
                            </div>
                        @endif
                    @empty
                    @endforelse

                </div><!-- End .row -->
            </div><!-- End .products -->
        </div><!-- End .container -->


        {{--Brand--}}
        <div class="mb-4"></div><!-- End .mb-4 -->
        <div class="container">
            <hr class="mb-0">
            <div class="mt-5 mb-5 owl-carousel owl-simple" data-toggle="owl" data-owl-options='{
                        "nav": false,
                        "dots": false,
                        "margin": 30,
                        "loop": false,
                        "responsive": {
                            "0": {
                                "items":2
                            },
                            "420": {
                                "items":3
                            },
                            "600": {
                                "items":4
                            },
                            "900": {
                                "items":5
                            },
                            "1024": {
                                "items":6
                            }
                        }
                    }'>

                @forelse($brands as $brand)
                    <a href="{{url('brand',$brand->slug)}}" class="brand">
                        <img src="{{asset($brand->image)}}" alt="{{$brand->name}}">
                    </a>
                @empty
                @endforelse
            </div><!-- End .owl-carousel -->
        </div><!-- End .container -->
        <div class="container">
            <hr class="mb-0">
        </div><!-- End .container -->

        {{--        <div class="bg-transparent icon-boxes-container">--}}
        {{--            <div class="container">--}}
        {{--                <div class="row">--}}
        {{--                    <div class="col-sm-6 col-lg-3">--}}
        {{--                        <div class="icon-box icon-box-side">--}}
        {{--                            <span class="icon-box-icon text-dark">--}}
        {{--                                <i class="icon-rocket"></i>--}}
        {{--                            </span>--}}
        {{--                            <div class="icon-box-content">--}}
        {{--                                <h3 class="icon-box-title">Free Shipping</h3><!-- End .icon-box-title -->--}}
        {{--                                <p>Orders ৳50 or more</p>--}}
        {{--                            </div><!-- End .icon-box-content -->--}}
        {{--                        </div><!-- End .icon-box -->--}}
        {{--                    </div><!-- End .col-sm-6 col-lg-3 -->--}}

        {{--                    <div class="col-sm-6 col-lg-3">--}}
        {{--                        <div class="icon-box icon-box-side">--}}
        {{--                            <span class="icon-box-icon text-dark">--}}
        {{--                                <i class="icon-rotate-left"></i>--}}
        {{--                            </span>--}}

        {{--                            <div class="icon-box-content">--}}
        {{--                                <h3 class="icon-box-title">Free Returns</h3><!-- End .icon-box-title -->--}}
        {{--                                <p>Within 30 days</p>--}}
        {{--                            </div><!-- End .icon-box-content -->--}}
        {{--                        </div><!-- End .icon-box -->--}}
        {{--                    </div><!-- End .col-sm-6 col-lg-3 -->--}}

        {{--                    <div class="col-sm-6 col-lg-3">--}}
        {{--                        <div class="icon-box icon-box-side">--}}
        {{--                            <span class="icon-box-icon text-dark">--}}
        {{--                                <i class="icon-info-circle"></i>--}}
        {{--                            </span>--}}

        {{--                            <div class="icon-box-content">--}}
        {{--                                <h3 class="icon-box-title">Get 20% Off 1 Item</h3><!-- End .icon-box-title -->--}}
        {{--                                <p>when you sign up</p>--}}
        {{--                            </div><!-- End .icon-box-content -->--}}
        {{--                        </div><!-- End .icon-box -->--}}
        {{--                    </div><!-- End .col-sm-6 col-lg-3 -->--}}

        {{--                    <div class="col-sm-6 col-lg-3">--}}
        {{--                        <div class="icon-box icon-box-side">--}}
        {{--                            <span class="icon-box-icon text-dark">--}}
        {{--                                <i class="icon-life-ring"></i>--}}
        {{--                            </span>--}}

        {{--                            <div class="icon-box-content">--}}
        {{--                                <h3 class="icon-box-title">We Support</h3><!-- End .icon-box-title -->--}}
        {{--                                <p>24/7 amazing services</p>--}}
        {{--                            </div><!-- End .icon-box-content -->--}}
        {{--                        </div><!-- End .icon-box -->--}}
        {{--                    </div><!-- End .col-sm-6 col-lg-3 -->--}}
        {{--                </div><!-- End .row -->--}}
        {{--            </div><!-- End .container -->--}}
        {{--        </div><!-- End .icon-boxes-container -->--}}
    </main>
@endsection
