@extends('layouts.app')

@section('title') {{ __('Checkout Successfully') }} @endsection

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="active">{{ __('Checkout') }}</li>
            </ul>
        </div>
    </div>
    <!-- Container End -->
</div>
<!-- Breadcrumb End -->
<!-- coupon-area start -->
<div class="coupon-area pt-100 pt-sm-60">
    <div class="container">
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{{ __('Successfully') }}!</strong> {{ __('Checkout Successfully') }}!
        </div>
    </div>
</div>
<!-- coupon-area end -->
<!-- checkout-area start -->
<div class="checkout-area pb-100 pt-15 pb-sm-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <p class="col-12">{{ __('Your order has been successfully with Order Code') }}: <span class="badge bg-info">{{ $order->order_code }}</span></p>
                <img class="col-12" src="https://i.ibb.co/zXy2Qrd/image.png">

                <div class="buttons-cart">
                    <a href="{{ route('home') }}"><i class="fa fa-angle-left movleft"></i> {{ __('Continue Shopping') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
