<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login</title>
    <link rel="stylesheet" href="{{asset('public/admin')}}/vendors/typicons.font/font/typicons.css">
    <link rel="stylesheet" href="{{asset('public/admin')}}/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="{{asset('public/admin')}}/css/vertical-layout-light/style.css">
    {{--  toastr  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="px-0 content-wrapper d-flex align-items-center auth">
            <div class="mx-0 row w-100">
                <div class="mx-auto col-lg-4">
                    <div class="px-4 py-5 text-left auth-form-light px-sm-5">
                        <div class="brand-logo">
                            <img src="{{ asset($settings->dark_logo) }}" alt="logo">
                        </div>
                        <h4>Hello! let's get started</h4>
                        <h6 class="font-weight-light">Sign in to continue.</h6>
                        <form class="pt-3" method="POST" action="{{route('admin.login')}}">
                            @csrf
                            <div class="form-group">
                                <input type="email" class="form-control form-control-lg" name="email" id="email"
                                       placeholder="Email" value="{{ old('email') }}" required>
                                <div class="mt-1">
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-lg" name="password"
                                       id="password" placeholder="Password" required>
                                <div class="mt-1">
                                    @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                        type="submit">SIGN IN
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- base:js -->
<script src="{{asset('public/admin')}}/vendors/js/vendor.bundle.base.js"></script>
{{--toastr.js--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    @if (Session::has('success'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.success("{{ session('success') }}");
    @endif

        @if (Session::has('error'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.error("{{ session('error') }}");
    @endif

        @if (Session::has('info'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.info("{{ session('info') }}");
    @endif

        @if (Session::has('warning'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.warning("{{ session('warning') }}");
    @endif
</script>
{!! Toastr::message() !!}

</body>

</html>
