@extends('frontend.master')


@section('meta')
    <!-- HTML Meta Tags -->
    <title>{{$page->meta_title ?? ''}}</title>
    <meta name="description" content="{{ $page->meta_description ?? ''}}"/>
    <meta name="keywords" content="{{ $page->meta_keywords ?? '' }}"/>

    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="{{ $page->meta_title ?? ''}}"/>
    <meta itemprop="description" content="{{ $page->meta_description ?? '' }}"/>
    <meta itemprop="image" content="{{ isset($page->meta_image) ? asset($page->meta_image) : '' }}"/>

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="{{ url('/') }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{ $page->meta_title?? '' }}"/>
    <meta property="og:description" content="{{ $page->meta_description?? '' }}"/>
    <meta property="og:image" content="{{ isset($page->meta_image) ? asset($page->meta_image) : '' }}"/>

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="{{ $page->meta_title ?? ''}}"/>
    <meta name="twitter:description" content="{{ $page->meta_description ?? ''}}"/>
    <meta name="twitter:image" content="{{ isset($page->meta_image) ? asset($page->meta_image) : ''}}"/>

    <script type="application/ld+json">
        {!! $page->google_schema ?? '' !!}
    </script>

@endsection

@section('maincontent')

    <style>
        {!! $page->custom_css ?? '' !!}
    </style>

    <div class="container">
        <div class="row">
            <div class="pt-4 pb-3 m-auto col-lg-6">
                <h4 class="text-center"><u>{{$page->title ?? ''}}</u></h4>
            </div>
            <div class="pb-4 mb-3 col-lg-12">
                {!!$page->content ?? ''!!}
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>

        {!!$page->custom_js ?? '' !!}

    </script>

@endsection
