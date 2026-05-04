@extends('frontend.master')

@section('maincontent')
    @section('meta')


    @endsection

    <div class="container">
        <h2 class="pt-4 mb-4 text-center title">Shop By Categories</h2><!-- End .title text-center -->

        <div class="pb-4 cat-blocks-container">
            <div class="row">
                @forelse($categories as $category)
                    <div class="col-6 col-sm-4 col-lg-2">
                        <a href="{{url('category',$category->slug)}}" class="cat-block">
                            <figure>
                                <span>
                                    <img src="{{asset($category->image)}}" alt="{{$category->name}}" style="    border-radius: 6px;">
                                </span>
                            </figure>

                            <h3 class="cat-block-title">{{$category->name}}</h3><!-- End .cat-block-title -->
                        </a>
                    </div><!-- End .col-sm-4 col-lg-2 -->
                @empty
                @endforelse
            </div><!-- End .row -->
        </div><!-- End .cat-blocks-container -->
    </div><!-- End .container -->

@endsection