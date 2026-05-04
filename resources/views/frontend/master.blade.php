<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="canonical" href="{{ url()->current() }}"/>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset($settings->fav_icon)}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset($settings->fav_icon)}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset($settings->fav_icon)}}">
    <link rel="shortcut icon" href="{{asset($settings->fav_icon)}}">

    <!-- Theame Meta -->
    @yield('meta')

    <meta name="apple-mobile-web-app-title" content="{{ env('APP_NAME') }}">
    <meta name="application-name" content="{{env('APP_NAME')}}">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet"
          href="{{asset('public/frontend/assets')}}/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{asset('public/frontend/assets')}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('public/frontend/assets')}}/css/plugins/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="{{asset('public/frontend/assets')}}/css/plugins/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="{{asset('public/frontend/assets')}}/css/plugins/jquery.countdown.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{asset('public/frontend/assets')}}/css/style.css">
    <link rel="stylesheet" href="{{asset('public/frontend/assets')}}/css/skins/skin-demo-4.css">
    <link rel="stylesheet" href="{{asset('public/frontend/assets')}}/css/demos/demo-4.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">


    {{--  toastr.css  --}}
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @isset($gtmCode)
        <!-- Google Tag Manager -->
        <script>
            (function (w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start':
                        new Date().getTime(), event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', '{{ $gtmCode }}');
        </script>
        <!-- End Google Tag Manager -->
    @endisset

    @isset($pixelCode)
        <script>
            !function (f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function () {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');

            fbq('init', '{{ $pixelCode }}'); // Pass your Pixel ID here
            fbq('track', 'PageView');
        </script>
    @endisset

</head>

<body>
@isset($gtmCode)
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmCode }}"
                height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
@endisset

@isset($pixelCode)
    <noscript>
        <img height="1" width="1" style="display:none"
             src="https://www.facebook.com/tr?id={{ $pixelCode }}&ev=PageView&noscript=1"/>
    </noscript>
@endisset

<!-- End Google Tag Manager (noscript) -->

<div class="page-wrapper">

    @include('frontend.includes.header')

    @yield('maincontent')

    @include('frontend.includes.footer')

</div>

<script>

    //Wishlist
    $(document).on("click", ".add-to-wishlist", function (e) {
        e.preventDefault();

        let product_id = $(this).data("id");
        let self = $(this);

        $.ajax({
            url: "{{ url('add-to-wishlist') }}",
            method: "GET",
            data: { product_id: product_id },
            success: function (response) {
                $('#wishlistcount').html(response.item);

                // Target <svg> since FA replaces <i> with SVG
                let icon = self.find('svg');

                if (response.action === 'added') {
                    icon.attr('data-prefix', 'fas'); // Solid style
                    icon.find('path').css('fill', 'red'); // Change color
                    toastr.success('Product added to wishlist');
                } else {
                    icon.attr('data-prefix', 'far'); // Regular style
                    icon.find('path').css('fill', 'currentColor'); // Reset to default
                    toastr.success('Product removed from wishlist');
                }
            },
            error: function () {
                alert("Something went wrong, try again.");
            }
        });
    });

    function loadcart() {
        $.ajax({
            url: "{{ route('loadcart') }}",
            type: "GET",
            success: function (response) {
                $('#hovecart').empty().append(response);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });

    }

    function removecart(id) {
        $.ajax({
            url: "{{ route('remove-cart') }}",
            type: "GET",
            data: {
                cart_id: id
            },
            success: function (response) {
                loadcart();
                $('.cart-count').html(response.count);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });

    }

    function removefronlist(id) {
        $.ajax({
            url: "{{ route('remove-cart') }}",
            type: "GET",
            data: {
                cart_id: id
            },
            success: function (response) {
                loadlist();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });

    }

    function loadlist() {
        $.ajax({
            url: "{{ route('loadlist') }}",
            type: "GET",
            success: function (response) {
                $('#loadlist').empty().append(response);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });

    }

</script>

<script src="{{asset('public/frontend/assets')}}/js/jquery.min.js"></script>
<script src="{{asset('public/frontend/assets')}}/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('public/frontend/assets')}}/js/jquery.hoverIntent.min.js"></script>
<script src="{{asset('public/frontend/assets')}}/js/jquery.waypoints.min.js"></script>
<script src="{{asset('public/frontend/assets')}}/js/superfish.min.js"></script>
<script src="{{asset('public/frontend/assets')}}/js/owl.carousel.min.js"></script>
<script src="{{asset('public/frontend/assets')}}/js/bootstrap-input-spinner.js"></script>
<script src="{{asset('public/frontend/assets')}}/js/jquery.plugin.min.js"></script>
<script src="{{asset('public/frontend/assets')}}/js/jquery.magnific-popup.min.js"></script>
<script src="{{asset('public/frontend/assets')}}/js/jquery.countdown.min.js"></script>
<!-- Main JS File -->
<script src="{{asset('public/frontend/assets')}}/js/main.js"></script>
<script src="{{asset('public/frontend/assets')}}/js/demos/demo-4.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"
        integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


{{--toastr.js--}}
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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

{{--  Login Form Submit--}}
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('#loginForm').on('submit', function (e) {
        console.log('form submitted');
        e.preventDefault(); // stop default form submission

        $.ajax({
            url: "{{ url('/login') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function (res) {
                toastr.success(res.message);
                if (res.redirect) {
                    window.location.href = "{{ route('dashboard') }}";
                }
            },
            error: function (xhr) {
                let res = xhr.responseJSON;
                toastr.error(res?.message || 'Something went wrong');

            }
        });
    });

    //Register on click
    $('#registerForm').on('submit', function (e) {
        e.preventDefault(); // stop default form submission

        $.ajax({
            url: "{{ url('/register') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function (res) {
                toastr.success(res.message);
                if (res.redirect) {
                    window.location.href = "{{ route('dashboard') }}";
                }
            },
            error: function (xhr) {
                let errors = xhr.responseJSON?.errors;
                if (errors) {
                    $.each(errors, function (key, value) {
                        toastr.error(value[0]); // display first error
                    });
                } else {
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong');
                }
            }
        });
    });
</script>

{{--Mobile Menu--}}
<script>

    $('.close-btn').on('click', function (e) {
        $('.sidebar-navigation').animate({
            width: '0',       // shrink width to 0
            opacity: 0        // fade out
        }, 300, function () {   // duration 300ms
            $(this).addClass('d-none');  // hide completely after animation
            $(this).css({width: '', opacity: ''}); // reset for next open
        });
    })

    $('#mobile-menu-toggler2').on('click', function (e) {

        e.preventDefault();
        $('.sidebar-navigation').removeClass('d-none');
    });
</script>

@yield('js')
</body>

</html>
