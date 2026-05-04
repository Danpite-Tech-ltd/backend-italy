<style>

    {{--  Sidebar Nav Starts --}}
   /*body {*/
    /*        margin: 0;*/
    /*        padding: 0;*/
    /*        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";*/
    /*        font-size: 14px;*/
    /*        line-height: 16px;*/
    /*        color: #2e2e2e;*/
    /*        background-color: #eee;*/
    /*    }*/

    .sidebar-navigation {
        -webkit-box-shadow: 3px 5px 10px 0px rgba(0, 0, 0, 0.16);
        -moz-box-shadow: 3px 5px 10px 0px rgba(0, 0, 0, 0.16);
        box-shadow: 3px 5px 10px 0px rgba(0, 0, 0, 0.16);
        position: fixed;
        z-index: 400;
        background-color: #fff;
        border-right: 1px solid #ccc;
        width: 256px;
        height: 100%;
        left: 0;
        top: 0;
        overflow-y: auto;
    }

    .sidebar-navigation .title-div {
        border-bottom: 1px solid #ccc;
    }

    .close-btn {
        cursor: pointer;
        font-size: 24px;
        color: #2e2e2e;
        float: right;
        padding: 16px;
    }

    .sidebar-navigation .title {
        display: block;
        font-size: 20px;
        line-height: 16px;
        background-color: #fff;
        align-items: center;
        font-weight: 600;
        padding: 16px;
        /*border-bottom: 1px solid #ccc;*/
    }

    .sidebar-navigation ul {
        margin: 0;
        padding: 0;
    }

    .sidebar-navigation ul li {
        display: block;
    }

    .sidebar-navigation ul li a {
        position: relative;
        display: block;
        padding: 8px 16px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        color: #2e2e2e;
        -webkit-transition: all 0.3s linear;
        -moz-transition: all 0.3s linear;
        -o-transition: all 0.3s linear;
        transition: all 0.3s linear;
    }

    .sidebar-navigation ul li a em {
        font-size: 24px;
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        padding: 5px;
        border-radius: 50%;
    }

    .sidebar-navigation ul li:hover > a,
    .sidebar-navigation ul li.selected > a {
        background-color: rgba(0, 0, 0, 0.06);
    }

    .sidebar-navigation ul li ul {
        display: none;
    }

    .sidebar-navigation ul li ul li {
        font-weight: 400;
    }

    .sidebar-navigation ul li ul.open {
        display: block;
    }

    .sidebar-navigation ul li ul li a {
        color: #6e7d83; /* darken(#ecf0f1, 60%) */
        border-color: rgba(255, 255, 255, 0.1);
        font-weight: 400;
    }

    .sidebar-navigation ul li ul li:hover > a,
    .sidebar-navigation ul li ul li.selected > a {
        background-color: #e6ebeb; /* darken(#ecf0f1, 2%) */
    }

    .sidebar-navigation ul li ul li.selected.selected--last > a {
        background-color: #95a5a6; /* darken(#ecf0f1, 30%) */
        color: #fff;
    }

    .sidebar-navigation ul li ul li.selected.selected--last > a:before {
        background-color: #fff;
    }

    /* Generated submenu colors */
    .subMenuColor1 {
        background-color: #f2f5f5;
    }

    /* lighten 5% */
    .subMenuColor2 {
        background-color: #f5f7f7;
    }

    .subMenuColor3 {
        background-color: #f7f9f9;
    }

    .subMenuColor4 {
        background-color: #fafcfc;
    }

    .subMenuColor5 {
        background-color: white;
    }

    .subMenuColor6 {
        background-color: white;
    }

    .subMenuColor7 {
        background-color: white;
    }

    .subMenuColor8 {
        background-color: white;
    }

    .subMenuColor9 {
        background-color: white;
    }

    .subMenuColor10 {
        background-color: white;
    }


    {{--  Sidebar Nav Ends --}}

    .svg-inline--fa {
        height: 24px;
        width: 24px;
    }

    .mobile-menu-toggler2 {
        color: #333;
    }

    #mobile-menu-toggler2 {
        display: none;
    }

    @media (max-width: 1000px) {
        #mobile-menu-toggler2 {
            display: block;
        }
    }

    .mobile-menu-toggler2 {
        border: none;
        background: transparent;
        color: #666;
        padding: .2rem .25rem;
        font-size: 2.8rem;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        margin-left: 1rem;
        margin-right: 1rem;
    }

    /*category/subcategory/child category dropdown*/

    .menu-vertical ul.dropdown-menu {
        display: none;
        position: absolute;
        left: 100%;
        top: 0;
        min-width: 200px;
        background: #fff;
        border: 1px solid #ddd;
        z-index: 1000;
    }

    .menu-vertical li.dropdown {
        position: relative;
    }

    .menu-vertical li.dropdown:hover > .dropdown-menu {
        display: block;
    }

    .menu-vertical li a {
        display: block;
        padding: 8px 12px;
        color: #333;
        text-decoration: none;
    }

    .menu-vertical li a:hover {
        background: #f5f5f5;
    }


</style>
<header class="header header-intro-clearance header-4">
    {{--    <div class="header-top">--}}
    {{--        <div class="container p-3">--}}
    {{--            <div class="header-left">--}}
    {{--                <a href="tel:{{$settings->phone_1}}"><i class="icon-phone"></i>Call: {{$settings->phone_1}}</a>--}}
    {{--            </div><!-- End .header-left -->--}}

    {{--            <div class="header-right">--}}

    {{--                <ul class="top-menu">--}}

    {{--                    @if(auth()->check())--}}

    {{--                            <a href="{{ route('dashboard') }}" >Dashboard</a>--}}

    {{--                            <a href="{{ route('logout') }}" >Log Out</a>--}}

    {{--                    @else--}}
    {{--                        <a href="#signin-modal" data-toggle="modal">Sign in / Sign up</a>--}}
    {{--                    @endauth--}}

    {{--                </ul><!-- End .top-menu -->--}}
    {{--            </div><!-- End .header-right -->--}}

    {{--        </div><!-- End .container -->--}}
    {{--    </div><!-- End .header-top -->--}}

    <div class="header-middle">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler2" id="mobile-menu-toggler2">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>

                <a href="{{url('/')}}" class="logo">
                    <img src="{{asset($settings->light_logo)}}" alt="logo" width="150" height="35">
                </a>
            </div><!-- End .header-left -->

            <div class="header-center">
                <div class="header-search header-search-extended header-search-visible d-none d-lg-block">
                    <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                    <form action="{{ route('search') }}" method="post">
                        @csrf
                        <div class="header-search-wrapper search-wrapper-wide">
                            <label for="q" class="sr-only">Search</label>
                            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                            <input type="search" class="form-control" name="content" id="content"
                                   placeholder="Search product ...">
                        </div><!-- End .header-search-wrapper -->
                    </form>
                </div><!-- End .header-search -->
            </div>

            <div class="header-right">
                {{--                <ul class="top-menu">--}}
                {{--                    <i class="fa fa-user"></i>--}}
                {{--                    @if(auth()->check())--}}

                {{--                        <a href="{{ route('dashboard') }}">Dashboard</a>--}}

                {{--                        <a href="{{ route('logout') }}">Log Out</a>--}}

                {{--                    @else--}}
                {{--                        <a href="#signin-modal" data-toggle="modal">Sign in / Sign up</a>--}}
                {{--                    @endauth--}}

                {{--                </ul>--}}

                <div class="wishlist">
                    @if(auth()->check())
                        <a href="{{ route('dashboard') }}" title="Wishlist">

                            <div class="icon">
                                <i class="icon-home"></i>

                            </div>

                            <p>Dashboard</p>
                        </a>
                    @else
                        <a href="#signin-modal" data-toggle="modal">

                            <div class="icon">
                                <i class="icon-user"></i>
                            </div>

                            <p>Sign Up</p>
                        </a>
                    @endif
                </div>

                <div class="wishlist">
                    <a href="{{url('wish-list')}}" title="Wishlist">

                        <div class="icon">
                            <i class="icon-heart-o"></i>
                            <span class="wishlist-count badge" id="wishlistcount">{{ $wishcount }}</span>
                        </div>

                        <p>Wishlist</p>
                    </a>
                </div>

                <div class="dropdown cart-dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false" data-display="static">
                        <div class="icon" id="cart-icon">
                            <i class="icon-shopping-cart"></i>
                            <span class="cart-count">{{$count}}</span>
                        </div>
                        <p>Cart</p>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" id="hovecart">
                        @include('frontend.content.cart.loadcart')
                    </div>
                </div><!-- End .cart-dropdown -->
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-middle -->

    {{--  Side Panel  --}}
    {{--    <div id="mySidepanel" class="sidepanel" style="width: 0px;">--}}
    {{--        <div class="side-menu-header ">--}}
    {{--            <div class="side-menu-close" onclick="closeNav()">--}}
    {{--                <svg class="svg-inline--fa fa-xmark" aria-hidden="true" focusable="false" data-prefix="fas"--}}
    {{--                     data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"--}}
    {{--                     data-fa-i2svg="">--}}
    {{--                    <path fill="currentColor"--}}
    {{--                          d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path>--}}
    {{--                </svg><!-- <i class="fas fa-close"></i> Font Awesome fontawesome.com -->--}}
    {{--            </div>--}}
    {{--            <div class="px-3 pb-3 side-login" style="padding-top: 12px;padding-bottom: 15px; padding-left: 10px;">--}}
    {{--                <a href=""></a>--}}
    {{--                <a style="font-size: 16px" href="#">Categories</a>--}}
    {{--            </div>--}}
    {{--        </div>--}}

    {{--        <ul class="level1-styles collapse show" id="id0">--}}
    {{--            @forelse($categories as $category)--}}
    {{--                <li><a href="{{url('category',$category->slug)}}">{{$category->name}}</a></li>--}}
    {{--            @empty--}}
    {{--            @endforelse--}}


    {{--        </ul>--}}
    {{--    </div>--}}

    {{--Sidebar--}}
    <div class="sidebar-navigation d-none">
        <div class="d-flex justify-content-between align-items-center title-div">
            <strong class="title">Categories</strong>
            <span class="close-btn">
            <em class="mdi mdi-close"></em>
            </span>
        </div>
        @forelse($categories as $category)
            <ul>
                <li><a href="{{ url('category', $category->slug) }}">{{ $category->name }}
                        @if($category->subcategories->count() > 0)
                            <em class="mdi mdi-chevron-down"></em>
                        @endif
                    </a>
                    @if($category->subcategories->count() > 0)
                        <ul>
                            @foreach($category->subcategories as $subcategory)
                                <li>
                                    <a href="{{ route('subcategoryproduct', $subcategory->slug) }}">{{ $subcategory->name }}
                                        <em class="mdi mdi-chevron-down"></em></a>
                                    @if($subcategory->childcategories->count() > 0)
                                        <ul>
                                            @foreach($subcategory->childcategories as $childcategory)
                                                <li>
                                                    <a href="{{ route('childcategoryproduct', $childcategory->slug) }}">{{ $childcategory->name }} </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            </ul>
        @empty
        @endforelse
    </div>

    <div class="header-bottom sticky-header">
        <div class="container">
            <div class="header-left">
                <div class="dropdown category-dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false" data-display="static"
                       title="Browse Categories">
                        Browse Categories <i class="icon-angle-down"></i>
                    </a>

                    <div class="dropdown-menu">
                        <nav class="side-nav">
                            <ul class="menu-vertical sf-arrows">
                                @forelse($categories as $category)
                                    <li class="dropdown">
                                        <a href="{{ url('category', $category->slug) }}">
                                            {{ $category->name }}
                                        </a>

                                        {{-- Subcategories --}}
                                        @if($category->subcategories->count() > 0)
                                            <ul class="dropdown-menu">
                                                @foreach($category->subcategories as $subcategory)
                                                    <li class="dropdown">
                                                        <a href="{{ route('subcategoryproduct', $subcategory->slug) }}">
                                                            {{ $subcategory->name }}
                                                        </a>

                                                        {{-- Childcategories --}}
                                                        @if($subcategory->childcategories->count() > 0)
                                                            <ul class="dropdown-menu">
                                                                @foreach($subcategory->childcategories as $child)
                                                                    <li>
                                                                        <a href="{{ route('childcategoryproduct', $child->slug) }}">
                                                                            {{ $child->name }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @empty
                                    <li><span>No categories found</span></li>
                                @endforelse
                            </ul>
                        </nav>
                    </div>
                </div><!-- End .category-dropdown -->
            </div><!-- End .header-left -->

            <div class="header-center">
                <nav class="main-nav">
                    <ul class="menu sf-arrows">
                        <li class="">
                            <a href="{{url('/')}}" class="active">Home</a>
                        </li>
                        <li>
                            <a href="{{url('/shop-by-category')}}" class="">Shop</a>
                        </li>
                        <li>
                            <a href="#" class="sf-with-ul">Pages</a>

                            <ul>
                                @forelse($pages as $page)
                                    <li><a href="{{url('page',$page->slug)}}">{{$page->title}}</a></li>
                                @empty
                                @endforelse
                            </ul>
                        </li>
                        <li>
                            <a href="{{url('blogs')}}" class="">Blog</a>
                        </li>
                    </ul><!-- End .menu -->

                </nav><!-- End .main-nav -->
            </div><!-- End .header-center -->

            <div class="header-right">
                {{--                <i class="la la-lightbulb-o"></i>--}}
                {{--                <p>Clearance<span class="highlight">&nbsp;Up to 30% Off</span></p>--}}
            </div>
        </div><!-- End .container -->
    </div><!-- End .header-bottom -->
</header>
<!-- Sign in / Register Modal -->
<div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="icon-close"></i></span>
                </button>

                <div class="form-box">
                    <div class="form-tab">
                        <ul class="nav nav-pills nav-fill nav-border-anim" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin"
                                   role="tab" aria-controls="signin" aria-selected="true">Sign In</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="register-tab" data-toggle="tab" href="#register"
                                   role="tab" aria-controls="register" aria-selected="false">Register</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="tab-content-5">
                            <div class="tab-pane fade show active" id="signin" role="tabpanel"
                                 aria-labelledby="signin-tab">
                                <form action="{{route('login')}}" method="post" id="loginForm">
                                    @csrf
                                    <div class="form-group">
                                        <label for="singin-email">Email *</label>
                                        <input type="text" class="form-control" id="singin-email"
                                               name="email" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="singin-password">Password *</label>
                                        <input type="password" class="form-control" id="singin-password"
                                               name="password" required>
                                    </div>

                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-outline-primary-2">
                                            <span>LOG IN</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                   id="signin-remember">
                                            <label class="custom-control-label" for="signin-remember">Remember
                                                Me</label>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot Your Password?</a>
                                    </div>

                                </form>
                                {{--                                <div class="form-choice">--}}
                                {{--                                    <p class="text-center">or sign in with</p>--}}
                                {{--                                    <div class="row">--}}
                                {{--                                        <div class="col-sm-6">--}}
                                {{--                                            <a href="#" class="btn btn-login btn-g">--}}
                                {{--                                                <i class="icon-google"></i>--}}
                                {{--                                                Login With Google--}}
                                {{--                                            </a>--}}
                                {{--                                        </div><!-- End .col-6 -->--}}
                                {{--                                        <div class="col-sm-6">--}}
                                {{--                                            <a href="#" class="btn btn-login btn-f">--}}
                                {{--                                                <i class="icon-facebook-f"></i>--}}
                                {{--                                                Login With Facebook--}}
                                {{--                                            </a>--}}
                                {{--                                        </div><!-- End .col-6 -->--}}
                                {{--                                    </div><!-- End .row -->--}}
                                {{--                                </div><!-- End .form-choice -->--}}
                            </div><!-- .End .tab-pane -->

                            <div class="tab-pane fade" id="register" role="tabpanel"
                                 aria-labelledby="register-tab">
                                <form action="{{ url('/register') }}" method="post" id="registerForm">
                                    @csrf

                                    <div class="form-group">
                                        <label for="name">Name *</label>
                                        <input type="text" class="form-control" id="name"
                                               name="name" required>
                                    </div><!-- End .form-group -->


                                    <div class="form-group">
                                        <label for="email">Email *</label>
                                        <input type="email" class="form-control" id="email"
                                               name="email" required>
                                    </div><!-- End .form-group -->

                                    <div class="form-group">
                                        <label for="dob">Date Of Birth *</label>
                                        <input type="date" class="form-control" id="dob"
                                               name="dob" required>
                                    </div>


                                    <div class="form-group">
                                        <label for="password">Password *</label>
                                        <input type="password" class="form-control" id="password"
                                               name="password" required>
                                    </div><!-- End .form-group -->

                                    <ul id="passwordChecklist"
                                        style="list-style:none; padding-left:0; margin-top:10px;">
                                        <li id="lowercase" style="color:red;">❌ At least one lowercase letter</li>
                                        <li id="uppercase" style="color:red;">❌ At least one uppercase letter</li>
                                        <li id="number" style="color:red;">❌ At least one digit</li>
                                        <li id="special" style="color:red;">❌ At least one special character (@$!%*?&)
                                        </li>
                                        <li id="length" style="color:red;">❌ Minimum 8 characters</li>
                                    </ul>

                                    {{--                                    <div class="form-group">--}}
                                    {{--                                        <label for="password_confirmation">Confirm Password *</label>--}}
                                    {{--                                        <input type="password" class="form-control" id="password_confirmation"--}}
                                    {{--                                               name="password_confirmation" required>--}}
                                    {{--                                    </div><!-- End .form-group -->--}}

                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-outline-primary-2" id="signupBtn" disabled>
                                            <span>SIGN UP</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                   id="register-policy" name="affiliator">
                                            <label class="custom-control-label" for="register-policy"> Sign up as a
                                                Affiliator</label>
                                        </div>

                                        {{--                                        <div class="custom-control custom-checkbox">--}}
                                        {{--                                            <input type="checkbox" class="custom-control-input"--}}
                                        {{--                                                id="register-policy" required>--}}
                                        {{--                                            <label class="custom-control-label" for="register-policy">I agree to--}}
                                        {{--                                                the <a href="#">privacy policy</a> *</label>--}}
                                        {{--                                        </div><!-- End .custom-checkbox -->--}}
                                    </div><!-- End .form-footer -->
                                </form>
                                {{--                                <div class="form-choice">--}}
                                {{--                                    <p class="text-center">or sign in with</p>--}}
                                {{--                                    <div class="row">--}}
                                {{--                                        <div class="col-sm-6">--}}
                                {{--                                            <a href="#" class="btn btn-login btn-g">--}}
                                {{--                                                <i class="icon-google"></i>--}}
                                {{--                                                Login With Google--}}
                                {{--                                            </a>--}}
                                {{--                                        </div><!-- End .col-6 -->--}}
                                {{--                                        <div class="col-sm-6">--}}
                                {{--                                            <a href="#" class="btn btn-login btn-f">--}}
                                {{--                                                <i class="icon-facebook-f"></i>--}}
                                {{--                                                Login With Facebook--}}
                                {{--                                            </a>--}}
                                {{--                                        </div><!-- End .col-6 -->--}}
                                {{--                                    </div><!-- End .row -->--}}
                                {{--                                </div><!-- End .form-choice -->--}}
                            </div><!-- .End .tab-pane -->
                        </div><!-- End .tab-content -->
                    </div><!-- End .form-tab -->
                </div><!-- End .form-box -->
            </div><!-- End .modal-body -->
        </div><!-- End .modal-content -->
    </div><!-- End .modal-dialog -->
</div><!-- End .modal -->

<script>
    $(document).ready(function () {
        $('#password').on('input', function () {
            let password = $(this).val();
            let validCount = 0;

            // Lowercase
            if (/[a-z]/.test(password)) {
                $('#lowercase').text('✅ At least one lowercase letter').css('color', 'green');
                validCount++;
            } else {
                $('#lowercase').text('❌ At least one lowercase letter').css('color', 'red');
            }

            // Uppercase
            if (/[A-Z]/.test(password)) {
                $('#uppercase').text('✅ At least one uppercase letter').css('color', 'green');
                validCount++;
            } else {
                $('#uppercase').text('❌ At least one uppercase letter').css('color', 'red');
            }

            // Number
            if (/\d/.test(password)) {
                $('#number').text('✅ At least one digit').css('color', 'green');
                validCount++;
            } else {
                $('#number').text('❌ At least one digit').css('color', 'red');
            }

            // Special character
            if (/[@$!%*?&]/.test(password)) {
                $('#special').text('✅ At least one special character (@$!%*?&)').css('color', 'green');
                validCount++;
            } else {
                $('#special').text('❌ At least one special character (@$!%*?&)').css('color', 'red');
            }

            // Length
            if (password.length >= 8) {
                $('#length').text('✅ Minimum 8 characters').css('color', 'green');
                validCount++;
            } else {
                $('#length').text('❌ Minimum 8 characters').css('color', 'red');
            }

            // Enable button only if all conditions are met
            if (validCount === 5) {
                $('#signupBtn').prop('disabled', false);
            } else {
                $('#signupBtn').prop('disabled', true);
            }
        });
    });
</script>

<script>
    $(function () {
        var $ul = $('.sidebar-navigation > ul');

        $ul.find('li a').click(function (e) {
            var $li = $(this).parent();

            if ($li.find('ul').length > 0) {
                e.preventDefault();

                if ($li.hasClass('selected')) {
                    $li.removeClass('selected').find('li').removeClass('selected');
                    $li.find('ul').slideUp(400);
                    $li.find('a em').removeClass('mdi-flip-v');
                } else {

                    if ($li.parents('li.selected').length == 0) {
                        $ul.find('li').removeClass('selected');
                        $ul.find('ul').slideUp(400);
                        $ul.find('li a em').removeClass('mdi-flip-v');
                    } else {
                        $li.parent().find('li').removeClass('selected');
                        $li.parent().find('> li ul').slideUp(400);
                        $li.parent().find('> li a em').removeClass('mdi-flip-v');
                    }

                    $li.addClass('selected');
                    $li.find('>ul').slideDown(400);
                    $li.find('>a>em').addClass('mdi-flip-v');
                }
            }
        });


        $('.sidebar-navigation > ul ul').each(function (i) {
            if ($(this).find('>li>ul').length > 0) {
                var paddingLeft = $(this).parent().parent().find('>li>a').css('padding-left');
                var pIntPLeft = parseInt(paddingLeft);
                var result = pIntPLeft + 20;

                $(this).find('>li>a').css('padding-left', result);
            } else {
                var paddingLeft = $(this).parent().parent().find('>li>a').css('padding-left');
                var pIntPLeft = parseInt(paddingLeft);
                var result = pIntPLeft + 20;

                $(this).find('>li>a').css('padding-left', result).parent().addClass('selected--last');
            }
        });

        var t = ' li > ul ';
        for (var i = 1; i <= 10; i++) {
            $('.sidebar-navigation > ul > ' + t.repeat(i)).addClass('subMenuColor' + i);
        }

        var activeLi = $('li.selected');
        if (activeLi.length) {
            opener(activeLi);
        }

        function opener(li) {
            var ul = li.closest('ul');
            if (ul.length) {

                li.addClass('selected');
                ul.addClass('open');
                li.find('>a>em').addClass('mdi-flip-v');

                if (ul.closest('li').length) {
                    opener(ul.closest('li'));
                } else {
                    return false;
                }

            }
        }

    });
</script>
