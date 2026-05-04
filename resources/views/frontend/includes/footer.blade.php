<style>
    .social_media_link ul {
        padding: 0;
        margin: 0;
        list-style: none;
        display: flex;
    }

    .social_media_link ul li {
        width: 40px;
        height: 40px;
        background: #FFF;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50px;
        margin-right: 6px;
    }
    .social_media_link ul li a {
        color: #1065d6;
        line-height: inherit;
        text-decoration: none;
        width: 24px;
        height: 24px;
    }
    .basic_info a{

        text-decoration: none;
    }
</style>

<footer class="footer">
    <div class="pt-4 pb-5 mb-0 cta bg-image bg-dark"
        style="background-image: url('{{ asset($settings->newsletter_bgImage ?? 'public/frontend/assets/images/demos/demo-4/bg-5.jpg')   }}');">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-10 col-md-8 col-lg-6">
                    <div class="text-center cta-heading">
                        <h3 class="text-white cta-title">Get The Latest Deals</h3><!-- End .cta-title -->
                    </div><!-- End .text-center -->

                    <form action="{{ route('subscription') }}" method="POST">
                        @csrf
                        <div class="input-group input-group-round">
                            <input type="email" class="form-control form-control-white"
                                placeholder="Enter your Email Address" aria-label="Email Address" name="email" required>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <span>Subscribe</span>
                                    <i class="icon-long-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </form>
                </div><!-- End .col-sm-10 col-md-8 col-lg-6 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .cta -->
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="widget widget-about">
                        <img src="{{asset($settings->light_logo)}}" class="footer-logo" alt="Footer Logo" width="130"
                            height="25">
{{--                        <p style="    text-align: justify;">{{$settings->about_text}}  </p>--}}
                        <div class="basic_info mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa-solid fa-location-dot mx-3"></i>
                                <span>{{ $settings->address ?? '' }}</span>
                            </div>

                            <div class="d-flex align-items-center mb-2">
                                <i class="fa-solid fa-envelope mx-3"></i>
                                <a href="mailto:{{ $settings->mail ?? '' }}" class="text-decoration-none">
                                    {{ $settings->mail ?? '' }}
                                </a>
                            </div>

                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-phone mx-3"></i>
                                <a href="tel:{{ $settings->phone_1 ?? '' }}" class="text-decoration-none">
                                    {{ $settings->phone_1 ?? '' }}
                                </a>
                            </div>
                        </div>
                        <div class="social_media_link">
                            <ul>
                                <li>
                                    <a href="{{ $settings->fb_link ?? '' }}" target="_blank">
                                        <i class="fa-brands fa-facebook"></i>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ $settings->youtube_link ?? '' }}" target="_blank">
                                        <i class="fa-brands fa-youtube"></i>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ $settings->insta_link ?? '' }}" target="_blank">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ $settings->twitter_link ?? '' }}" target="_blank">
                                        <i class="fa-brands fa-twitter"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div><!-- End .widget about-widget -->
                </div><!-- End .col-sm-6 col-lg-3 -->

                <div class="col-sm-6 col-lg-3">
                    <div class="widget">
                        <h4 class="widget-title">Useful Links</h4><!-- End .widget-title -->

                        <ul class="widget-list">
                            @forelse($usefulls as $usefull)
                            <li><a href="{{url('page',$usefull->slug)}}">{{$usefull->title}}</a></li>
                            @empty
                            @endforelse
                        </ul><!-- End .widget-list -->
                    </div><!-- End .widget -->
                </div><!-- End .col-sm-6 col-lg-3 -->

                <div class="col-sm-6 col-lg-3">
                    <div class="widget">
                        <h4 class="widget-title">Customer Service</h4><!-- End .widget-title -->

                        <ul class="widget-list">
                            @forelse($services as $service)
                            <li><a href="{{url('page',$service->slug)}}">{{$service->title}}</a></li>
                            @empty
                            @endforelse
                        </ul><!-- End .widget-list -->
                    </div><!-- End .widget -->
                </div><!-- End .col-sm-6 col-lg-3 -->

                <div class="col-sm-6 col-lg-3">
                    <div class="widget">
                        <h4 class="widget-title">My Account</h4><!-- End .widget-title -->

                        <ul class="widget-list">
                            <li><a href="{{url('/')}}">Sign In</a></li>
                            <li><a href="{{url('view-cart')}}">View Cart</a></li>
                            <li><a href="{{url('wish-list')}}">My Wishlist</a></li>
                            <li><a href="{{url('track-order')}}">Track My Order</a></li>
                        </ul><!-- End .widget-list -->
                    </div><!-- End .widget -->
                </div><!-- End .col-sm-6 col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .footer-middle -->

    <div class="footer-bottom">
        <div class="container">
            <p class="footer-copyright">{{$settings->copyright_text}}</p>
            <!-- End .footer-copyright -->
            <figure class="footer-payments">
                <img src="{{asset('public/frontend/assets')}}/images/payments.png" alt="Payment methods" width="272" height="20">
            </figure><!-- End .footer-payments -->
        </div><!-- End .container -->
    </div><!-- End .footer-bottom -->
</footer><!-- End .footer -->
