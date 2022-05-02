@extends('layouts.app')
@section('title')
{{ $product_details->title }}
@endsection
@section('description')
{{ Str::words(strip_tags($product_details->title), 20) }}
@endsection
@section('images')
{{ isset($product_details->images[0]) ? $product_details->images[0] : asset('themes/images/logo.png') }}
@endsection
@section('content')

<!-- Breadcrumb Start -->
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                @if (!empty($product_details->category))
                    @php
                       $cate = $product_details->category;
                       $list_cate = '<li class="active"><a href="' . route('categories.details', ['slug' => $cate->slug]) . '">' . $cate->name . '</a></li>';
                    @endphp
                    @while(!$cate->isParent())
                        @php
                           $cate = $cate->parent;
                           $list_cate = '<li><a href="' . route('categories.details', ['slug' => $cate->slug]) . '">' . $cate->name . '</a></li>' . $list_cate;
                        @endphp
                    @endwhile
                    {!! $list_cate !!}

                @endif
            </ul>
        </div>
    </div>
    <!-- Container End -->
</div>
<!-- Breadcrumb End -->
<!-- Product Thumbnail Start -->
<div class="main-product-thumbnail ptb-100 ptb-sm-60">
    <div class="container">
        <div class="thumb-bg">
            <div class="row">
                <a href="sosanh" id="pagesosanh{{ $product_details->id }}" style="visibility: hidden;"></a>
                <input type="hidden" id="wishList_product_name{{ $product_details->id }}" value="{{ $product_details->multisp }}" >
                <input type="hidden" id="wishList_price{{ $product_details->id }}" value="{{ ($product_details->promotion_price == 0) ? currency_format($product_details->price) : currency_format($product_details->promotion_price) }}" >

                <input type="hidden" id="instock{{ $product_details->id }}" value="{{ ($product_details->quantity >= $product_details->sold) ? __('In stock') : __('Out stock') }}">
                 <input type="hidden" id="mota{{ $product_details->id }}" value="{!! $product_details->specifications !!}">

                <!-- Main Thumbnail Image Start -->
                <div class="col-lg-5 mb-all-40">
                    <!-- Thumbnail Large Image start -->
                    <div class="tab-content">
                        @foreach ($product_details->images as $image_id => $image)
                            <div id="thumb{{ $image_id }}" class="tab-pane fade{{ $image_id == 0 ? ' show active' : '' }}">
                                <a data-fancybox="images" href="{{ $image->url }}"><img src="{{ $image->url }}" alt="product-view" height="452.5px" width="452.5px"></a>
                            </div>
                        @endforeach
                    </div>
                    <!-- Thumbnail Large Image End -->
                    <!-- Thumbnail Image End -->
                    <div class="product-thumbnail mt-15">
                        <div class="thumb-menu owl-carousel nav tabs-area" role="tablist">
                            @foreach ($product_details->images as $image_id => $image)
                                <a{!! $image_id == 0 ? ' class="active"' : '' !!} data-toggle="tab" href="#thumb{{ $image_id }}"><img src="{{ $image->url }}" alt="product-thumbnail" height="138.83px" width="138.82px"></a>
                            @endforeach
                        </div>
                    </div>
                    <!-- Thumbnail image end -->
                </div>
                <!-- Main Thumbnail Image End -->
                <!-- Thumbnail Description Start -->
                <div class="col-lg-7">
                    <div class="thubnail-desc fix">
                        <h3 class="product-header">
                            @if (!empty($product_details->brand))
                                <a href="{{ route('brands.details', ['slug' => $product_details->brand->slug]) }}">
                                    <img src="{{ $product_details->brand->logo->url }}" height="24px">
                                </a>
                            @endif
                            {{ $product_details->title }}
                        </h3>
                        <div class="rating-summary fix mtb-10">
                            <div class="rating">
                                {!! rating_star($product_details->avg_rate) !!}
                            </ul>
                            <div class="rating-feedback" role="tablist">
                                <a href="#dtail">({{ $product_details->ratings->count() }} {{ __('Review') }})</a>
                                <a href="#dtail">{{ __('Add To Your Review') }}</a>
                            </div>
                        </div>
                        <div class="pro-price mtb-30">
                            <p class="d-flex align-items-center">

                                @if ($product_details->promotion_price == 0)
                                    <span class="price">{{ currency_format($product_details->price) }}</span>
                                @else
                                    <span class="prev-price">{{ currency_format($product_details->price) }}</span>
                                    <span class="price">{{ currency_format($product_details->promotion_price) }}</span><span class="saving-price">{{ __('Save') }} {{ number_format(100-($product_details->promotion_price/$product_details->unit_price)*100) }} %</span>
                                @endif
                            </p>
                        </div>

                        <div class="box-quantity d-flex hot-product2">
                            <div class="pro-actions">
                                <div class="actions-primary">
                                    @if ($product_details->quantity > 0)
                                        <a id="addcart{{ $product_details->id }}" href="#"
                                        title="" data-original-title="{{ __('Add To Cart') }}"> + {{ __('Add To Cart') }}</a>
                                    @else
                                        <a id="addcart{{ $product_details->id }}" class="disabled-link"> + {{ __('Add To Cart') }}</a>
                                    @endif
                                </div>
                                <div class="actions-secondary">
                                    <a style="cursor: pointer;" id="{{ $product_details->id }}" onclick="add_Compare(this.id)" title="{{ __('Add To Compare') }}"><i class="lnr lnr-sync"></i> <span>{{ __('Add To Compare') }}</span></a>
                                    <a href="wishlist.html" title="" data-original-title="{{ __('Add To Wishlist') }}"><i class="lnr lnr-heart"></i> <span>{{ __('Add To Wishlist') }}</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="pro-ref mt-20">
                            <p>
                                @if ($product_details->quantity > 0)
                                    <span class="in-stock"><i class="ion-checkmark-round"></i> {{ __('In Stock') }}</span>
                                @else
                                    <span class="out-stock"><i class="ion-close"></i> {{ __('Out Stock') }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="socila-sharing mt-25">
                            <ul class="d-flex">
                                <li>{{ __('Share') }}</li>
                                <li><a class="share" href="https://www.facebook.com/sharer/sharer.php?u={{ route('products.details', ['slug' => $product_details->slug, 'id' => $product_details->id]) }}&amp;src=sdkpreparse"><i class="fa fa-facebook " aria-hidden="true"></i></a></li>
                                <li><a class="share" href="http://twitter.com/share?url={{ route('products.details', ['slug' => $product_details->slug, 'id' => $product_details->id]) }}"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a class="share" href="https://plus.google.com/share?url={{ route('products.details', ['slug' => $product_details->slug, 'id' => $product_details->id]) }}"><i class="fa fa-google-plus-official" aria-hidden="true"></i></a></li>
                                <li><a class="share" href="http://pinterest.com/pin/create/button/?url={{ route('products.details', ['slug' => $product_details->slug, 'id' => $product_details->id]) }}&description={{ $product_details->title }}&media={{ $product_details->images[0]->url }}"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Thumbnail Description End -->
            </div>
            <!-- Row End -->
        </div>
    </div>
    <!-- Container End -->
</div>
<!-- Product Thumbnail End -->
<!-- Product Thumbnail Description Start -->
<div class="thumnail-desc pb-100 pb-sm-60">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ul class="main-thumb-desc nav tabs-area" role="tablist">
                    <li><a class="active" data-toggle="tab" href="#dtail">{{ __('Details') }}</a></li>
                    <li><a data-toggle="tab" href="#speci">{{ __('Specifications') }}</a></li>
                    <li>
                        <a data-toggle="tab" href="#review">
                            {{ __('Review') }} ({{ $product_details->ratings->count() }})
                        </a>
                    </li>
                </ul>

                <!-- Product Thumbnail Tab Content Start -->
                <div class="tab-content thumb-content border-default">
                    <div id="dtail" class="tab-pane fade show active">
                        <p>{!! $product_details->content !!}</p>
                    </div>
                    <div id="speci" class="tab-pane fade">
                        <p>{!! $product_details->specifications !!}</p>
                    </div>
                    <div id="review" class="tab-pane fade">
                        <div class="container row justify-content-between pt-md-2">
                            <div class="col-6 row pb-3">
                                <div class="col-lg-4 col-md-5">
                                    <h2 class="h3 mb-4">{{ $product_details->ratings->count() }} {{ __('Reviews') }}</h2>
                                    <div class="star-rating text-warning me-2">
                                        @foreach (range(1, 5) as $rate)
                                            @if ($product_details->avg_rate >= $rate)
                                                <i class="fa fa-star"></i>
                                            @elseif ($product_details->avg_rate == $rate - 0.5)
                                                <i class="fa fa-star-half-o"></i>
                                            @else
                                                <i class="fa fa-star-o"></i>
                                            @endif
                                        @endforeach
                                    </div>
                                    <span class="d-inline-block align-middle">{{ $product_details->avg_rate }} {{ __('Overall rating') }}</span>
                                </div>
                                <div class="col-lg-8 col-md-7">
                                    @php
                                        $rate_count = $product_details->ratings->count();
                                        $progressbar_color = ['#f34770', '#fea569', '#ffda75', '#a7e453', '#42d697'];
                                    @endphp
                                    @foreach (range(5, 1) as $star)
                                        @php
                                            $rate_one_count = $product_details->ratings->where('rate', $star)->count();
                                            $percent = 0;
                                            if ($product_details->ratings->count() > 0)
                                                $percent = $rate_one_count / $rate_count * 100;
                                        @endphp
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="text-nowrap me-3"><span class="d-inline-block align-middle text-muted">{{ $star }}</span><i class="fa fa-star fs-xs ms-1 text-warning"></i></div>
                                            <div class="w-100">
                                                <div class="progress" style="height: 4px; margin: 0;">
                                                    <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%; background-color: {{ $progressbar_color[$star-1] }};" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div><span class="text-muted ms-3">{{ $rate_one_count }}</span>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            <div class="col-6 row pb-3">
                                <!-- Reviews list-->
                                <div class="col-md-12">
                                    <!-- Review-->
                                    @if ($product_ratings->isNotEmpty())
                                        @foreach ($product_ratings as $rating)
                                            <div class="product-review pb-4 mb-4 border-bottom">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="d-flex align-items-center me-4 pe-2">
                                                        <i class="fa fa-user-circle-o fa-3x" aria-hidden="true"></i>
                                                        <div class="ps-3">
                                                            <h6 class="fs-sm mb-0">{{ $rating->user->name }}</h6>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="star-rating text-warning">
                                                            {!! rating_star($rating->rate) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="fs-md mb-2">{{ $rating->comment }}</p>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="alert alert-info" role="alert">{{ __('Empty Rating') }}</div>
                                    @endif

                                    <div class="text-center">
                                        {{ $product_ratings->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Product Thumbnail Tab Content End -->
            </div>
        </div>
        <!-- Row End -->
    </div>
    <!-- Container End -->
</div>

<!-- Product Thumbnail Description End -->
<!-- Realted Products Start Here -->
<div class="hot-deal-products off-white-bg pt-100 pb-90 pt-sm-60 pb-sm-50">
    <div class="container">
       <!-- Product Title Start -->
       <div class="post-title pb-30">
           <h2>{{ __('Related Product') }}</h2>
       </div>
       <!-- Product Title End -->
        <!-- Hot Deal Product Activation Start -->
        <div class="hot-deal-active owl-carousel">
            <!-- Single Product Start -->
            @foreach($related_products as $sptt)
                <div class="single-product">
                    <a href="sosanh" id="pagesosanh{{ $sptt->id }}" style="visibility: hidden;"></a>
                    <input type="hidden" id="wishList_product_name{{ $sptt->id }}" value="{{ $sptt->title }}" >
                    <input type="hidden" id="wishList_price{{ $sptt->id }}" value="{{ ($sptt->promotion_price == 0) ? currency_format($sptt->price) : currency_format($sptt->promotion_price) }}" >

                    <input type="hidden" id="instock{{ $sptt->id }}" value="{{ ($sptt->quantity >= $sptt->sold) ? __('In stock') : __('Out stock') }}">
                     <input type="hidden" id="mota{{ $sptt->id }}" value="{{ $sptt->specifications }}">
                    <!-- Product Image Start -->
                    <div class="pro-img">
                        <a id="wishList_producturl{{ $sptt->id }}" href="{{ route('products.details', ['slug' => $sptt->slug, 'id' => $sptt->id]) }}">
                            <img id="wishList_image{{ $sptt->id }}" class="primary-img" src="{{ $sptt->images[0]->url }}" alt="single-product" height="226px" width="226px">
                            <img id="wishList_image{{ $sptt->id }}" class="secondary-img" src="{{ $sptt->images[0]->url }}" alt="single-product" height="226px" width="226px">
                        </a>
                        <a href="#" class="quick_view" data-toggle="modal" data-target="#myModal_{{ $sptt->id }}" title="Quick View"><i class="lnr lnr-magnifier"></i></a>
                    </div>
                    <!-- Product Image End -->
                    <!-- Product Content Start -->
                    <div class="pro-content">
                        <div class="pro-info">
                            <h4><a href="{{ route('products.details', ['slug' => $sptt->slug, 'id' => $sptt->id]) }}">{{ $sptt->multisp }}</a></h4>
                            @if ($sptt->promotion_price == 0)
                                <span class="price">{{ currency_format($sptt->price) }}</span>
                            @else
                                <span class="price">{{ currency_format($sptt->promotion_price) }}</span>
                                <span class="prev-price">{{ currency_format($sptt->price) }}</span>
                            @endif
                        </div>
                        <div class="pro-actions">
                            <div class="actions-primary">
                                @if ($sptt->quantity > 0)
                                    <a id="addcart{{ $sptt->id }}" href="" title="{{ __('Add to cart') }}"> + {{ __('Add to cart') }}
                                    </a>
                                @else
                                    <a id="addcart{{ $sptt->id }}" class="disabled-link">
                                        + {{ __('Add to cart') }}
                                    </a>
                                @endif
                            </div>
                            <div class="actions-secondary">
                                <a style="cursor: pointer;" id="{{ $sptt->id }}" onclick="add_Compare(this.id)" title="{{ __('Compare') }}"><i class="lnr lnr-sync"></i> <span>{{ __('Compare') }}</span></a>
                                <a href="wishlist.html" title="{{ __('Wishlist') }}"><i class="lnr lnr-heart"></i> <span>{{ __('Wishlist') }}</span></a>
                            </div>
                        </div>
                    </div>
                    <!-- Product Content End -->
                    @if($sptt->promotion_price != 0)
                    <span class="sticker-new">{{ __('Sale') }}</span>
                    @endif
                </div>
            @endforeach
            <!-- Single Product End -->
        </div>
        <!-- Hot Deal Product Active End -->

    </div>
    <!-- Container End -->
</div>
<!-- Realated Products End Here -->
@endsection
