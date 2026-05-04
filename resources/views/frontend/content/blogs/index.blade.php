@extends('frontend.master')

@section('maincontent')
    @section('meta')

    @endsection
    <style>
        .entry-media {
            position: relative;
            background-color: #ccc;
            margin-bottom: 2.4rem;
            border-radius: 20px;
        }
        .entry-media img {
            display: block;
            max-width: none;
            width: 100%;
            height: auto;
            border-radius: 20px;
        }
    </style>
    <main class="main">
        <div class="pt-2 page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        @forelse($blogs as $blog)
                            <article class="entry">
                                <figure class="entry-media entry-video">
                                    <a href="{{url('blog',$blog->slug)}}">
                                        <img src="{{asset($blog->image)}}" alt="{{$blog->title}}">
                                    </a>
                                </figure><!-- End .entry-media -->

                                <div class="entry-body">
                                    <div class="entry-meta">
                                        <span class="entry-author">
                                            by <a href="#">{{$blog->author}}</a>
                                        </span>
                                        <span class="meta-separator">|</span>
                                        <a href="#">{{$blog->published_date}}</a>
                                        <span class="meta-separator">|</span>
                                    </div><!-- End .entry-meta -->

                                    <h2 class="entry-title">
                                        <a href="{{url('blog',$blog->slug)}}">{{$blog->title}}</a>
                                    </h2><!-- End .entry-title -->

                                    <div class="entry-content">
                                        <p>{{$blog->short_description}}</p>
                                        <a href="{{url('blog',$blog->slug)}}" class="read-more">Continue Reading</a>
                                    </div><!-- End .entry-content -->
                                </div><!-- End .entry-body -->
                            </article><!-- End .entry -->
                        @empty
                        @endforelse

                        <nav aria-label="Page navigation">

                        </nav>
                    </div><!-- End .col-lg-9 -->

                    <aside class="col-lg-3">
                        <div class="sidebar">
                            <div class="widget widget-search">
                                <h3 class="widget-title">Search</h3><!-- End .widget-title -->

                                <form action="#">
                                    <label for="ws" class="sr-only">Search in blog</label>
                                    <input type="search" class="form-control" name="ws" id="ws" placeholder="Search in blog"
                                        required>
                                    <button type="submit" class="btn"><i class="icon-search"></i><span
                                            class="sr-only">Search</span></button>
                                </form>
                            </div><!-- End .widget -->



                            <div class="widget">
                                <h3 class="widget-title">Popular Posts</h3><!-- End .widget-title -->

                                <ul class="posts-list">
                                    @forelse($randoms as $random)
                                        <li>
                                            <figure>
                                                <a href="{{url('blog',$random->slug)}}">
                                                    <img src="{{asset($random->image)}}" alt="post" style="border-radius:4px;">
                                                </a>
                                            </figure>

                                            <div>
                                                <span>{{$random->published_date}}</span>
                                                <h4><a href="{{url('blog',$random->slug)}}">{{$random->title}}</a></h4>
                                            </div>
                                        </li>
                                    @empty
                                    @endforelse

                                </ul><!-- End .posts-list -->
                            </div><!-- End .widget -->

{{--                            <div class="widget widget-banner-sidebar">--}}
{{--                                <div class="banner-sidebar-title">ad box 280 x 280</div><!-- End .ad-title -->--}}

{{--                                <div class="banner-sidebar banner-overlay">--}}
{{--                                    <a href="#">--}}
{{--                                        <img src="{{asset('public/frontend/assets')}}/images/blog/sidebar/banner.jpg" alt="banner">--}}
{{--                                    </a>--}}
{{--                                </div><!-- End .banner-ad -->--}}
{{--                            </div><!-- End .widget -->--}}


                        </div><!-- End .sidebar -->
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->

@endsection
