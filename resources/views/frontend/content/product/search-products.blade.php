@extends('frontend.master')

@section('maincontent')

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
                    <div class="col-lg-12 col-xl-4-5col">

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

                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .page-content -->


    </main><!-- End .main -->

@endsection
