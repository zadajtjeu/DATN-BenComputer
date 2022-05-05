@extends('layouts.app')

@section('title') {{ __('Order Details') }} @endsection

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li><a href="{{ route('profile') }}">{{ __('Profile') }}</a></li>
                <li><a href="{{ route('user.orderhistory') }}">{{ __('Order') }}</a></li>
                <li class="active">{{ __('Rate') }}</li>
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
                <div class="card">
                    <div class="card-header p-3">{{ __('Rate') }}</div>
                    <div class="card-body p-0">
                        <div class="list-group">
                            <div class="list-group-item p-0">
                                @if (!empty($orderItem))
                                    @php
                                        $product = $orderItem->product;
                                    @endphp
                                    <div class="cart-item-list">
                                        <div class="row col-12 border m-0">
                                            <a title="{{ $product->title }}" href="{{ route('products.details', [$product->slug, $product->id]) }}" class="product-image-container col-lg-2 col-sm-3 text-decoration-none">
                                                <img alt="{{ $product->title }}" src="{{ $product->images[0]->url }}" class="card-img-top">
                                            </a>
                                            <div class="product-details-content col-lg-7 col-sm-6 pr0">
                                                <div class="row item-title no-margin">
                                                    <a href="{{ route('products.details', [$product->slug, $product->id]) }}" title="{{ $product->title }}" class="unset col-12 no-padding text-decoration-none">
                                                        <span class="fs20 fw6 link-color">{{ $product->title }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="product-price fs18 col-lg-3 col-sm-3 row">
                                                <span class="text-danger col-6 col-sm-12">{{ currency_format($orderItem->buying_price) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-info">{{ __('Order Empty') }}</div>
                                @endif
                            </div>
                            <div class="list-group-item">
                                <form class="needs-validation" method="post" action="{{ route('user.rate.create', $orderItem->id ) }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="comment">{{ __('Rate') }} <span class="text-danger">*</span></label>
                                        <textarea name="comment" placeholder="{{ __('Rate') }}" id="comment" class="form-control @error('comment') is-invalid @enderror">{{ old('comment', isset($orderItem->rating->comment) ? $orderItem->rating->comment : '') }}</textarea>
                                        @error('comment')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('rate') is-invalid @enderror">
                                        @foreach (range(5, 1) as $rate)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="rate" {{ $rate == old('rate', isset($orderItem->rating->rate) ? $orderItem->rating->rate : '5' ) ? 'checked' : '' }} value="{{ $rate }}" id="review-rating-{{ $rate }}">
                                                <label class="form-check-label rating" for="review-rating-{{ $rate }}"> {!! rating_star($rate) !!}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('rate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <button class="btn btn-success" type="submit">{{ __('Rate') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Row End -->
        </div>
    </div>
</div>
<!-- Cart Main Area End -->
@endsection
