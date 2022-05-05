@extends('layouts.admin')

@section('title') {{ __('Order Management') }} @endsection

@section('page_title')
{{ __('Order Management') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active">{{ __('Order Management') }}</li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header ui-sortable-handle">
                <h3 class="card-title">
                    <i class="fas fa-user-tag"></i>
                    {{ __('Orders') }}
                </h3>
            </div>
            <div class="card-body p-1">
                @if ($orders->isNotEmpty())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Order') }}</th>
                                <th>{{ __('Total') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Payment') }}</th>
                                <th>{{ __('User') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $orders->load('orderItems');
                                $orders->load('user');
                            @endphp
                            @foreach ($orders as $key => $order)
                                <tr>
                                    <td><a href="{{ route('admin.orders.details', $order->id) }}" class="font-weight-bold">#{{ $order->order_code }}</a></td>
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
                                    <td>{{ $order->user->email }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}</td>
                                    <td><a href="{{ route('admin.orders.details', $order->id) }}" class="btn btn-success">{{ __('Process') }}</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="card-footer clearfix">
                        {{ $orders->links() }}
                    </div>
                @else
                        <div class="alert alert-primary" role="alert">{{ __('Empty') }}</div>
                @endif
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.card -->
    </div>

    </div>
</div>
@endsection
