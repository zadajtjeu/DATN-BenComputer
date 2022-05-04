@extends('layouts.app')

@section('title') {{ __('Cart') }} @endsection

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="active"><a href="{{ route('cart.index') }}">{{ __('Cart') }}</a></li>
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
                    @if(Session::has('message_success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>{{ __('Successfully') }}!</strong> {{ Session::get('message_success') }}!
                        </div>
                    @elseif(Session::has('message_error'))
                        <div class="alert alert-danger  alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>{{ __('Failed') }}!</strong> {{ Session::get('message_error') }}!
                        </div>
                    @endif
                    @if (!empty($messages))
                        @foreach ($messages as $message)
                            <div class="alert alert-danger  alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{ $message }}!
                            </div>
                        @endforeach
                    @endif
                    <!-- Table Content Start -->
                    <div class="table-content table-responsive mb-45">
                        <table>
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">{{ __('Image') }}</th>
                                    <th class="product-name">{{ __('Title') }}</th>
                                    <th class="product-price">{{ __('Price') }}</th>
                                    <th class="product-quantity">{{ __('Quantity') }}</th>
                                    <th class="product-quantity">{{ __('Status') }}</th>
                                    <th class="product-subtotal">{{ __('Subtotal') }}</th>
                                    <th class="product-remove">{{ __('Edit') }}</th>
                                </tr>
                            </thead>
                            @if(Session::has('cart'))
                                <tbody>
                                    @forelse ($products as $cart_item)
                                    <tr>
                                        <td class="product-thumbnail">
                                            <a href="{{ route('products.details', ['slug' => $cart_item->slug, 'id' => $cart_item->id]) }}"><img src="{{ empty($cart_item->images) ? '' : $cart_item->images[0]->url }}" alt="{{ $cart_item->title }}" height="101.6px" width="101.6px" /></a>
                                        </td>
                                        <td class="product-name"><a href="{{ route('products.details', ['slug' => $cart_item->slug, 'id' => $cart_item->id]) }}">{{ $cart_item->title }}</a></td>
                                        <td class="product-price">
                                            <span class="amount">
                                                {{ ($cart_item->promotion_price == 0) ? currency_format($cart_item->price) : currency_format($cart_item->promotion_price) }}
                                            </span>
                                        </td>
                                        <td class="product-quantity" style="text-align: center;">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <a class="input-group-text" href="{{ route('cart.minus', [$cart_item->id]) }}"><i class="fa fa-minus"></i></a>
                                                </div>
                                                <input type="number" class="form-control" value="{{ Session::get('cart')[$cart_item->id]->selected_quantity }}" min="1" max="{{ $cart_item->quantity }}" style="text-align: center;" readonly>
                                                <div class="input-group-prepend">
                                                    <a class="input-group-text" href="{{ route('cart.add', [$cart_item->id]) }}"><i class="fa fa-plus"></i></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="product-status">{{ ($cart_item->quantity > 0) ? __('In stock') : __('Out stock') }}</td>
                                        <td class="product-subtotal">{{ ($cart_item->promotion_price == 0) ? currency_format($cart_item->price * Session::get('cart')[$cart_item->id]->selected_quantity) : currency_format($cart_item->promotion_price * Session::get('cart')[$cart_item->id]->selected_quantity) }}</td>
                                        <td class="product-remove"> <a href="{{ route('cart.delete', $cart_item->id) }}"><i class="fa fa-times" aria-hidden="true"></i></a></td>
                                    </tr>
                                   @empty
                                   @endforelse
                                </tbody>
                            @endif
                        </table>
                    </div>
                    <!-- Table Content Start -->
                    <div class="row">
                       <!-- Cart Button Start -->

                        <div class="col-md-8 col-sm-12">
                            @if(!Session::has('voucher'))
                                <form method="post" action="{{ route('cart.voucher') }}">
                                    <div class="buttons-cart">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" name="code" placeholder="{{ __('Voucher') }}" class="form-control @error('code') is-invalid @enderror" style="background: #fff; border: 1px solid #000; text-transform: none;color: #000" required>
                                            @error('code')
                                                <span class="error invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <input type="submit" value="{{ __('Appy Voucher') }}">
                                        </div>

                                    </div>
                                </form>
                            @else
                                <form method="post" action="{{ route('cart.voucher.delete') }}">
                                    <div class="buttons-cart">
                                        @csrf
                                        @method('DELETE')
                                        <div class="form-group">
                                            <input type="submit" value="{{ __('Delete Voucher') }} ({{ Session::get('voucher')->code }})">
                                        </div>

                                    </div>
                                </form>
                            @endif
                            <div class="buttons-cart">
                                <a href="{{ route('home') }}"><i class="fa fa-angle-left movleft"></i> {{ __('Continue Shopping') }}</a>
                            </div>
                        </div>
                        <!-- Cart Button Start -->
                        <!-- Cart Totals Start -->
                        <div class="col-md-4 col-sm-12">
                            <div class="cart_totals float-md-right text-md-right">
                                <h2>{{ __('Cart Totals') }}</h2>
                                <br />
                                <table class="float-md-right">
                                    <tbody>
                                        <tr class="cart-subtotal">
                                            <th>{{ __('Subtotal') }}</th>
                                            <td>
                                                <span class="amount">{{ currency_format($subtotals) }}</span>
                                            </td>
                                        </tr>
                                        @if (Session::has('voucher'))
                                            <tr class="cart-subtotal">
                                                <th>{{ __('Voucher') }} @if($voucher->condition == \App\Enums\VoucherCondition::PERCENT) ({{ $voucher->value }}%) @endif</th>
                                                <td>
                                                    -<span class="amount">{{ currency_format($coupon) }} </span>
                                                </td>
                                            </tr>
                                        @endif
                                        <tr class="cart-ordertotal">
                                            <th>{{ __('Total') }}</th>
                                            <td>
                                                <span class="amount">{{ currency_format($totals) }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="wc-proceed-to-checkout">
                                    <form action="{{ route('cart.checkout') }}" method="post">
                                        @csrf
                                        <button type="submit">{{ __('Ship COD') }}</button>
                                        <button type="submit" name="method" value="online">{{ __('Oneline Payment') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Cart Totals End -->
                    </div>
                    <!-- Row End -->
                </div>
            </div>
         <!-- Row End -->
    </div>
</div>
<!-- Cart Main Area End -->
@endsection
