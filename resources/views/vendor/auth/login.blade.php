<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vendor Login</title>
    <link rel="stylesheet" href="{{asset('public/admin')}}/vendors/typicons.font/font/typicons.css">
    <link rel="stylesheet" href="{{asset('public/admin')}}/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="{{asset('public/admin')}}/css/vertical-layout-light/style.css">
    {{-- toastr --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="px-0 content-wrapper d-flex align-items-center auth">
                <div class="mx-0 row w-100">
                    <div class="mx-auto col-lg-4">
                        <div class="px-4 py-5 text-left auth-form-light px-sm-5">
                           <center> <div class="brand-logo">
                                <img src="{{ asset($settings->dark_logo) }}" alt="logo">
                            </div>
                            <h4>Vendor Login!</h4></center>
                            {{-- <h6 class="font-weight-light">Sign in to continue.</h6> --}}
                            @if(session('wrong'))
                                <div class="alert alert-danger">{{ session('wrong') }}</div>
                            @endif
                            @if(session('exists'))
                                <div class="alert alert-danger">{{ session('exists') }}</div>
                            @endif
                            <form class="pt-3" method="POST" action="{{route('vendor.login.submit')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 col-12">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-lg" name="email"
                                                id="email" placeholder="Email *" value="{{ old('email') }}" required>
                                            <div class="mt-1">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-12">
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-lg" name="password"
                                                id="password" placeholder="Password" required>
                                            <div class="mt-1">
                                                @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                        type="submit">Vendor Login
                                    </button>
                                </div>
                            </form>

                            <div class="mt-4 text-center font-weight-light">
                                Don't have an account? <a href="{{ route('vendor.register') }}" class="text-primary">Register</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <style>
        .auth form .form-group .form-control,
        .auth form .form-group .select2-container--default .select2-selection--single,
        .select2-container--default .auth form .form-group .select2-selection--single,
        .auth form .form-group .select2-container--default .select2-selection--single .select2-search__field,
        .select2-container--default .select2-selection--single .auth form .form-group .select2-search__field,
        .auth form .form-group .typeahead,
        .auth form .form-group .tt-query,
        .auth form .form-group .tt-hint {
            height: 50px;
            border: 1px solid #ddd;
        }
    </style>
    <!-- container-scroller -->
    <!-- base:js -->
    <script src="{{asset('public/admin')}}/vendors/js/vendor.bundle.base.js"></script>
    {{--toastr.js--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


</body>

</html>
