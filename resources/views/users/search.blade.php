@extends('layouts.app')

@section('title') {{ __('Search') }} - {{ request()->query('q') }} @endsection

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li>{{ __('Search') }}</li>
                <li class="active">{{ request()->query('q') }}</li>
            </ul>
        </div>
    </div>
    <!-- Container End -->
</div>
<!-- Breadcrumb End -->
<!-- Cart Main Area Start -->
<div class="cart-main-area ptb-20 ptb-sm-60">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="main-categorie mb-all-40">
                    <!-- Grid & List Main Area End -->
                    <div class="tab-content fix">
                        <div id="grid-view" class="tab-pane fade show active">
                            <div class="row">
                                @forelse ($list_products as $product)
                                    <!-- Single Product Start -->
                                    <div class="col-lg-3 col-md-3 col-sm-4 col-4">
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
                            {{ $list_products->links() }}
                            <div class="product-pagination">
                                <span class="grid-item-list">{{ __('Showing :from to :to of :total (:page Pages)', ['from' => $list_products->perPage() * ($list_products->currentPage() - 1) + 1, 'to' => $list_products->perPage() * $list_products->currentPage() < $list_products->total() ? $list_products->perPage() * $list_products->currentPage() : $list_products->total(), 'total' => $list_products->total(), 'page' => $list_products->lastPage()]) }}</span>
                            </div>
                        </div>
                        <!-- Product Pagination Info -->
                    </div>
                    <!-- Grid & List Main Area End -->
                </div>
            </div>
        </div>
        <!-- Row End -->
    </div>
</div>
<!-- Cart Main Area End -->

@endsection
