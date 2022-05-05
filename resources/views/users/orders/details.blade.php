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
                <li class="active"><a href="{{ route('user.orderhistory') }}">{{ __('Order History') }}</a></li>
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
                    <div class="card-header p-3">{{ __('Order Details') }}</div>
                    <div class="card-body p-0">
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="title"> {{ __('Delivery Address') }}</h6>
                                        <p class="font-italic">{{ $orderDetails->shipping->customer_name }}</p>
                                        <p class="font-italic">{{ $orderDetails->shipping->phone }}</p>
                                        <p>
                                            {{ $orderDetails->shipping->address }} <br>
                                            {{ $orderDetails->shipping->ward->type }} {{ $orderDetails->shipping->ward->name }},
                                            {{ $orderDetails->shipping->district->type }} {{ $orderDetails->shipping->district->name }},
                                            {{ $orderDetails->shipping->province->type }} {{ $orderDetails->shipping->province->name }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row align-items-center justify-content-between">
                                            @if ($orderDetails->status == App\Enums\OrderStatus::NEW_ORDER ||
                                                $orderDetails->status == App\Enums\OrderStatus::IN_PROCCESS)
                                                <form class="col-auto row align-items-center" action="{{ route('user.ordercancel', $orderDetails->id)}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="col-auto">
                                                        <input class="form-control" type="text" name="reason_canceled" placeholder="{{ __('Reason cancel') }}">
                                                    </div>
                                                    <div class="col-auto">
                                                        <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('{{ __('Comfirm Cancel') }}');"><i class="fas fa-trash-alt"></i> {{ __('Cancel') }}</button>
                                                    </div>
                                                </form>
                                            @endif
                                            <div class="col-auto">
                                                @if ($orderDetails->status == App\Enums\OrderStatus::NEW_ORDER)
                                                    <span class="badge bg-secondary">{{ __('New Order') }}</span>
                                                @elseif ($orderDetails->status == App\Enums\OrderStatus::IN_PROCCESS)
                                                    <span class="badge bg-warning">{{ __('In Proccess') }}</span>
                                                @elseif ($orderDetails->status == App\Enums\OrderStatus::IN_SHIPPING)
                                                    <span class="badge bg-info">{{ __('In Shipping') }}</span>
                                                @elseif ($orderDetails->status == App\Enums\OrderStatus::COMPLETED)
                                                    <span class="badge bg-success">{{ __('Delivery Completed') }}</span>
                                                @elseif ($orderDetails->status == App\Enums\OrderStatus::CANCELED)
                                                    <span class="badge bg-danger">{{ __('Order Canceled') }}</span>
                                                @endif
                                            </div>

                                            @if (!empty($orderDetails->note))
                                                <span class="text-muted"> ({{ $orderDetails->note }}) </span>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                            </div>
                            <div class="list-group-item p-0">
                                @if ($orderDetails->orderItems->isNotEmpty())
                                    @php
                                        $orderDetails->orderItems->load('product');
                                    @endphp
                                    <div class="cart-item-list">
                                        @foreach ($orderDetails->orderItems as $item)
                                            @php
                                                $product = $item->product;
                                            @endphp
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
                                                    <div class="row justify-content-end col-12 no-padding no-margin">
                                                        <div class="product-price">
                                                            <span>x{{ $item->quantity }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-price fs18 col-lg-3 col-sm-3 row">
                                                    <span class="text-danger col-6 col-sm-12">{{ currency_format($item->buying_price) }}</span>

                                                    @if ($orderDetails->status == App\Enums\OrderStatus::COMPLETED)
                                                        <div class="col-6 col-sm-12">
                                                            <a class="btn btn-warning" href="{{ route('user.rate', [$item->id]) }}"><i class="fa fa-star" aria-hidden="true"></i> {{ $item->rate_status == App\Enums\RateStatus::ALLOW ? __('Rate') : __('View Rate') }}</a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="alert alert-info">{{ __('Order Empty') }}</div>
                                @endif
                            </div>
                            <div class="list-group-item">
                                <div class="cart_totals float-md-right text-md-right">
                                    <table class="float-md-right">
                                        <tbody>
                                            <tr class="cart-subtotal">
                                                <th>{{ __('Subtotal') }}</th>
                                                <td>
                                                    <span class="amount">{{ currency_format($orderDetails->total_price) }}</span>
                                                </td>
                                            </tr>
                                            @if ($orderDetails->total_price > $orderDetails->promotion_price)
                                                <tr class="cart-ordertotal">
                                                    <th>{{ __('Voucher') }}</th>
                                                    <td>
                                                        <span class="amount"> - {{ currency_format($orderDetails->total_price - $orderDetails->promotion_price) }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr class="cart-subtotal">
                                                <th>{{ __('Order Total') }}</th>
                                                <td>
                                                    <span class="amount text-warning font-text-bold">{{ currency_format($orderDetails->promotion_price) }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="list-group-item text-right">
                                @if ($orderDetails->payment == 'COD')
                                    {{ __('Please pay :money upon delivery', ['money' => currency_format($orderDetails->promotion_price)]) }}
                                    <i class="fa fa-money text-danger" aria-hidden="true"></i>
                                @elseif ($orderDetails->payment == 'online')
                                     <i class="fa fa-credit-card text-success" aria-hidden="true"></i> {{ __('Online Payment') }}
                                    @if ($orderDetails->payment_status == App\Enums\PaymentStatus::SUCCESS)
                                        <span class="badge bg-success">{{ __('Success') }}</span>
                                    @elseif ($orderDetails->payment_status == App\Enums\PaymentStatus::PROCCESSING)
                                        <span class="badge bg-warning">{{ __('Processing') }}</span><p class="text-danger">{{ __('We request you to pay your bills at least 1 business days before the payment due date') }}</p>
                                        <div class="row align-items-center justify-content-end">
                                            <form action="{{ route('user.orderrepay', $orderDetails->id)}}" method="post">
                                                @csrf
                                                <button class="btn btn-sm btn-info m-1" type="submit"> {{ __('Retry Payment') }}</button>
                                            </form>
                                            <form action="{{ route('user.ordercod', $orderDetails->id)}}" method="post">
                                                @csrf
                                                <button class="btn btn-sm btn-warning m-1" type="submit"> {{ __('Switch to COD') }}</button>
                                            </form>
                                        </div>
                                    @elseif ($orderDetails->payment_status == App\Enums\PaymentStatus::FAIL)
                                        <span class="badge bg-danger">{{ __('Failed') }}</span>
                                    @endif
                                @endif
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
