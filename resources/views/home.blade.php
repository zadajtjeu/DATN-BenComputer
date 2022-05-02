@extends('layouts.app')

@section('content')
    <!-- Categorie Menu & Slider Area Start Here -->
    <div class="main-page-banner pb-50 off-white-bg">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 d-none d-lg-block">
                    <script>document.getElementsByClassName("vertical-menu-list")[0].style.display = "block";</script>
                </div>
                <!-- Slider Area Start Here -->
                @include('layouts.clients.components.slider')
                <!-- Slider Area End Here -->
            </div>
            <!-- Row End -->
        </div>
        <!-- Container End -->
    </div>
    <!-- Categorie Menu & Slider Area End Here -->
    <!-- Brand Banner Area Start Here -->
    <div class="image-banner pb-50 off-white-bg">
        <div class="container">
            <div class="col-img">
                <a href="#"><img src="{{ asset('themes/images/head-banner.jpg') }}"
                        alt="image banner"></a>
            </div>
        </div>
        <!-- Container End -->
    </div>
    <!-- Brand Banner Area End Here -->

    <!-- Big Banner Start Here -->
    <div class="big-banner mt-100 pb-85 mt-sm-60 pb-sm-45">
        <div class="container banner-2">
            <div class="banner-box">
                <div class="col-img" style="width: 224px; height: 174.44px">
                    <a href="#"><img width="224px" height="174.44px"
                            src="{{ asset('themes/images/banner-9.jpg') }}" alt="banner 3"></a>
                </div>
                <div class="col-img" style="width: 224px; height: 174.44px">
                    <a href="#"><img width="224px" height="174.44px"
                            src="{{ asset('themes/images/banner-8.jpg') }}" alt="banner 3"></a>
                </div>
            </div>
            <div class="banner-box">
                <div class="col-img" style="width: 224px; height: 359.79px">
                    <a href="#"><img width="224px" height="359.79px"
                            src="{{ asset('themes/images/banner-10.jpg') }}" alt="banner 3"></a>
                </div>
            </div>
            <div class="banner-box">
                <div class="col-img" style="width: 224px; height: 174.44px">
                    <a href="#"><img width="224px" height="174.44px"
                            src="{{ asset('themes/images/banner-12.jpg') }}" alt="banner 3"></a>
                </div>
                <div class="col-img" style="width: 224px; height: 174.44px">
                    <a href="#"><img width="224px" height="174.44px"
                            src="{{ asset('themes/images/banner-7.jpg') }}" alt="banner 3"></a>
                </div>
            </div>
            <div class="banner-box">
                <div class="col-img" style="width: 224px; height: 359.79px">
                    <a href="#"><img width="224px" height="359.79px"
                            src="{{ asset('themes/images/banner-11.jpg') }}" alt="banner 3"></a>
                </div>
            </div>
            <div class="banner-box">
                <div class="col-img" style="width: 224px; height: 174.44px">
                    <a href="#"><img width="224px" height="174.44px"
                            src="{{ asset('themes/images/banner-13.jpg') }}" alt="banner 3"></a>
                </div>
                <div class="col-img" style="width: 224px; height: 174.44px">
                    <a href="#"><img width="224px" height="174.44px"
                            src="{{ asset('themes/images/banner-14.jpg') }}" alt="banner 3"></a>
                </div>
            </div>
        </div>
        <!-- Container End -->
    </div>
    <!-- Big Banner End Here -->




    <!-- Arrivals Products Area Start Here -->
    <div class="second-arrivals-product pb-45 pb-sm-5">
        <div class="container">
            <div class="main-product-tab-area">
                <div class="tab-menu mb-25">
                    <div class="section-ttitle">
                        <h2>{{ __('New Products') }}</h2>
                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav tabs-area" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#newest">{{ __('Newest') }} </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#sellest">{{ __('Sellest') }}</a>
                        </li>
                    </ul>

                </div>

                <!-- Tab Contetn Start -->
                <div class="tab-content">
                    <!-- #newest Start Here -->
                    <div id="newest" class="tab-pane fade show active">
                        <!-- Arrivals Product Activation Start Here -->
                        <div class="best-seller-pro-active owl-carousel">
                            @foreach ($new_products as $new)
                                <!-- Double Product Start -->
                                <div class="double-product">
                                    <!-- Single Product Start -->
                                    <div class="single-product">
                                        <a href="#" id="pagesosanh{{ $new->id }}" style="visibility: hidden;"></a>
                                        <input type="hidden" id="wishList_product_name{{ $new->id }}"
                                            value="{{ $new->title }}">
                                        <input type="hidden" id="wishList_price{{ $new->id }}"
                                            value="{{ ($new->promotion_price == 0) ? currency_format($new->price) : currency_format($new->promotion_price) }}">

                                        <input type="hidden" id="instock{{ $new->id }}" value="{{ ($new->quantity >= $new->sold) ? __('In stock') : __('Out stock') }}">
                                        <input type="hidden" id="mota{{ $new->id }}" value="{{ $new->specifications }}">


                                        <!-- Product Image Start -->
                                        <div class="pro-img">
                                            <a id="wishList_producturl{{ $new->id }}"
                                                href="{{ route('products.details', ['slug' => $new->slug, 'id' => $new->id]) }}">
                                                <img id="wishList_image{{ $new->id }}" class="primary-img"
                                                    src="{{ $new->images[0]->url }}" alt="single-product"
                                                    height="276.45px">
                                                <img class="secondary-img" src="{{ $new->images[0]->url }}"
                                                    alt="single-product" height="276.45px">
                                            </a>
                                            <a href="#" class="quick_view" data-toggle="modal"
                                                data-target="#myModal_{{ $new->id }}" title="Quick View"><i
                                                    class="lnr lnr-magnifier"></i></a>
                                        </div>
                                        <!-- Product Image End -->
                                        <!-- Product Content Start -->
                                        <div class="pro-content">
                                            <div class="pro-info">
                                                <h4><a href="{{ route('products.details', ['slug' => $new->slug, 'id' => $new->id]) }}">{{ $new->title }}</a>
                                                </h4>
                                                <p>
                                                    @if ($new->promotion_price == 0)
                                                        <span class="price">{{ currency_format($new->price) }}</span>
                                                    @else
                                                        <span class="price">{{ currency_format($new->promotion_price) }}</span>
                                                        <span class="prev-price">{{ currency_format($new->price) }}</span>
                                                    @endif
                                                </p>
                                                @if ($new->promotion_price != 0)
                                                    <div class="label-product l_sale">
                                                        {{ number_format(100 - ($new->promotion_price / $new->price) * 100) }}
                                                        <span class="symbol-percent">%</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="pro-actions">
                                                <div class="actions-primary">
                                                    @if ($new->quantity > 0)
                                                        <a id="addcart{{ $new->id }}" href="" title="{{ __('Add to cart') }}"> + {{ __('Add to cart') }}
                                                        </a>
                                                    @else
                                                        <a id="addcart{{ $new->id }}" class="disabled-link">
                                                            + {{ __('Add to cart') }}
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="actions-secondary">
                                                    <a style="cursor: pointer;" id="{{ $new->id }}"
                                                        onclick="add_Compare(this.id)"
                                                        title="{{ __('Add To Compare') }}"><i
                                                            class="lnr lnr-sync"></i>
                                                        <span>{{ __('Compare') }}</span></a>
                                                    <a style="cursor: pointer;" id="{{ $new->id }}"
                                                        onclick="add_wishList(this.id)"
                                                        title="{{ __('Wishlist') }}"><i
                                                            class="lnr lnr-heart"></i>
                                                        <span>{{ __('Wishlist') }}</span></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Product Content End -->
                                        @if ($new->promotion_price != 0)
                                            <span class="sticker-new">{{ __('Sale') }}</span>
                                        @endif
                                    </div>
                                    <!-- Single Product End -->
                                </div>
                                <!-- Double Product End -->
                            @endforeach
                        </div>
                        <!-- Arrivals Product Activation End Here -->
                    </div>
                    <!-- #newest End Here -->
                    <!-- #sellest Start Here -->
                    <div id="sellest" class="tab-pane fade">
                        <!-- Arrivals Product Activation Start Here -->
                        <div class="best-seller-pro-active owl-carousel">
                            @foreach ($sellest_products as $new)
                                <!-- Double Product Start -->
                                <div class="double-product">
                                    <!-- Single Product Start -->
                                    <div class="single-product">
                                        <a href="#" id="pagesosanh{{ $new->id }}" style="visibility: hidden;"></a>
                                        <input type="hidden" id="wishList_product_name{{ $new->id }}"
                                            value="{{ $new->title }}">
                                        <input type="hidden" id="wishList_price{{ $new->id }}"
                                            value="{{ ($new->promotion_price == 0) ? currency_format($new->price) : currency_format($new->promotion_price) }}">

                                        <input type="hidden" id="instock{{ $new->id }}" value="{{ ($new->quantity >= $new->sold) ? __('In stock') : __('Out stock') }}">
                                        <input type="hidden" id="mota{{ $new->id }}" value="{{ $new->specifications }}">


                                        <!-- Product Image Start -->
                                        <div class="pro-img">
                                            <a id="wishList_producturl{{ $new->id }}"
                                                href="{{ route('products.details', ['slug' => $new->slug, 'id' => $new->id]) }}">
                                                <img id="wishList_image{{ $new->id }}" class="primary-img"
                                                    src="{{ $new->images[0]->url }}" alt="single-product"
                                                    height="276.45px">
                                                <img class="secondary-img" src="{{ $new->images[0]->url }}"
                                                    alt="single-product" height="276.45px">
                                            </a>
                                            <a href="#" class="quick_view" data-toggle="modal"
                                                data-target="#myModal_{{ $new->id }}" title="Quick View"><i
                                                    class="lnr lnr-magnifier"></i></a>
                                        </div>
                                        <!-- Product Image End -->
                                        <!-- Product Content Start -->
                                        <div class="pro-content">
                                            <div class="pro-info">
                                                <h4><a href="{{ route('products.details', ['slug' => $new->slug, 'id' => $new->id]) }}">{{ $new->title }}</a>
                                                </h4>
                                                <p>
                                                    @if ($new->promotion_price == 0)
                                                        <span class="price">{{ currency_format($new->price) }}</span>
                                                    @else
                                                        <span class="price">{{ currency_format($new->promotion_price) }}</span>
                                                        <span class="prev-price">{{ currency_format($new->price) }}</span>
                                                    @endif
                                                </p>
                                                @if ($new->promotion_price != 0)
                                                    <div class="label-product l_sale">
                                                        {{ number_format(100 - ($new->promotion_price / $new->price) * 100) }}
                                                        <span class="symbol-percent">%</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="pro-actions">
                                                <div class="actions-primary">
                                                    @if ($new->quantity > 0)
                                                        <a id="addcart{{ $new->id }}" href="" title="{{ __('Add to cart') }}"> + {{ __('Add to cart') }}
                                                        </a>
                                                    @else
                                                        <a id="addcart{{ $new->id }}" class="disabled-link">
                                                            + {{ __('Add to cart') }}
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="actions-secondary">
                                                    <a style="cursor: pointer;" id="{{ $new->id }}"
                                                        onclick="add_Compare(this.id)"
                                                        title="{{ __('Add To Compare') }}"><i
                                                            class="lnr lnr-sync"></i>
                                                        <span>{{ __('Compare') }}</span></a>
                                                    <a style="cursor: pointer;" id="{{ $new->id }}"
                                                        onclick="add_wishList(this.id)"
                                                        title="{{ __('Wishlist') }}"><i
                                                            class="lnr lnr-heart"></i>
                                                        <span>{{ __('Wishlist') }}</span></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Product Content End -->
                                        @if ($new->promotion_price != 0)
                                            <span class="sticker-new">{{ __('Sale') }}</span>
                                        @endif
                                    </div>
                                    <!-- Single Product End -->
                                </div>
                                <!-- Double Product End -->
                            @endforeach
                        </div>
                        <!-- Arrivals Product Activation End Here -->
                    </div>
                    <!-- #sellest End Here -->
                </div>
                <!-- Tab Content End -->
            </div>
            <!-- main-product-tab-area-->
        </div>
        <!-- Container End -->
    </div>
    <!-- Arrivals Products Area End Here -->
@endsection
