@extends('admin.layout.app')

@push('css')

@endpush


@section('content')


    <div class="row">
        <div class="col-12">
            <div class="mb-4 page-title-box d-sm-flex align-items-center justify-content-between">
                <h3 class="mb-sm-0 font-size-18">Total</h3>
            </div>
        </div>
    </div>

    {{-- Overall Chart --}}

    <div class="row">
        <div class="mb-4 col-xl-3 col-md-6">
            <!-- card -->
            <div class="shadow card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="text-center rounded col-4">
                            <i class="fas fa-cart-plus h2"></i>
                        </div>

                        <div class="col-8">
                            <span class="mb-3 text-muted lh-1 d-block text-truncate">Orders</span>
                            <h4 class="mb-3">
                                <span class="">{{ $orderCount ?? 0 }}</span>
                            </h4>

                        </div>


                    </div>

                </div><!-- end card body -->
            </div>
        </div>
        <div class="mb-4 col-xl-3 col-md-6">
            <!-- card -->
            <div class="shadow card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="text-center rounded col-4">
                            <i class="fas fa-box-open h2"></i>
                        </div>

                        <div class="col-8">
                            <span class="mb-3 text-muted lh-1 d-block text-truncate">Products</span>
                            <h4 class="mb-3">
                                <span class="">{{ $productCount ?? 0 }}</span>
                            </h4>

                        </div>


                    </div>

                </div><!-- end card body -->
            </div>
        </div>
        <div class="mb-4 col-xl-3 col-md-6">
            <!-- card -->
            <div class="shadow card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="text-center rounded col-4">
                            <i class="fas fa-th-large h2"></i>
                        </div>

                        <div class="col-8">
                            <span class="mb-3 text-muted lh-1 d-block text-truncate">Categories</span>
                            <h4 class="mb-3">
                                <span class="">{{ $categoryCount ?? 0 }}</span>
                            </h4>

                        </div>


                    </div>

                </div><!-- end card body -->
            </div>
        </div>

        <div class="mb-4 col-xl-3 col-md-6">
            <!-- card -->
            <div class="shadow card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="text-center rounded col-4">
                            <i class="fas fa-certificate h2"></i>
                        </div>

                        <div class="col-8">
                            <span class="mb-3 text-muted lh-1 d-block text-truncate">Brands</span>
                            <h4 class="mb-3">
                                <span class="">{{ $brandCount ?? 0 }}</span>
                            </h4>

                        </div>


                    </div>

                </div><!-- end card body -->
            </div>
        </div>
    </div>

    {{-- Today --}}
    <div class="mt-4 row">
        <div class="col-12">
            <div class="mb-4 page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Today</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="mb-4 col-xl-3 col-md-6">
            <!-- card -->
            <div class="shadow card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="text-center rounded col-4">
                            <i class="fas fa-cart-plus h2"></i>
                        </div>

                        <div class="col-8">
                            <span class="mb-3 text-muted lh-1 d-block text-truncate">Orders</span>
                            <h4 class="mb-3">
                                <span class="">{{ $orderTodayCount ?? 0 }}</span>
                            </h4>
                        </div>
                    </div>

                </div><!-- end card body -->
            </div>
        </div>
        <div class="mb-4 col-xl-3 col-md-6">
            <!-- card -->
            <div class="shadow card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="text-center rounded col-4">
                            <i class="fas fa-box-open h2"></i>
                        </div>

                        <div class="col-8">
                            <span class="mb-3 text-muted lh-1 d-block text-truncate">Products</span>
                            <h4 class="mb-3">
                                <span class="">{{ $productTodayCount ?? 0 }}</span>
                            </h4>

                        </div>
                    </div>

                </div><!-- end card body -->
            </div>
        </div>
        <div class="mb-4 col-xl-3 col-md-6">
            <!-- card -->
            <div class="shadow card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="text-center rounded col-4">
                            <i class="fas fa-th-large h2"></i>
                        </div>

                        <div class="col-8">
                            <span class="mb-3 text-muted lh-1 d-block text-truncate">Categories</span>
                            <h4 class="mb-3">
                                <span class="">{{ $categoryTodayCount ?? 0 }}</span>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div>
        <div class="mb-4 col-xl-3 col-md-6">
            <!-- card -->
            <div class="shadow card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="text-center rounded col-4">
                            <i class="fas fa-certificate h2"></i>
                        </div>

                        <div class="col-8">
                            <span class="mb-3 text-muted lh-1 d-block text-truncate">Brand</span>
                            <h4 class="mb-3">
                                <span class="">{{ $brandTodayCount ?? 0 }}</span>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div>

    </div>


@endsection


@push('js')

@endpush
