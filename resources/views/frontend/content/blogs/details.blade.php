@extends('frontend.master')

@section('maincontent')
    @section('meta')
        <!-- HTML Meta Tags -->
        <title>{{$blog->meta_title}}</title>
        <meta name="description" content="{{$blog->meta_description}}"/>
        <meta name="keywords" content="{{$blog->meta_keywords}}"/>

        <!-- Google / Search Engine Tags -->
        <meta itemprop="name" content="{{$blog->meta_title}}"/>
        <meta itemprop="description" content="{{$blog->meta_description}}"/>
        <meta itemprop="image" content="{{asset($blog->meta_image)}}"/>

        <!-- Facebook Meta Tags -->
        <meta property="og:url" content="{{url('/')}}"/>
        <meta property="og:type" content="website"/>
        <meta property="og:title" content="{{$blog->meta_title}}"/>
        <meta property="og:description" content="{{$blog->meta_description}}"/>
        <meta property="og:image" content="{{asset($blog->meta_image)}}"/>

        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="summary_large_image"/>
        <meta name="twitter:title" content="{{$blog->meta_title}}"/>
        <meta name="twitter:description" content="{{$blog->meta_description}}"/>
        <meta name="twitter:image" content="{{asset($blog->meta_image)}}"/>

        <script type="application/ld+json">
            {!!$blog->google_schema!!}
        </script>

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

        h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6 {
            line-height: 30px;
            font-size: 22px !important;
        }

        .posts-list h4 {
            font-weight: 400;
            font-size: 1.4rem !important;
            line-height: 1.4;
            letter-spacing: 0;
            margin-bottom: 0;
        }
    </style>
    <main class="main">
        <div class="pt-2 page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
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
                                    {!!$blog->long_description!!}
                                </div><!-- End .entry-content -->
                            </div><!-- End .entry-body -->
                        </article><!-- End .entry -->
                    </div><!-- End .col-lg-9 -->

                    <aside class="col-lg-3">
                        <div class="sidebar">
                            <div class="widget widget-search">
                                <h3 class="widget-title">Search</h3><!-- End .widget-title -->

                                <form action="#">
                                    <label for="ws" class="sr-only">Search in blog</label>
                                    <input type="search" class="form-control" name="ws" id="ws"
                                           placeholder="Search in blog"
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
                                                    <img src="{{asset($random->image)}}" alt="post"
                                                         style="border-radius:4px;">
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

                            <div class="widget widget-banner-sidebar">
                                <div class="banner-sidebar-title">ad box 280 x 280</div><!-- End .ad-title -->

                                <div class="banner-sidebar banner-overlay">
                                    <a href="#">
                                        <img src="{{asset('public/frontend/assets')}}/images/blog/sidebar/banner.jpg"
                                             alt="banner">
                                    </a>
                                </div><!-- End .banner-ad -->
                            </div><!-- End .widget -->


                        </div><!-- End .sidebar -->
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->

@endsection
