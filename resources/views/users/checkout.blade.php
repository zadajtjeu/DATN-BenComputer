@extends('layouts.app')

@section('title') {{ __('Checkout') }} @endsection

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
        <div class="row">
            <div class="col-md-12">
                <div class="coupon-accordion">
                    <!-- ACCORDION START -->
                    @if(!Session::get('voucher') && Session::has('cart'))
                        <h3>{{ __('Have a voucher') }}? <span id="showcoupon">{{ __('Click here to enter your code') }}</span></h3>
                        <div id="checkout_coupon" class="coupon-checkout-content">
                            <div class="coupon-info">
                                <form method="post" action="{{ route('cart.voucher') }}">
                                    @csrf
                                    <p class="checkout-coupon">
                                        <input type="text" class="code" name="code" placeholder="{{ __('Voucher') }}" />
                                        <input type="submit" name="check_coupon" value="{{ __('Appy Voucher') }}" />
                                    </p>
                                </form>
                            </div>
                        </div>
                    @endif
                    <!-- ACCORDION END -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- coupon-area end -->
<!-- checkout-area start -->
<div class="checkout-area pb-100 pt-15 pb-sm-60">
    <div class="container">
        <form action="{{ route('checkout.form') }}" method="post" class="beta-form-checkout">
            @csrf
            <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="checkbox-form mb-sm-40">
                            <h3>{{ __('Checkout Details') }}</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="checkout-form-list mb-30">
                                        <label for="customer_name">{{ __('Full Name') }} <span class="required">*</span></label>
                                        <input id="customer_name" type="text" class="form-control @error('customer_name') is-invalid @enderror" name="customer_name" value="{{ old('customer_name') ?? auth()->user()->name }}" required>
                                        @error('customer_name')
                                            <div class="form-text invalid-feedback" role="alert">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="checkout-form-list mb-30">
                                        <label for="phone">{{ __('Phone') }} <span class="required">*</span></label>
                                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') ?? auth()->user()->phone }}" required>
                                        @error('phone')
                                            <div class="form-text invalid-feedback" role="alert">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="checkout-form-list mb-30">
                                        <label for="province_id">{{ __('Province') }} <span class="required">*</span></label>
                                        <select id="province_id" class="form-control @error('province_id') is-invalid @enderror" name="province_id" required>
                                            <option> {{ __('None') }}</option>
                                        </select>
                                        @error('province_id')
                                            <div class="form-text invalid-feedback" role="alert">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="checkout-form-list mb-30">
                                        <label for="district_id">{{ __('District') }} <span class="required">*</span></label>
                                        <select id="district_id" class="form-control @error('district_id') is-invalid @enderror" name="district_id" required>
                                            <option> {{ __('None') }}</option>
                                        </select>
                                        @error('district_id')
                                            <div class="form-text invalid-feedback" role="alert">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="checkout-form-list mb-30">
                                        <label for="ward_id">{{ __('Ward') }} <span class="required">*</span></label>
                                        <select id="ward_id" class="form-control @error('ward_id') is-invalid @enderror" name="ward_id" required>
                                            <option> {{ __('None') }}</option>
                                        </select>
                                        @error('ward_id')
                                            <div class="form-text invalid-feedback" role="alert">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="checkout-form-list mb-30">
                                        <label for="address">{{ __('Address') }} <span class="required">*</span></label>
                                        <textarea id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" required>{{ old('address') }}</textarea>
                                        @error('address')
                                            <div class="form-text invalid-feedback" role="alert">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="different-address">
                                <div class="order-notes">
                                    <div class="checkout-form-list mb-30">
                                        <label>{{ __('Note') }}</label>
                                        <textarea id="note" name="note" cols="30" rows="10" placeholder="{{ __('Note') }}"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="your-order">
                            <h3>{{ __('Your Order') }}</h3>
                            <div class="your-order-table table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product-name">{{ __('Product') }}</th>
                                            <th class="product-total">{{ __('Price') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(Session::has('cart'))
                                        @foreach($products as $cart_item)
                                        <tr class="cart_item">
                                            <td class="product-name">
                                                {{ $cart_item->title }} <span class="product-quantity"> × {{ Session::get('cart')[$cart_item->id]->selected_quantity }}</span>
                                            </td>
                                            <td class="product-total">

                                                <span class="amount">{{ ($cart_item->promotion_price == 0) ? currency_format($cart_item->price * Session::get('cart')[$cart_item->id]->selected_quantity) : currency_format($cart_item->promotion_price * Session::get('cart')[$cart_item->id]->selected_quantity) }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>

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
                                    </tfoot>
                                </table>
                            </div>
                            <div class="payment-method">
                                <div id="accordion">
                                    <div class="card">
                                        <div class="card-header" id="headingone">
                                            <h5 class="mb-0">
                                                @if(Session::has('pay'))
                                                    <a class="btn btn-link collapsed">{{ __('Payment Online') }}</a>
                                                @else
                                                    <a class="btn btn-link">{{ __('Place Order') }}</a>
                                                @endif
                                            </h5>
                                        </div>

                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingone" data-parent="#accordion">
                                            <div class="card-body">
                                                @if(Session::has('pay'))
                                                    <p>{{ __('We will redirect you to the online payment system') }}</p>
                                                @else
                                                    <p>{{ __('The store will send the order to your address, you will pay the delivery staff') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-body" >
                            @if(Session::has('cart'))
                                <div class="buttons-cart" style="text-align: center; width: 100%;">
                                    @if(Session::has('pay'))
                                        <button type="submit"><span>{{ __('Payment Online') }}</span></button>
                                    @else
                                        <input type="submit" value="{{ __('Place Order') }}">
                                    @endif
                                </div>
                            @else
                                <div class="buttons-cart" style="text-align: center; width: 100%;">
                                    <a href="{{ route('home') }}"><i class="fa fa-angle-left movleft"></i> {{ __('Continue Shopping') }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
            </div>
        </form>
    </div>
</div>
@endsection


@section('addjs')
<script>
    // File javascript để lấy dữ liệu tỉnh thành

    // Khai báo URL Controller của bạn ở đây
    var baseService = '{{ route('checkout.form') }}/json';
    var provinceUrl = baseService + "/provinces";
    var districtUrl = baseService + "/districts";
    var wardUrl = baseService + "/wards";
    $(document).ready(function () {
        // load danh sách country
        _getProvince();

        $("#province_id").on('change', function () {
            var id = $(this).val();
            if (id != undefined && id != '') {
                $("#district_id").html('<option>-- {{ __('Loading Data') }}--</option>');
                _getDistrict(id);
            }
        });
        $("#district_id").on('change', function () {
            var id = $(this).val();
            if (id != undefined && id != '') {
                $("#ward_id").html('<option>-- {{ __('Loading Data') }} --</option>');
                _getWard(id);
            }
        });
        $("#ward_id").on('change', function () {
            var provinceText = $("#province_id option:selected").text();
            var districtText = $("#district_id option:selected").text();
            var wardText = $("#ward_id option:selected").text();
            //var html = "Quốc gia: " + countryText + " Tỉnh thành: " + provinceText + " " + "Quận huyện: " + districtText + " " + "Xã phường: " + wardText;
            //html += "</br>Quê bạn thật là đẹp. Chúc mừng bạn!!!";
            //$("#divResult").html(html);
        });
    });
    // truyền id của country vào
    function _getProvince() {
        $.get(provinceUrl, function (data) {
            if (data != null && data != undefined && data.length) {
                var html = '';
                html += '<option>-- {{ __('Choose an item') }} --</option>';
                $.each(data, function (key, item) {
                    html += '<option value=' + item.id + '>' + item.type + ' ' + item.name + '</option>';
                });
                $("#province_id").html(html);
            }
        });
        $("#district_id").html('');
        $("#ward_id").html('');
    }
    // truyền id của province vào
    function _getDistrict(id) {
        $.get(districtUrl + "/" + id, function (data) {
            if (data != null && data != undefined && data.length) {
                var html = '';
                html += '<option>-- {{ __('Choose an item') }} --</option>';
                $.each(data, function (key, item) {
                    html += '<option value=' + item.id + '>' + item.type + ' ' + item.name + '</option>';
                });
                $("#district_id").html(html);
            }
        });
        $("#ward_id").html('');
    }
    // truyền id của district vào
    function _getWard(id) {
        $.get(wardUrl + "/" + id, function (data) {
            if (data != null && data != undefined && data.length) {
                var html = '';
                html += '<option>-- {{ __('Choose an item') }} --</option>';
                $.each(data, function (key, item) {
                    html += '<option value=' + item.id + '>' + item.type + ' ' + item.name + '</option>';
                });
                $("#ward_id").html(html);
            }
        });
    }
</script>
@endsection
