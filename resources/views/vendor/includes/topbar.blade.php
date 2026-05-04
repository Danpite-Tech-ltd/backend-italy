<!-- partial:partials/_navbar.html -->
<nav class="flex-row p-0 navbar col-lg-12 col-12 fixed-top d-flex">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="{{ route('vendor.dashboard') }}"><img src="{{ asset($settings->dark_logo) }}" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="{{ route('vendor.dashboard') }}"><img src="{{ asset($settings->dark_logo) }}" alt="logo"/></a>
        <button class="navbar-toggler align-self-center d-none d-lg-flex" type="button" data-toggle="minimize">
            <span class="typcn typcn-th-menu"></span>
        </button>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">

        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="pl-0 pr-0 nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <i class="mr-0 typcn typcn-user-outline"></i>
                    <span class="nav-profile-name">{{ Auth::user()->name ?? '' }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{ route('vendor.profile') }}">
                        <i class="typcn typcn-cog text-primary"></i>
                        Change Profile
                    </a>
                    <form method="POST" action="{{ route('vendor.logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="typcn typcn-power text-primary"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="typcn typcn-th-menu"></span>
        </button>
    </div>
</nav>
<!-- partial -->
