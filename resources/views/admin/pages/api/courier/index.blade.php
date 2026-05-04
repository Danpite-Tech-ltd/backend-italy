@extends('admin.layout.app')

@push('css')
    <style>
        .increment_btn,
        .remove_btn {
            margin-top: -17px;
            margin-bottom: 10px;
        }
    </style>
    <link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('public/backEnd')}}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet"
          type="text/css"/>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Steadfast Courier</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.courier.store')}}" method="POST" class="row"
                              data-parsley-validate="" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$steadfast->id}}">
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="api_key" class="form-label">API key *</label>
                                    <input type="text" class="form-control @error('api_key') is-invalid @enderror"
                                           name="api_key" value="{{ $steadfast->api_key}}" id="api_key" required=""/>
                                    @error('api_key')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="secret_key" class="form-label">Secret key *</label>
                                    <input type="text" class="form-control @error('secret_key') is-invalid @enderror"
                                           name="secret_key" value="{{ $steadfast->secret_key }}" id="secret_key"
                                           required=""/>
                                    @error('secret_key')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->

                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="url" class="form-label">URL *</label>
                                    <input type="text" class="form-control @error('url') is-invalid @enderror"
                                           name="url" value="{{ $steadfast->url }}" id="url" required=""/>
                                    @error('url')
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
                                    <select name="status" class="form-control">
                                        <option value="1" @if($steadfast->status == 1) selected @endif>Active</option>
                                        <option value="0" @if($steadfast->status == 0) selected @endif>Inactive</option>
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
                                <input type="submit" class="btn btn-success" value="Submit"/>
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
                    <h4 class="page-title">Pathao Courier</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.courier.store')}}" method="POST" class="row" data-parsley-validate=""
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $pathao->id}}">
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="url" class="form-label">URL *</label>
                                    <input type="text" class="form-control @error('url') is-invalid @enderror"
                                           name="url" value="{{ $pathao->url}}" id="url" required=""/>
                                    @error('url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="token" class="form-label">Token *</label>
                                    <input type="text" class="form-control @error('token') is-invalid @enderror"
                                           name="token" value="{{ $pathao->token}}" id="token" required=""/>
                                    @error('token')
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
                                        <option value="1" @if($pathao->status == 1) selected @endif>Active</option>
                                        <option value="0" @if($pathao->status == 0) selected @endif>Inactive</option>
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
                                <input type="submit" class="btn btn-success" value="Submit"/>
                            </div>
                        </form>
                    </div>
                    <!-- end card-body-->
                </div>
                <!-- end card-->
            </div>
            <!-- end col-->
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">RedX Courier</h4>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.courier.store')}}" method="POST" class="row" data-parsley-validate=""
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $redX->id}}">
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="url" class="form-label">URL *</label>
                                    <input type="text" class="form-control @error('url') is-invalid @enderror"
                                           name="url" value="{{ $redX->url}}" id="url" required=""/>
                                    @error('url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="token" class="form-label">Token *</label>
                                    <input type="text" class="form-control @error('token') is-invalid @enderror"
                                           name="token" value="{{ $redX->token}}" id="token" required=""/>
                                    @error('token')
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
                                        <option value="1" @if($redX->status == 1) selected @endif>Active</option>
                                        <option value="0" @if($redX->status == 0) selected @endif>Inactive</option>
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
                                <input type="submit" class="btn btn-success" value="Submit"/>
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
