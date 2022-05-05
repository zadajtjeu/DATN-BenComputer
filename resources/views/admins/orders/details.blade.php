@extends('layouts.admin')

@section('title') {{ __('Order Details') }} @endsection

@section('page_title')
{{ __('Order Details') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">{{ __('Order Management') }}</li>
<li class="breadcrumb-item active">{{ __('Order Details') }}</li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header ui-sortable-handle">
                <h3 class="card-title">
                    <i class="fas fa-user-tag"></i>
                    {{ __('Order Details') }}
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="list-group">
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="title"> {{ __('Delivery Address') }}</h6>
                                <p class="font-italic">
                                    {{ $orderDetails->shipping->customer_name }} <br>
                                    {{ $orderDetails->shipping->phone }}
                                </p>
                                <p>
                                    {{ $orderDetails->shipping->address }} <br>
                                    {{ $orderDetails->shipping->ward->type }} {{ $orderDetails->shipping->ward->name }},
                                    {{ $orderDetails->shipping->district->type }} {{ $orderDetails->shipping->district->name }},
                                    {{ $orderDetails->shipping->province->type }} {{ $orderDetails->shipping->province->name }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center justify-content-between">
                                    @if ($orderDetails->status != App\Enums\OrderStatus::COMPLETED &&
                                        $orderDetails->status != App\Enums\OrderStatus::CANCELED)
                                        <form class="col-auto row align-items-center" action="{{ route('admin.orders.cancel', $orderDetails->id)}}" method="post">
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
                                </div>

                                @if (!empty($orderDetails->note))
                                    <div class="text-muted"> ({{ $orderDetails->note }}) </div>
                                @endif

                                @if (!empty($orderDetails->processUser))
                                    <div class="alert alert-info mt-3">
                                        {{ __('Processed by :username', ['username' => $orderDetails->processUser->name]) }} ({{ $orderDetails->processUser->email }})
                                    </div>
                                @endif
                            </div>
                            <!-- end col -->
                        </div>
                    </div>
                    <div class="list-group-item">
                        @if ($orderDetails->orderItems->isNotEmpty())
                            @php
                                $orderDetails->orderItems->load('product');
                            @endphp
                            <div class="cart-item-list">
                                @foreach ($orderDetails->orderItems as $item)
                                    @php
                                        $product = $item->product;
                                    @endphp
                                    <div class="row col-12">
                                        <a title="{{ $product->title }}" href="{{ route('products.details', [$product->slug, $product->id]) }}" class="product-image-container col-2 text-decoration-none">
                                            <img alt="{{ $product->title }}" src="{{ $product->images[0]->url }}" class="card-img-top">
                                        </a>
                                        <div class="product-details-content col-7 pr0">
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
                                        <div class="product-price fs18 col-3">
                                            <span class="text-danger">{{ currency_format($item->buying_price) }}</span>
                                        </div>
                                    </div>
                                    <hr>
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
                                        <td class="pl-5">
                                            <span class="amount">{{ currency_format($orderDetails->total_price) }}</span>
                                        </td>
                                    </tr>
                                    @if (!empty($orderDetails->voucher_id))
                                        <tr class="cart-ordertotal">
                                            <th>{{ __('Voucher') }} [{{ $orderDetails->voucher->code }}] @if($orderDetails->voucher->condition == \App\Enums\VoucherCondition::PERCENT) ({{ $orderDetails->voucher->value }}%) @endif</th>
                                            <td class="pl-5">
                                                <span class="amount"> - {{ currency_format($orderDetails->total_price - $orderDetails->promotion_price) }}</span>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr class="cart-subtotal">
                                        <th>{{ __('Order Total') }}</th>
                                        <td class="pl-5">
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
                                    <form action="{{ route('admin.orders.cod', $orderDetails->id)}}" method="post">
                                        @csrf
                                        <button class="btn btn-sm btn-warning m-1" type="submit"> {{ __('Switch to COD') }}</button>
                                    </form>
                                </div>
                            @elseif ($orderDetails->payment_status == App\Enums\PaymentStatus::FAIL)
                                <span class="badge bg-danger">{{ __('Failed') }}</span>
                            @endif
                        @endif
                    </div>

                    @if ($orderDetails->status != \App\Enums\OrderStatus::CANCELED)
                        <div class="list-group-item">
                            <div class="row justify-content-between">
                                <div class="col-sm-8">
                                    <form action="{{ route('admin.orders.update', $orderDetails->id) }}" method="post">
                                       @csrf
                                       @method('PATCH')
                                       <div class="form-inline align-items-center">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">{{ __('Order status') }}</div>
                                                </div>
                                                <select class="form-control  @error('status') is-invalid @enderror" name="status" id="dbType">
                                                    <option id="status" value="{{ \App\Enums\OrderStatus::NEW_ORDER }}" @if ($orderDetails->status == \App\Enums\OrderStatus::NEW_ORDER) selected @endif>{{ __('New Order') }}</option>
                                                    <option id="status" value="{{ \App\Enums\OrderStatus::IN_PROCCESS }}" @if ($orderDetails->status == \App\Enums\OrderStatus::IN_PROCCESS) selected @endif>{{ __('In Proccess') }}</option>
                                                    <option id="status" value="{{ \App\Enums\OrderStatus::IN_SHIPPING }}" @if ($orderDetails->status == \App\Enums\OrderStatus::IN_SHIPPING) selected @endif>{{ __('In Shipping') }}</option>
                                                    <option id="status" value="{{ \App\Enums\OrderStatus::COMPLETED }}" @if ($orderDetails->status == \App\Enums\OrderStatus::COMPLETED) selected @endif>{{ __('Delivery Completed') }}</option>
                                                </select>
                                                @error('status')
                                                    <span class="error invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                           </div>
                                           <div class="input-group">
                                               <button class="btn btn-success" type="submit">
                                               {{ __('Update') }}
                                               </button>
                                           </div>
                                       </div>
                                   </form>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <a href="{{ route('admin.orders.print', $orderDetails->id) }}" rel="noreferrer noopener" target="_blank" class="btn btn-info">
                                        <i class="fas fa-print"></i>
                                        {{ __('Print') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>

    </div>
</div>
@endsection
