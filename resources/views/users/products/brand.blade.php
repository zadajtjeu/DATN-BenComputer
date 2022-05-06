@extends('layouts.app')

@section('title') {{ __('Shop') }} @endsection

@section('content')

<!-- Breadcrumb Start -->
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="active"><a href="">{{ __('Shop') }}</a></li>
            </ul>
        </div>
    </div>
    <!-- Container End -->
</div>
<!-- Breadcrumb End -->
@php
    $parameters = request()->input();
    unset($parameters['page']);
@endphp

<!-- Shop Page Start -->
<div class="main-shop-page pt-20 pb-100 ptb-sm-60">
    <div class="container">
        <!-- Row End -->
        <div class="row">
            <!-- Sidebar Shopping Option Start -->
            <div class="col-lg-3 order-2 order-lg-1">
                <div class="sidebar">
                    <!-- Sidebar Electronics Categorie Start -->
                    <div class="electronics mb-40">
                        <h3 class="sidebar-title">{{ $brand->name }}</h3>
                        <!-- category-menu-end -->
                    </div>
                    <!-- Sidebar Electronics Categorie End -->
                    <!-- Price Filter Options Start -->
                    <style type="text/css">
                        .style-range p {
                            float: left;
                            width: 37%;
                        }
                    </style>
                    @php
                        $minPrice = isset($parameters['minPrice']) ? $parameters['minPrice'] : 0;
                        $maxPrice = isset($parameters['maxPrice']) ? $parameters['maxPrice'] : 0;
                    @endphp
                    <div class="search-filter mb-40">
                        <h3 class="sidebar-title">{{ __('Filter By Price') }}</h3>
                        <form class="sidbar-style" action="{{ route('brands.details', array_merge(['slug' => $brand->slug], $parameters)) }}" method="get">
                            <div id="slider-range"></div>
                            <div class="style-range">
                                <p><input type="text" id="amount_start" class="amount-range" ></p>
                                <p><input type="text" id="amount_end" class="amount-range" ></p>
                            </div>
                            <input pattern="[0-9]*" type="hidden" id="minPrice" name="minPrice" value="{{ $minPrice }}">
                            <input pattern="[0-9]*" type="hidden" id="maxPrice" name="maxPrice" value="{{ $maxPrice }}">
                            <div class="clearfix"></div>
                            <input type="submit" class="btn btn-default" value="{{ __('Filter') }}">
                        </form>
                    </div>
                    <!-- Price Filter Options End -->
                    <div class="search-filter mb-40">
                        <h3 class="sidebar-title">{{ __('Search') }}</h3>
                        <form class="w-100 p-2 me-3 input-group" action="{{ route('brands.details', $brand->slug) }}" method="get" style="max-width: 500px;">
                            <input type="search" name="search" class="form-control" value="{{ request()->query('search') }}" placeholder="{{ __('Search') }}" aria-label="{{ __('Search') }}">
                        </form>
                    </div>
                    <!-- Price Filter Options End -->
                    <!-- Sidebar Categorie Start -->
                    <style type="text/css">
                        #sidbar_product{
                            overflow: scroll;
                            height: 300px;
                        }
                        #sidbar_product::-webkit-scrollbar-track {
                            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                            background-color: #F5F5F5;
                        }

                        #sidbar_product::-webkit-scrollbar {
                            width: 6px;
                            height: 0px;
                            background-color: #F5F5F5;
                        }

                        #sidbar_product::-webkit-scrollbar-thumb {
                            background-color: #E62E04;
                        }
                    </style>
                </div>
            </div>
            <!-- Sidebar Shopping Option End -->
            <!-- Product Categorie List Start -->
            <div class="col-lg-9 order-1 order-lg-2">
                <!-- Grid & List View Start -->
                <div class="grid-list-top border-default universal-padding d-md-flex justify-content-md-between align-items-center mb-30">
                    <!-- Toolbar Short Area Start -->
                    <div class="main-toolbar-sorter clearfix">
                        <div class="toolbar-sorter d-flex align-items-center" >
                            <label>{{ __('Sort By') }}:</label>
                            @php
                                $sort = isset($parameters['sort']) ? $parameters['sort'] : '';
                            @endphp
                            <select class="sorter wide" id="sort">
                                @php $parameters['sort'] = '' @endphp
                                <option @if ($sort == '') selected @endif value="{{ route('brands.details', array_merge(['slug' => $brand->slug], $parameters)) }}">{{ __('Popular') }}</option>
                                @php $parameters['sort'] = 'newest' @endphp
                                <option @if ($sort == 'newest') selected @endif value="{{ route('brands.details', array_merge(['slug' => $brand->slug], $parameters)) }}">{{ __('Newest') }}</option>
                                @php $parameters['sort'] = 'top_seller' @endphp
                                <option @if ($sort == 'top_seller') selected @endif value="{{ route('brands.details', array_merge(['slug' => $brand->slug], $parameters)) }}">{{ __('Top Seller') }}</option>
                                @php $parameters['sort'] = 'price_asc' @endphp
                                <option @if ($sort == 'price_asc') selected @endif value="{{ route('brands.details', array_merge(['slug' => $brand->slug], $parameters)) }}">{{ __('Low Price') }}</option>
                                @php $parameters['sort'] = 'price_desc' @endphp
                                <option @if ($sort == 'price_desc') selected @endif value="{{ route('brands.details', array_merge(['slug' => $brand->slug], $parameters)) }}">{{ __('High Price') }}</option>
                            </select>
                            @php
                                if ($sort == '') {
                                    unset($parameters['sort']);
                                }
                            @endphp
                        </div>
                    </div>
                    <!-- Toolbar Short Area End -->
                    <!-- Toolbar Short Area Start -->

                    <div class="main-toolbar-sorter clearfix">
                        <div class="toolbar-sorter d-flex align-items-center">
                            <label>{{ __('Show') }}:</label>
                            @php
                                $show = isset($parameters['show']) ? $parameters['show'] : '';
                            @endphp
                            <select class="sorter wide" id="showproduct">
                                @php $parameters['show'] = '12' @endphp
                                <option @if ($show == '12') selected @endif value="{{ route('brands.details', array_merge(['slug' => $brand->slug], $parameters)) }}">12</option>
                                @php $parameters['show'] = '24' @endphp
                                <option @if ($show == '24') selected @endif value="{{ route('brands.details', array_merge(['slug' => $brand->slug], $parameters)) }}">24</option>
                                @php $parameters['show'] = '36' @endphp
                                <option @if ($show == '36') selected @endif value="{{ route('brands.details', array_merge(['slug' => $brand->slug], $parameters)) }}">36</option>
                                @php $parameters['show'] = '48' @endphp
                                <option @if ($show == '48') selected @endif value="{{ route('brands.details', array_merge(['slug' => $brand->slug], $parameters)) }}">48</option>
                            </select>
                            @php
                                if ($show == '') {
                                    unset($parameters['show']);
                                }
                            @endphp
                        </div>
                    </div>
                    <!-- Toolbar Short Area End -->
                </div>
                <!-- Grid & List View End -->
                <div class="main-categorie mb-all-40">
                    <!-- Grid & List Main Area End -->
                    <div id="grid-view">
                        <div class="row">
                            @forelse ($products as $product)
                                <!-- Single Product Start -->
                                <div class="col-lg-4 col-md-4 col-sm-6 col-6">
                                    <div class="single-product">
                                        <!-- Product Image Start -->
                                        <div class="pro-img">
                                            <a id="wishList_producturl{{ $product->id }}"
                                            href="{{ route('products.details', ['slug' => $product->slug, 'id' => $product->id]) }}">
                                            <img id="wishList_image{{ $product->id }}" class="primary-img"
                                                src="{{ $product->images[0]->url }}" alt="single-product"
                                                height="276.45px">
                                            <img class="secondary-img" src="{{ $product->images[0]->url }}"
                                                alt="single-product" height="276.45px">
                                        </a>
                                        <a href="#" class="quick_view" data-toggle="modal"
                                            data-target="#myModal_{{ $product->id }}" title="Quick View"><i
                                                class="lnr lnr-magnifier"></i></a>
                                        </div>
                                        <!-- Product Image End -->
                                        <!-- Product Content Start -->
                                        <div class="pro-content">
                                            <div class="pro-info">
                                                <h4><a href="{{ route('products.details', ['slug' => $product->slug, 'id' => $product->id]) }}">{{ $product->title }}</a>
                                                </h4>
                                                <p>
                                                    @if ($product->promotion_price == 0)
                                                        <span class="price">{{ currency_format($product->price) }}</span>
                                                    @else
                                                        <span class="price">{{ currency_format($product->promotion_price) }}</span>
                                                        <span class="prev-price">{{ currency_format($product->price) }}</span>
                                                    @endif
                                                </p>
                                                @if ($product->promotion_price != 0)
                                                    <div class="label-product l_sale">
                                                        {{ number_format(100 - ($product->promotion_price / $product->price) * 100) }}
                                                        <span class="symbol-percent">%</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="pro-actions">
                                                <div class="actions-primary">
                                                    @if ($product->quantity > 0)
                                                        <a id="addcart{{ $product->id }}" href="{{ route('cart.add', [$product->id]) }}" title="{{ __('Add to cart') }}"> + {{ __('Add to cart') }}
                                                        </a>
                                                    @else
                                                        <a id="addcart{{ $product->id }}" class="disabled-link">
                                                            + {{ __('Add to cart') }}
                                                        </a>
                                                    @endif
                                                </div>

                                                <div class="actions-secondary">
                                                    <a style="cursor: pointer;" id="{{ $product->id }}"
                                                        onclick="add_Compare(this.id)"
                                                        title="{{ __('Add To Compare') }}"><i
                                                            class="lnr lnr-sync"></i>
                                                        <span>{{ __('Compare') }}</span></a>
                                                    <a style="cursor: pointer;" id="{{ $product->id }}"
                                                        onclick="add_wishList(this.id)"
                                                        title="{{ __('Wishlist') }}"><i
                                                            class="lnr lnr-heart"></i>
                                                        <span>{{ __('Wishlist') }}</span></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Product Content End -->
                                    </div>
                                </div>
                                <!-- Single Product End -->
                            @empty
                                <div class="alert alert-info col-12">{{ __('Empty') }}</div>
                            @endforelse
                        </div>
                        <!-- Row End -->
                    </div>
                    <!-- #grid view End -->
                    <div class="pro-pagination">
                        {{ $products->links() }}
                        <div class="product-pagination">
                            <span class="grid-item-list">{{ __('Showing :from to :to of :total (:page Pages)', ['from' => $products->perPage() * ($products->currentPage() - 1) + 1, 'to' => $products->perPage() * $products->currentPage() < $products->total() ? $products->perPage() * $products->currentPage() : $products->total(), 'total' => $products->total(), 'page' => $products->lastPage()]) }}</span>
                        </div>
                    </div>
                    <!-- Product Pagination Info -->
                    <!-- Grid & List Main Area End -->
                </div>
            </div>
            <!-- product Categorie List End -->
        </div>
        <!-- Row End -->
    </div>
    <!-- Container End -->
</div>
<!-- Shop Page End -->
@endsection
@section('addjs')
    <!-- sap xep -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#sort').on('change', function() {
                var url = $(this).val();
                if (url) {
                    window.location = url;
                }
                return false;
            });
            // sap xep hien thi
            $('#showproduct').on('change', function() {
                var url_show = $(this).val();
                // alert(url_show);
                if (url_show) {
                    window.location = url_show;
                }
                return false;
            });
        });
    </script>
    <script>
        (function($) {
            $.fn.simpleMoneyFormat = function() {
                this.each(function(index, el) {
                    var elType = null; // input or other
                    var value = null;
                    // get value
                    if ($(el).is('input') || $(el).is('textarea')) {
                        value = $(el).val().replace(/,/g, '');
                        elType = 'input';
                    } else {
                        value = $(el).text().replace(/,/g, '');
                        elType = 'other';
                    }
                    // if value changes
                    $(el).on('paste keyup', function() {
                        value = $(el).val().replace(/,/g, '');
                        formatElement(el, elType, value); // format element
                    });
                    formatElement(el, elType, value); // format element
                });

                function formatElement(el, elType, value) {
                    var result = '';
                    var valueArray = value.split('');
                    var resultArray = [];
                    var counter = 0;
                    var temp = '';
                    for (var i = valueArray.length - 1; i >= 0; i--) {
                        temp += valueArray[i];
                        counter++
                        if (counter == 3) {
                            resultArray.push(temp);
                            counter = 0;
                            temp = '';
                        }
                    };
                    if (counter > 0) {
                        resultArray.push(temp);
                    }
                    for (var i = resultArray.length - 1; i >= 0; i--) {
                        var resTemp = resultArray[i].split('');
                        for (var j = resTemp.length - 1; j >= 0; j--) {
                            result += resTemp[j];
                        };
                        if (i > 0) {
                            result += ','
                        }
                    };
                    if (elType == 'input') {
                        $(el).val(result);
                    } else {
                        $(el).empty().text(result);
                    }
                }
            };
        }(jQuery));
    </script>
    <!-- sap xep theo tien -->
    <script type="text/javascript">
        $(document).ready(function() {
            $("#slider-range").slider({
                orientation: "horizontal",
                range: true,
                min: 0,
                max: 50000000,
                steps: 10000,
                values: [{{ isset($parameters['minPrice']) ? $parameters['minPrice'] : 0 }}, {{ isset($parameters['maxPrice']) ? $parameters['maxPrice'] : 50000000 }}],
                slide: function(event, ui) {
                    $("#amount_start").val(ui.values[0]).simpleMoneyFormat();
                    $("#amount_end").val(ui.values[1]).simpleMoneyFormat();
                    $("#minPrice").val(ui.values[0]);
                    $("#maxPrice").val(ui.values[1]);
                }
            });
            $("#amount_start").val($("#slider-range").slider("values", 0)).simpleMoneyFormat()
            $("#amount_end").val($("#slider-range").slider("values", 1)).simpleMoneyFormat();
        });
    </script>
@endsection
