@extends('frontend.content.dashboard.layout.app')

@push('css')


@endpush


@section('content')

    <div class="main-content">
        <!-- Content Header -->
        <div class="content-header">
            <h2 class="mb-0">Affiliate Shop</h2>
            <p class="mb-0">Your Shop Items</p>
        </div>

        <!-- Main Content Area -->
        <div class="p-4">
            <div class="section-content text-center">
                <div class="row mb-4 pb-4">
                    <div class="col-sm-6 col-xl-3 copy-link" data-link="{{ url('/') }}?ref={{ auth()->user()->ref_code }}"
                         style="cursor: pointer;">
                        <div class="stats-card" style="transform: translateY(0px);">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-primary me-3"><i class="bi bi-clipboard-check-fill"></i></div>
                                <div>
                                    <div class="text-muted">Website Base URL</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3 copy-link" data-link="{{ url('/shop-by-category') }}?ref={{ auth()->user()->ref_code }}"
                         style="cursor: pointer;" >
                        <div class="stats-card" style="transform: translateY(0px);">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-success me-3"><i class="bi bi-clipboard-check-fill"></i></div>
                                <div>
                                    <div class="text-muted">Website Category URL</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3 copy-link" data-link="{{ url('/recommendation') }}?ref={{ auth()->user()->ref_code }}"
                         style="cursor: pointer;">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-warning me-3"><i class="bi bi-clipboard-check-fill"></i></div>
                                <div>
                                    <div class="text-muted">Recommended Products URL</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Product Card 1 -->
                    @forelse($affiliateProducts as $product)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="product">
                                <figure class="product-media">
                                    <a href="{{ route('product-details',$product->product->slug) }}">
                                        <img src="{{ asset($product->product->thumbnail_img) }}" width="200"
                                             height="200" alt="Product image" class="product-image">
                                    </a>
                                </figure>
                                <div class="product-body">
                                    <div class="product-cat">
                                        <a class="text-decoration-none"
                                           href="javascript:void(0)">{{ $product->product->category->name ?? '' }}</a>
                                    </div>
                                    <h5 class="product-title">
                                        <a class="text-decoration-none"
                                           href="{{ route('product-details',$product->product->slug) }}">{{ $product->product->name ?? '' }}</a>
                                    </h5>
                                    <!-- Copy button -->
                                    <div class="copy-link"
                                         data-link="{{ route('product-details',$product->product->slug) }}?ref={{ auth()->user()->ref_code }}"
                                         style="cursor: pointer;">
                                        <i class="fa-regular fa-copy"></i>
                                        <span>Copy Link</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty
                    @endforelse

                </div>
            </div>
        </div>
    </div>

@endsection


@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.copy-link').forEach(function (el) {
                el.addEventListener('click', function () {
                    let link = this.getAttribute('data-link');

                    console.log('clicked');
                    navigator.clipboard.writeText(link).then(() => {
                        alert("Affiliate link copied: " + link);
                    }).catch(err => {
                        console.error('Failed to copy: ', err);
                    });
                });
            });
        });
    </script>

    <script>
        document.querySelectorAll('.copy-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const text = document.getElementById(targetId).innerText;

                navigator.clipboard.writeText(text).then(() => {
                    alert('Copied: ' + text);
                });
            });
        });
    </script>

@endpush

