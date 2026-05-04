@extends('frontend.master')

@section('maincontent')
    @section('meta')
        <!-- HTML Meta Tags -->
        <title>{{$category->meta_title}}</title>
        <meta name="description" content="{{$category->meta_description}}"/>
        <meta name="keywords" content="{{$category->meta_keywords}}"/>

        <!-- Google / Search Engine Tags -->
        <meta itemprop="name" content="{{$category->meta_title}}"/>
        <meta itemprop="description" content="{{$category->meta_description}}"/>
        <meta itemprop="image" content="{{asset($category->meta_image)}}"/>

        <!-- Facebook Meta Tags -->
        <meta property="og:url" content="{{url('/')}}"/>
        <meta property="og:type" content="website"/>
        <meta property="og:title" content="{{$category->meta_title}}"/>
        <meta property="og:description" content="{{$category->meta_description}}"/>
        <meta property="og:image" content="{{asset($category->meta_image)}}"/>

        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="summary_large_image"/>
        <meta name="twitter:title" content="{{$category->meta_title}}"/>
        <meta name="twitter:description" content="{{$category->meta_description}}"/>
        <meta name="twitter:image" content="{{asset($category->meta_image)}}"/>

        <script type="application/ld+json">
            {!! $category->google_schema !!}
        </script>

    @endsection

    <style>
        #c-title {
            background: gainsboro;
            padding: 6px;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 4px;
        }

        .sidebar h5 {
            padding: 7px;
            border-bottom: 1px solid #efefef;
            margin: 0px;
        }

        .sidebar h5:hover {
            background: #efefef;
        }

        .sidebar h5 a {
            color: black;
            font-size: 16px;
        }

        .sidebar li a {
            color: black;
            padding-left: 10%;
        }

        .sidebar li a:hover {
            color: rgb(5, 49, 137);
        }

        .ct-active {
            color: rgb(5, 49, 137) !important;
        }
    </style>

    <main class="main">
        <div class="pt-3 page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-xl-4-5col">

                        <div class="toolbox">
                            <div class="toolbox-left">
                                <div class="toolbox-info">
                                    {{count($products)}} Products found
                                </div><!-- End .toolbox-info -->
                            </div><!-- End .toolbox-left -->
                        </div><!-- End .toolbox -->

                        <div class="mb-3 products">
                            <div class="row">
                                @forelse($products as $product)
                                    @if($product->productvariants->count() > 0)
                                        <div class="col-6 col-md-4 col-xl-3">
                                            @include('frontend.content.product.view',$product)
                                        </div><!-- End .col-sm-6 col-md-4 col-xl-3 -->
                                    @endif
                                @empty
                                @endforelse
                            </div><!-- End .row -->
                        </div><!-- End .products -->

                        {{ $products->links('pagination::bootstrap-4') }}

                    </div><!-- End .col-lg-9 -->

                    <aside class="col-lg-3 col-xl-5col order-lg-first">
                        <div class="sidebar sidebar-shop">
                            <div class="widget widget-categories">
                                <h3 class="widget-title" id="c-title">Categories</h3><!-- End .widget-title -->
                                <div class="widget-body">
                                    <div class="accordion" id="widget-cat-acc">
                                        @forelse($categories as $ind=>$cate)
                                            <div class="acc-item">
                                                <h5>
                                                    <a @if($cate->id == $category->id) class="ct-active"
                                                       @endif role="button" data-toggle="collapse"
                                                       href="#collapse-{{$ind}}"
                                                       aria-expanded="true" aria-controls="collapse-{{$ind}}">
                                                        {{$cate->name}}
                                                    </a>
                                                </h5>
                                                <div id="collapse-{{$ind}}"
                                                     class="collapse @if($cate->id == $category->id) show @endif"
                                                     data-parent="#widget-cat-acc">
                                                    <div class="collapse-wrap">
                                                        <ul class="mb-0">
                                                            @forelse($cate->subcategories as $subcate)
                                                                <li>
                                                                    <a href="{{url('subcategory',$subcate->slug)}}">{{$subcate->name}}</a>
                                                                </li>
                                                            @empty
                                                            @endforelse
                                                        </ul>
                                                    </div><!-- End .collapse-wrap -->
                                                </div><!-- End .collapse -->
                                            </div><!-- End .acc-item -->
                                        @empty
                                        @endforelse
                                    </div><!-- End .accordion -->
                                </div><!-- End .widget-body -->
                            </div>


                            {{--                            <div class="widget widget-banner-sidebar">--}}
                            {{--                                <div class="banner-sidebar-title">ad banner 218 x 430px</div><!-- End .ad-title -->--}}

                            {{--                                <div class="banner-sidebar banner-overlay">--}}
                            {{--                                    <a href="#">--}}
                            {{--                                        <img--}}
                            {{--                                            src="{{asset('public/frontend/assets')}}/images/demos/demo-13/banners/banner-6.jpg"--}}
                            {{--                                            alt="banner">--}}
                            {{--                                    </a>--}}
                            {{--                                </div><!-- End .banner-ad -->--}}
                            {{--                            </div><!-- End .widget -->--}}
                        </div><!-- End .sidebar sidebar-shop -->
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .page-content -->


    </main><!-- End .main -->

@endsection
