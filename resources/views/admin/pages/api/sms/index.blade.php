@extends('admin.layout.app')

@push('css')

@endpush


@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">SMS Gateway</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.sms.store') }}" method="POST" class="row" data-parsley-validate=""
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $Bulksmsbd->id }}">

                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="url" class="form-label">Url *</label>
                                    <input type="text" class="form-control @error('url') is-invalid @enderror"
                                           name="url" value="{{ $Bulksmsbd->url }}" id="url" required=""/>
                                    @error('url')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="api_key" class="form-label">API Key *</label>
                                    <input type="text" class="form-control @error('api_key') is-invalid @enderror"
                                           name="api_key" value="{{ $Bulksmsbd->api_key }}" id="api_key" required=""/>
                                    @error('api_key')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->


                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="senderID" class="form-label">Senderid *</label>
                                    <input type="text" class="form-control @error('senderID') is-invalid @enderror"
                                           name="senderID" value="{{ $Bulksmsbd->senderID }}" id="senderID"
                                           required=""/>
                                    @error('senderID')
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
                                        <option value="1" @if($Bulksmsbd->status == 1) selected @endif>Active</option>
                                        <option value="0" @if($Bulksmsbd->status == 0) selected @endif>Inactive</option>
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


    </div>
@endsection

@push('js')

@endpush
