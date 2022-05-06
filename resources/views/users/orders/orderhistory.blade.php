@extends('layouts.app')

@section('title') {{ __('Order History') }} @endsection

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
                    <div class="card-header p-3">{{ __('Order History') }}</div>
                    <div class="card-body p-0">
                        <div class="table-content table-responsive mb-1">
                            @if ($orders->isNotEmpty())
                                <table>
                                    <thead>
                                        <tr>
                                            <th>{{ __('Order') }}</th>
                                            <th>{{ __('Total') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Payment') }}</th>
                                            <th>{{ __('Date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td><a href="{{ route('user.orderdetails', $order->id) }}" class="font-weight-bold">#{{ $order->order_code }}</a></td>
                                                <td class="text-warning font-weight-light">{{ currency_format($order->promotion_price) }}</td>
                                                <td>
                                                    @if ($order->status == App\Enums\OrderStatus::NEW_ORDER)
                                                        <span class="text-secondary">{{ __('New Order') }}</span>
                                                    @elseif ($order->status == App\Enums\OrderStatus::IN_PROCCESS)
                                                        <span class="text-warning">{{ __('In Proccess') }}</span>
                                                    @elseif ($order->status == App\Enums\OrderStatus::IN_SHIPPING)
                                                        <span class="text-info">{{ __('In Shipping') }}</span>
                                                    @elseif ($order->status == App\Enums\OrderStatus::COMPLETED)
                                                        <span class="text-success">{{ __('Delivery Completed') }}</span>
                                                    @elseif ($order->status == App\Enums\OrderStatus::CANCELED)
                                                        <span class="text-danger">{{ __('Order Canceled') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($order->payment == 'online')
                                                        @if ($order->payment_status == App\Enums\PaymentStatus::SUCCESS)
                                                            <span class="badge bg-success">{{ __('Success') }}</span>
                                                        @elseif ($order->payment_status == App\Enums\PaymentStatus::PROCCESSING)
                                                            <span class="badge bg-info">{{ __('Processing') }}</span>
                                                        @elseif ($order->payment_status == App\Enums\PaymentStatus::FAIL)
                                                            <span class="badge bg-danger">{{ __('Failed') }}</span>
                                                        @endif
                                                    @else
                                                        <span>{{ $order->payment }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="float-right pt-2"> {{ $orders->links() }} </div>
                            @else
                                <div class="alert alert-info"> {{ __('Empty') }}</div>
                            @endif
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
