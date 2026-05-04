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

        @media (min-width: 768px) and (max-width: 1900px) {
            .form-box
            {
                width: 600px !important;
            }
        }

    </style>
    <script type="application/ld+json">
        {!! $settings->google_schema ?? '' !!}
    </script>

@endsection

@section('maincontent')
    <div class="form-box my-3">
        <div class="form-tab">
            <ul class="nav nav-pills nav-fill nav-border-anim" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin"
                       role="tab" aria-controls="signin" aria-selected="true">Forget Password</a>
                </li>
            </ul>
            <div class="tab-content" id="tab-content-5">
                <div class="tab-pane fade show active" id="signin" role="tabpanel"
                     aria-labelledby="signin-tab">
                    <form action="{{route('password.store')}}" method="post">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="form-group">
                            <label >Email *</label>
                            <input type="text" class="form-control"
                                   name="email" value="{{ old('email',$request->email) }}" required>

                            <div class="my-1">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Password *</label>
                            <input type="password" class="form-control" name="password" required>

                            <div class="my-1">
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Confirm Password *</label>
                            <input type="password" class="form-control" name="password_confirmation" required>

                            <div class="my-1">
                                @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-outline-primary-2">
                                <span>Reset Password</span>
                                <i class="icon-long-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div><!-- .End .tab-pane -->
            </div><!-- End .tab-content -->
        </div><!-- End .form-tab -->
    </div><!-- End .form-box -->
@endsection
