@include('layouts.clients.header')
<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->

    <!-- Main Wrapper Start Here -->
    <div class="wrapper">
       <!-- Banner Popup Start -->
        <div class="popup_banner" style="background-color: #560701;">
            <div class="container">
                <span class="popup_off_banner">×</span>
                <div class="banner_popup_area">
                        <img src="{{ asset('themes/images/banner1.png') }}" alt="">
                </div>
            </div>
        </div>
        <!-- Banner Popup End -->
        <!-- Popup Start -->
        <div class="popup_wrapper">
            <div class="test">
                <span class="popup_off">×</span>
                <div class="subscribe_area text-center mt-60">
                    <h2>Newsletter</h2>
                    <p>Subscribe to the Truemart mailing list to receive updates on new arrivals, special offers and other discount information.</p>
                    <div class="subscribe-form-group">
                        <form action="#">
                            <input autocomplete="off" type="text" name="message" id="message" placeholder="Enter your email address">
                            <button type="submit">subscribe</button>
                        </form>
                    </div>
                    <div class="subscribe-bottom mt-15">
                        <input type="checkbox" id="newsletter-permission">
                        <label for="newsletter-permission">Don't show this popup again</label>
                    </div>
                </div>
            </div>
        </div>
        <!-- Popup End -->

        <!-- Main Header Area Start Here -->
        <header>
            <!-- Header Top Start Here -->
            <div class="header-top-area">
                <div class="container">
                    <!-- Header Top Start -->
                    <div class="header-top">
                        <ul>
                            <li><a href="#">{{ __('Free shipping for orders over 1 million') }}</a></li>
                            @if(Session('cart'))
                                <li><a href="{{ route('cart') }}">{{ __('Cart') }}</a></li>
                            @endif
                        </ul>
                        <ul>
                            <li>
                                <span>{{ __('Language') }}:</span>
                                <a href="#">
                                    @if(config('app.locale') == 'vi')
                                        <img src="{{ asset('themes/images/vn.png') }}" width="16px" alt="language-selector">
                                    @elseif(config('app.locale') == 'en')
                                        <img src="{{ asset('themes/images/en.png') }}" width="16px" alt="language-selector">
                                    @else
                                        <i class="fa fa-language" aria-hidden="true" alt="language-selector"></i>
                                    @endif
                                    <i class="lnr lnr-chevron-down"></i>
                                </a>
                                <!-- Dropdown Start -->
                                <ul class="ht-dropdown">
                                    <li><a href="{{ route('language', ['vi']) }}"><img src="{{ asset('themes/images/vn.png') }}" width="16px" alt="language-selector">{{ __('Vietnamese') }}</a></li>
                                    <li><a href="{{ route('language', ['en']) }}"><img src="{{ asset('themes/images/en.png') }}" width="16px" alt="language-selector">{{ __('English') }}</a></li>

                                </ul>
                            </li>
                            <!-- Dropdown End -->
                            @auth
                                <li>
                                    <a href="#"><i class="far fa-id-card"></i> {{ __('Hi') }},
                                        {{ Auth::user()->name }}
                                    </a>
                                </li>
                                <li>
                                    <a href="#" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> {{ __('Logout') }}</a>
                                </li>
                                @if(Auth::user()->role == 1)
                                    <li>
                                        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                                    </li>
                                @endif
                            @endauth
                        </ul>
                    </div>
                    <!-- Header Top End -->
                </div>
                <!-- Container End -->
            </div>
            <!-- Header Top End Here -->

            <!-- Header Middle Start Here -->
            <div class="header-middle ptb-15">
                <div class="container">
                    <div class="row align-items-center no-gutters">
                        <div class="col-lg-3 col-md-12">
                            <div class="logo mb-all-30">
                                <a href="{{ route('home')}}">
                                    <img src="{{ asset('themes/images/logo.png')}}" width="120px" alt="logo-image">
                                </a>
                            </div>
                        </div>
                        <!-- Categorie Search Box Start Here -->
                        <div class="col-lg-5 col-md-8 ml-auto mr-auto col-10">
                            <div class="categorie-search-box">
                                <form role="search" method="post" id="searchform" action="#" onsubmit="return validate()" autocomplete="off">
                                    @csrf
                                    <input id="key" type="text" name="search" placeholder="{{ __('Search')}}" >
                                    <div id="search_ajax"></div>
                                    <button type="submit"><i class="lnr lnr-magnifier"></i></button>
                                </form>
                            </div>
                        </div>
                        <!-- Categorie Search Box End Here -->
                        <!-- Cart Box Start Here -->
                        <div class="col-lg-4 col-md-12">
                            <div class="cart-box mt-all-30">
                                <ul class="d-flex justify-content-lg-end justify-content-center align-items-center">
                                    <li>
                                        <a><i class="lnr lnr-cart"></i>
                                        <span class="my-cart">
                                            <span class="total-pro">
                                                @if(Session::has('cart'))
                                                    {{ Session('cart')->totalQty }}
                                                @else
                                                    0
                                                @endif
                                            </span>
                                            <span>{{ __('Cart')}}</span></span>
                                        </a>
                                        @if(Auth::check() && Session::has('cart') )
                                            <ul class="ht-dropdown cart-box-width">
                                                <li>
                                                    @foreach($product_cart as $poroduct)
                                                    <!-- Cart Box Start -->
                                                    <div class="single-cart-box">
                                                        <div class="cart-img">
                                                            <a href="#"><img src="source/image/product/{{$poroduct['item']['image']}}" alt="cart-image"></a>
                                                            <span class="pro-quantity">{{$poroduct['qty']}}X</span>
                                                        </div>
                                                        <div class="cart-content">
                                                            <h6><a href="product.html">{{$poroduct['item']->$multisp }} </a></h6>
                                                            <span class="cart-price">@if($poroduct['item']['promotion_price']==0){{ number_format($poroduct['item']['unit_price'])}} VNĐ @else {{ number_format($poroduct['item']['promotion_price'])}} VNĐ @endif</span>
                                                        </div>
                                                        <a class="del-icone" href="{{ route('xoagiohang',$poroduct['item']['id'])}}"><i class="ion-close"></i></a>
                                                    </div>
                                                    <!-- Cart Box End -->
                                                    @endforeach
                                                    <!-- Cart Footer Inner Start -->
                                                    <div class="cart-footer">
                                                        <div class="cart-actions text-center">
                                                            <a class="cart-checkout" href="{{ route('shoppingcart')}}">{{ __('home.chitiet')}}</a>
                                                        </div>
                                                    </div>
                                                    <!-- Cart Footer Inner End -->
                                                </li>
                                            </ul>
                                        @endif
                                    </li>
                                    <li>
                                        <a href="#wish_top" id="count_wish">

                                        </a>
                                    </li>
                                    @guest
                                        <li>
                                            <a href="{{ route('login')}}">
                                                <i class="lnr lnr-user"></i>
                                                <span class="my-cart">
                                                    <span><strong>{{ __('Sign In') }}</strong>
                                                    {{ __('Or') }}</span>
                                                    <span> {{ __('Sign Up') }}</span>
                                                </span>
                                            </a>
                                        </li>
                                    @endguest
                                </ul>
                            </div>
                        </div>
                        <!-- Cart Box End Here -->
                    </div>
                    <!-- Row End -->
                </div>
                <!-- Container End -->
            </div>
            <!-- Header Middle End Here -->

            <!-- Header Bottom Start Here -->
            <div class="header-bottom  header-sticky">
                <div class="container">
                    <div class="row align-items-center">
                         <div class="col-xl-3 col-lg-4 col-md-6 vertical-menu d-none d-lg-block">
                            <span class="categorie-title">{{ __('Categories List')}}</span>
                        </div>
                        <div class="col-xl-9 col-lg-8 col-md-12 ">
                            <nav class="d-none d-lg-block">
                                <ul class="header-bottom-list d-flex">
                                    <li {{ url()->current() == route('home') ? 'class="active"' : '' }}>
                                        <a href="{{ route('home')}}">{{ __('Home') }}</a>
                                    </li>
                                    <li {{ url()->current() == route('home') ? 'class="active"' : '' }}>
                                        <a href="#">
                                            {{ __('Products') }}
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <!-- Home Version Dropdown Start -->
                                        <ul class="ht-dropdown dropdown-style-two">
                                            @foreach($menu_categories as $category)
                                                <li><a href="#">{{ $category->name }}</a></li>
                                            @endforeach
                                        </ul>
                                        <!-- Home Version Dropdown End -->
                                    </li>
                                    <li {{ url()->current() == route('home') ? 'class="active"' : '' }}><a href="#">{{ __('About') }}</a></li>
                                    <li {{ url()->current() == route('home') ? 'class="active"' : '' }}><a href="#">{{ __('Contact') }}</a></li>
                                </ul>
                            </nav>
                            <div class="mobile-menu d-block d-lg-none">
                                <nav>
                                    <ul>
                                        <li>
                                            <a href="{{ route('home')}}">{{ __('Home') }}</a>
                                        </li>
                                        <li>
                                            <a>{{ __('Products') }}</a>
                                            <!-- Mobile Menu Dropdown Start -->
                                            <ul>
                                                @foreach($menu_categories as $category)
                                                    <li><a href="#">{{ $category->name }}</a></li>
                                                @endforeach
                                            </ul>

                                            <!-- Mobile Menu Dropdown End -->
                                        </li>


                                        <li><a href="{{ route('home') }}">{{ __('About') }}</a></li>
                                        <li><a href="{{ route('home')}}">{{ __('Contact') }}</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <!-- Row End -->
                </div>
                <!-- Container End -->
            </div>
            <!-- Header Bottom End Here -->
            <!-- Mobile Vertical Menu Start Here -->
            <div class="container d-block d-lg-none">
                <div class="vertical-menu mt-30">
                    <span class="categorie-title mobile-categorei-menu">{{ __('Shop by Categories') }}</span>
                    <nav>
                        <div id="cate-mobile-toggle" class="category-menu sidebar-menu sidbar-style mobile-categorei-menu-list menu-hidden ">
                            <ul>
                                @foreach($menu_categories as $category)
                                    @include('layouts.clients.components.subcategory', ['subcategory' => $category])
                                @endforeach
                            </ul>
                        </div>
                        <!-- category-menu-end -->
                    </nav>
                </div>
            </div>
            <!-- Mobile Vertical Menu Start End -->
        </header>
        <!-- Main Header Area End Here -->

        <!-- Categorie Menu & Slider Area Start Here -->
        <div class="main-page-banner home-3">
            <div class="container">
                <div class="row">
                    @include('layouts.clients.components.menu')
                </div>
                <!-- Row End -->
            </div>
            <!-- Container End -->
        </div>
        <!-- Categorie Menu & Slider Area End Here -->

        @yield('content')

    @include('layouts.clients.footer')
</body>

</html>
