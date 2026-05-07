@php
    $currentRouteName = Route::currentRouteName();
@endphp

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <div class="d-flex sidebar-profile">
                <div class="sidebar-profile-image">
                    @if (Auth::guard('vendor')->user() && Auth::guard('vendor')->user()->profile_image)
                        <img src="{{ asset(Auth::guard('vendor')->user()->profile_image) }}" alt="image">
                    @else
                        <img src="{{ asset('public/admin') }}/images/faces/man.png" alt="image">
                    @endif

                    {{-- <img src="{{ asset('public/admin') }}/images/faces/man.png" alt="image"> --}}

                    <span class="sidebar-status-indicator"></span>
                </div>
                <div class="sidebar-profile-name">
                    <p class="sidebar-name">
                        {{ Auth::guard('vendor')->user()->first_name . ' ' . Auth::guard('vendor')->user()->last_name ?? '' }}
                    </p>
                    <p class="sidebar-designation">
                        Welcome Vendor
                    </p>
                </div>
            </div>
            {{-- <div class="nav-search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Type to search..." aria-label="search"
                        aria-describedby="search">
                    <div class="input-group-append">
                        <span class="input-group-text" id="search">
                            <i class="typcn typcn-zoom"></i>
                        </span>
                    </div>
                </div>
            </div>
            <p class="sidebar-menu-title">Dash menu</p> --}}
        </li>

        {{-- Dashboard --}}
        <li class="nav-item @if ($currentRouteName == 'vendor.dashboard') active @endif">
            <a class="nav-link" href="{{ route('vendor.dashboard') }}">
                <i class="typcn typcn-home menu-icon"></i>
                <span class="menu-title">Dashboard </span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="typcn typcn-user menu-icon"></i>
                <span class="menu-title">Vendor Profile</span>
                <i class="typcn typcn-chevron-right menu-arrow"></i>
            </a>

            <div class="collapse @if (request()->routeIs('vendor.profile')) show @endif" id="ui-basic">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item"><a class="nav-link @if ($currentRouteName == 'vendor.profile') active @endif"
                            href="{{ route('vendor.profile') }}">Change Profile</a></li>

                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-bank" aria-expanded="false" aria-controls="ui-basic">
                <i class="typcn typcn-user menu-icon"></i>
                <span class="menu-title">Withdraws</span>
                <i class="typcn typcn-chevron-right menu-arrow"></i>
            </a>

            <div class="collapse @if (request()->routeIs('vendor.bank.index', 'vendor.bank.withdraw')) show @endif" id="ui-bank">
                <ul class="nav flex-column sub-menu">


                    <li class="nav-item"><a class="nav-link @if ($currentRouteName == 'vendor.bank.index') active @endif"
                            href="{{ route('vendor.bank.index') }}">Bank Setup</a></li>


                    {{-- <li class="nav-item"><a class="nav-link @if ($currentRouteName == 'vendor.bank.withdraw') active @endif" href="{{ route('vendor.bank.withdraw') }}">Request Withdrawls</a></li> --}}

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('vendor.bank.withdraw') ? 'active' : '' }}"
                            href="{{ route('vendor.bank.withdraw') }}">
                            Request Withdrawals
                        </a>
                    </li>




                    <li class="nav-item"><a class="nav-link @if ($currentRouteName == 'vendor.profile') active @endif"
                            href="">Withdrawls List</a></li>

                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#product-manage" aria-expanded="false"
                aria-controls="ui-basic">
                <i class="typcn typcn-device-desktop menu-icon"></i>
                <span class="menu-title">Poduct Management</span>
                <i class="typcn typcn-chevron-right menu-arrow"></i>
            </a>

            <div class="collapse @if (request()->routeIs('vendor.product.*')) show @endif" id="product-manage">
                <ul class="nav flex-column sub-menu">


                    <li class="nav-item"><a class="nav-link @if ($currentRouteName == 'vendor.product.index') active @endif"
                            href="{{ route('vendor.product.index') }}">Product List</a></li>
                    <li class="nav-item"><a class="nav-link @if ($currentRouteName == 'vendor.product.create') active @endif"
                            href="{{ route('vendor.product.create') }}">Product Create</a></li>
                    <li class="nav-item"><a class="nav-link @if ($currentRouteName == 'vendor.pending-products') active @endif"
                            href="{{ route('vendor.pending-products') }}">Pending Product List</a></li>



                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#inventory-manage" aria-expanded="false"
                aria-controls="ui-basic">
                <i class="typcn typcn-archive menu-icon"></i>
                <span class="menu-title">Inventory Management</span>
                <i class="typcn typcn-chevron-right menu-arrow"></i>
            </a>

            <div class="collapse @if (request()->routeIs('vendor.purchase.*', 'vendor.supplier.*', 'vendor.inventory.*')) show @endif" id="inventory-manage">
                <ul class="nav flex-column sub-menu">


                    <li class="nav-item"><a class="nav-link @if ($currentRouteName == 'vendor.supplier.index') active @endif"
                            href="{{ route('vendor.supplier.index') }}">Supplier</a></li>
                    <li class="nav-item"><a class="nav-link @if ($currentRouteName == 'vendor.purchase.index') active @endif"
                            href="{{ route('vendor.purchase.index') }}">Purchase</a></li>
                    <li class="nav-item"><a class="nav-link @if ($currentRouteName == 'vendor.purchase.create') active @endif"
                            href="{{ route('vendor.purchase.create') }}">Add Purchase</a></li>
                    <li class="nav-item"><a class="nav-link @if ($currentRouteName == 'vendor.inventory.index') active @endif"
                            href="{{ route('vendor.inventory.index') }}">Inventory</a></li>





                </ul>
            </div>
        </li>

        <li class="nav-item @if (request()->routeIs('vendor.order.*')) active @endif">
            <a class="nav-link" data-toggle="collapse" href="#order" aria-expanded="false" aria-controls="order">
                <i class="typcn typcn-shopping-cart menu-icon"></i>
                <span class="menu-title">Order Management</span>
                <i class="typcn typcn-chevron-right menu-arrow"></i>
            </a>

            <div class="collapse @if (request()->routeIs('vendor.order.*')) show @endif" id="order">
                <ul class="nav flex-column sub-menu">


                    <li class="nav-item"><a class="nav-link @if ($currentRouteName == 'vendor.order.index') active @endif"
                            href="{{ route('vendor.order.index') }}">Orders</a></li>


                </ul>
            </div>
        </li>
        <li class="nav-item @if (request()->routeIs('vendor.sales-reports.*')) active @endif">
            <a class="nav-link" data-toggle="collapse" href="#reports" aria-expanded="false" aria-controls="reports">
                <i class="typcn typcn-shopping-cart menu-icon"></i>
                <span class="menu-title">Reports</span>
                <i class="typcn typcn-chevron-right menu-arrow"></i>
            </a>

            <div class="collapse @if (request()->routeIs('vendor.sales-reports.*')) show @endif" id="reports">
                <ul class="nav flex-column sub-menu">


                    <li class="nav-item"><a class="nav-link @if ($currentRouteName == 'vendor.sales-reports.index') active @endif"
                            href="{{ route('vendor.sales-reports.index') }}">Sales Report</a></li>


                </ul>
            </div>
        </li>

    </ul>

</nav>
<!-- partial -->
