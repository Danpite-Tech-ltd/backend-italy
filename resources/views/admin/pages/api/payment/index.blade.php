@extends('admin.layout.app')

@push('css')

@endpush

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Bkash</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.payment.store')}}" method="POST" class="row" data-parsley-validate="" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id" value="{{ $bkash->id }}">
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="username" class="form-label">User Name *</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $bkash->username}}" id="username" required="" />
                                    @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="app_key" class="form-label">App Key *</label>
                                    <input type="text" class="form-control @error('app_key') is-invalid @enderror" name="app_key" value="{{ $bkash->app_key }}" id="app_key" required="" />
                                    @error('app_key')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->

                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="app_secret" class="form-label">App Secret *</label>
                                    <input type="text" class="form-control @error('app_secret') is-invalid @enderror" name="app_secret" value="{{ $bkash->app_secret }}" id="app_secret" required="" />
                                    @error('app_secret')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="base_url" class="form-label">Base Url *</label>
                                    <input type="text" class="form-control @error('base_url') is-invalid @enderror" name="base_url" value="{{ $bkash->base_url }}" id="base_url" required="" />
                                    @error('base_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">Password *</label>
                                    <input type="text" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ $bkash->password }}" id="password" required="" />
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-3 mb-3">
                                <div class="form-group">
                                    <label for="status" class="d-block">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" @if($bkash->status == 1) selected @endif>Active</option>
                                        <option value="0" @if($bkash->status == 0) selected @endif>Inactive</option>
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->

                            <div>
                                <input type="submit" class="btn btn-success" value="Submit" />
                            </div>
                        </form>
                    </div>
                    <!-- end card-body-->
                </div>
                <!-- end card-->
            </div>
            <!-- end col-->
        </div>
        <!-------------new-start------------>
        <!-- start page title -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">SSLCOMMERZ</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.payment.store')}}" method="POST" class="row" data-parsley-validate="" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $sslcommerz->id}}">
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="store_id" class="form-label">Store Id *</label>
                                    <input type="text" class="form-control @error('store_id') is-invalid @enderror" name="store_id" value="{{ $sslcommerz->store_id ?? ''}}" id="store_id" required="" />
                                    @error('store_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="store_password" class="form-label">Store Password*</label>
                                    <input type="text" class="form-control @error('store_password') is-invalid @enderror" name="store_password" value="{{ $sslcommerz->store_password ?? ''}}" id="store_password" required="" />
                                    @error('store_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->

                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="success_url" class="form-label">Success Url *</label>
                                    <input type="text" class="form-control @error('success_url') is-invalid @enderror" name="success_url" value="{{ $sslcommerz->success_url}}" id="success_url" required="" />
                                    @error('success_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="return_url" class="form-label">Return Url *</label>
                                    <input type="text" class="form-control @error('return_url') is-invalid @enderror" name="return_url" value="{{ $sslcommerz->return_url}}" id="return_url" required="" />
                                    @error('return_url')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="base_url" class="form-label">Base Url *</label>
                                    <input type="text" class="form-control @error('base_url') is-invalid @enderror" name="base_url" value="{{ $sslcommerz->base_url}}" id="base_url" required="" />
                                    @error('base_url')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- col-end -->
                            <div class="col-sm-3 mb-3">
                                <div class="form-group">
                                    <label for="status" class="d-block">Status</label>
                                   <select name="status" id="status" class="form-control">
                                        <option value="1" @if($sslcommerz->status == 1) selected @endif>Active</option>
                                        <option value="0" @if($sslcommerz->status == 0) selected @endif>Inactive</option>
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->

                            <div>
                                <input type="submit" class="btn btn-primary" value="Submit" />
                            </div>
                        </form>
                    </div>
                    <!-- end card-body-->
                </div>
                <!-- end card-->
            </div>
            <!-- end col-->
        </div>

    </div>


@endsection


@push('js')
@endpush
