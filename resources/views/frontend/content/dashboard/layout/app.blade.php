<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
          rel="stylesheet">
    <style>
        :root {
            --primary-color: #0066cc;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --sidebar-bg: #f8f9fa;
            --sidebar-hover: #e9ecef;
            --text-dark: #2c3e50;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }

        .page-wrapper {
            min-height: 100vh;
        }

        .sidebar-desktop {
            background: var(--sidebar-bg);
            min-height: 100vh;
            border-right: 1px solid #dee2e6;
        }

        .sidebar-brand {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid #dee2e6;
            background: white;
        }

        .sidebar-brand h4 {
            color: var(--primary-color);
            font-weight: 600;
            margin: 0;
        }

        .nav-link-custom {
            border: none !important;
            border-radius: 0;
            padding: 1rem 1.5rem;
            color: var(--text-dark);
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link-custom:hover {
            background-color: var(--sidebar-hover);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .nav-link-custom.active {
            background-color: var(--primary-color);
            color: white;
            border-left: 4px solid #004499;
        }

        .nav-link-custom i {
            width: 20px;
            font-size: 1.1rem;
        }

        .main-content {
            background: white;
            border-radius: 15px;
            margin: 20px;
            padding: 0;
            overflow: hidden;
        }

        .content-header {
            background: linear-gradient(135deg, var(--primary-color), #0052a3);
            color: white;
            padding: 2rem;
            position: relative;
        }

        .content-header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            right: 0;
            height: 20px;
            background: white;
            border-radius: 20px 20px 0 0;
        }

        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-left: 4px solid var(--primary-color);
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .bg-primary-gradient {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .bg-success-gradient {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
        }

        .bg-warning-gradient {
            background: linear-gradient(135deg, #fa709a, #fee140);
        }

        .bg-info-gradient {
            background: linear-gradient(135deg, #a8edea, #fed6e3);
        }

        .recent-activity {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .activity-item {
            padding: 1rem 0;
            border-bottom: 1px solid #f1f3f4;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        .mobile-header {
            background: var(--primary-color);
            color: white;
            padding: 1rem;
        }

        @media (max-width: 991.98px) {
            .page-wrapper {
                background: white;
            }

            .main-content {
                margin: 0;
                border-radius: 0;
                box-shadow: none;
            }

            .content-header {
                border-radius: 0;
            }
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color), #0052a3);
            border: none;
            border-radius: 25px;
            padding: 0.75rem 2rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 102, 204, 0.4);
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
          integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    @stack('css')


</head>
@php $user = Auth::user(); @endphp

<body>
<div class="page-wrapper">
    <!-- Mobile Header -->
    <div class="d-lg-none mobile-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <a href="" class="text-decoration-none text-white">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            </h5>
            <button class="btn btn-outline-light btn-sm" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#mobileSidebar">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Sidebar -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">
        <div class="offcanvas-header bg-primary text-white">
            <h5 class="offcanvas-title"><i class="bi bi-speedometer2 me-2"></i>Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body p-0">
            <div class="list-group list-group-flush">
                <a href="{{ route('dashboard') }}"
                   class="list-group-item list-group-item-action nav-link-custom active">
                    <i class="bi bi-speedometer2 me-3"></i> Dashboard
                </a>

                @role('affiliate')
                @if($user->status == 1)
                    <a href="{{ route('affiliate-shop') }}"
                       class="list-group-item list-group-item-action nav-link-custom">
                        <i class="bi bi-speedometer2 me-3"></i> Shop
                    </a>

                    <a href="{{ route('pos-order') }}"
                       class="list-group-item list-group-item-action nav-link-custom">
                        <i class="bi bi-cart me-3"></i> POS Order
                    </a>

                    <a href="{{ route('affiliate-withdrawal-page') }}"
                       class="list-group-item list-group-item-action nav-link-custom">
                        <i class="bi bi-cart me-3"></i> Withdraw
                    </a>


                @endif
                @endrole

                @role('user')
                <a href="{{ route('user-orders') }}" class="list-group-item list-group-item-action nav-link-custom">
                    <i class="bi bi-cart me-3"></i> Orders
                </a>
                <a href="{{ route('user-wishlist') }}" class="list-group-item list-group-item-action nav-link-custom">
                    <i class="bi bi-heart me-3"></i> Wishlist
                </a>
                @endrole

                <a href="{{ route('user-profile') }}" class="list-group-item list-group-item-action nav-link-custom">
                    <i class="bi bi-person me-3"></i> Profile
                </a>
                <a href="{{ route('user-settings') }}" class="list-group-item list-group-item-action nav-link-custom">
                    <i class="bi bi-gear me-3"></i> Settings
                </a>
            </div>
            <!-- ✅ Logout fixed at bottom -->
            <div class="mt-auto">
                <a href="javascript:void(0)"
                   class="list-group-item list-group-item-action nav-link-custom text-danger logoutBtn">
                    <i class="bi bi-box-arrow-right me-3"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Desktop Sidebar -->
            <div class="col-lg-3 col-xl-2 d-none d-lg-block">
                <div class="sidebar-desktop">
                    <div class="sidebar-brand">
                        <h4>
                            {{--                            <a href="" class="text-decoration-none">--}}
                            {{--                                <i class="bi bi-speedometer2 me-2"></i>Dashboard--}}
                            <a href="{{ route('home') }}" class="logo">
                                <img src="{{ asset($settings->dark_logo) }}" alt="logo" width="150" height="60">
                            </a>
                            {{--                            </a>--}}
                        </h4>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('dashboard') }}"
                           class="list-group-item list-group-item-action nav-link-custom @if(Route::currentRouteName() == 'dashboard') active @endif">
                            <i class="bi bi-speedometer2 me-3"></i> Dashboard
                        </a>

                        @role('affiliate')
                        @if($user->status == 1)
                            <a href="{{ route('affiliate-shop') }}"
                               class="list-group-item list-group-item-action nav-link-custom @if(Route::currentRouteName() == 'affiliate-shop') active @endif">
                                <i class="bi bi-speedometer2 me-3"></i> Shop
                            </a>

                            <a href="{{ route('pos-order') }}"
                               class="list-group-item list-group-item-action nav-link-custom @if(Route::currentRouteName() == 'pos-order') active @endif">
                                <i class="bi bi-cart me-3"></i> POS Order
                            </a>

                            <a href="{{ route('affiliate-withdrawal-page') }}"
                               class="list-group-item list-group-item-action nav-link-custom @if(Route::currentRouteName() == 'affiliate-withdrawal-page') active @endif">
                                <i class="bi bi-cash me-3"></i> Withdraw
                            </a>
                        @endif
                        @endrole

                        @role('user')
                        <a href="{{ route('user-orders') }}"
                           class="list-group-item list-group-item-action nav-link-custom @if(Route::currentRouteName() == 'user-orders') active @endif">
                            <i class="bi bi-cart me-3"></i> Orders
                        </a>

                        <a href="{{ route('user-wishlist') }}"
                           class="list-group-item list-group-item-action nav-link-custom @if(Route::currentRouteName() == 'user-wishlist') active @endif">
                            <i class="bi bi-heart me-3"></i> Wishlist
                        </a>
                        @endrole

                        <a href="{{ route('user-profile') }}"
                           class="list-group-item list-group-item-action nav-link-custom @if(Route::currentRouteName() == 'user-profile') active @endif">
                            <i class="bi bi-person me-3"></i> Profile
                        </a>
                        <a href="{{ route('user-settings') }}"
                           class="list-group-item list-group-item-action nav-link-custom @if(Route::currentRouteName() == 'user-settings') active @endif">
                            <i class="bi bi-gear me-3"></i> Settings
                        </a>
                    </div>
                    <!-- ✅ Logout fixed at bottom -->
                    <div class="mt-auto">
                        <a href="javascript:void(0)"
                           class="list-group-item list-group-item-action nav-link-custom text-danger logoutBtn">
                            <i class="bi bi-box-arrow-right me-3"></i> Logout
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9 col-xl-10">
                @yield('content')

            </div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"
        integrity="sha512-2bMhOkE/ACz21dJT8zBOMgMecNxx0d37NND803ExktKiKdSzdwn+L7i9fdccw/3V06gM/DBWKbYmQvKMdAA9Nw=="
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

<script>
    // Add smooth scrolling and interactive effects
    document.addEventListener('DOMContentLoaded', function () {
        // Add hover effects to cards
        const statsCards = document.querySelectorAll('.stats-card');
        statsCards.forEach(card => {
            card.addEventListener('mouseenter', function () {
                this.style.transform = 'translateY(-8px)';
            });

            card.addEventListener('mouseleave', function () {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>

<script>
    $(document).on('click', '.logoutBtn', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Logout'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('logout') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function () {
                        Swal.fire({
                            icon: 'success',
                            title: 'Logged out!',
                            text: 'You have been logged out successfully.',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        // redirect after logout
                        setTimeout(function () {
                            window.location.href = "{{ url('/') }}";
                        }, 1500);
                    },
                    error: function () {
                        Swal.fire(
                            'Error!',
                            'Something went wrong while logging out.',
                            'error'
                        );
                    }
                });
            }
        });
    });
</script>


@stack('js')
</body>

</html>
