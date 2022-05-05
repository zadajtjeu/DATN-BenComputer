@extends('layouts.admin')

@section('title') {{ __('Edit Voucher') }} @endsection

@section('page_title')
{{ __('Edit Voucher') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">{{ __('Voucher Management') }}</li>
<li class="breadcrumb-item active">{{ __('Edit Voucher') }}</li>
@endsection

@section('content')

<div class="row align-items-center justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">{{ __('Edit Voucher') }}</h3>
            </div>
            <div class="card-body">
                <form id="voucherUpdate" method="post" action="{{ route('admin.vouchers.update', $voucher->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="title"><span class="text-danger">*</span> {{ __('Title') }}</label>
                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $voucher->title) }}" required>
                        @error('title')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="code"><span class="text-danger">*</span> {{ __('Voucher Code') }}</label>
                        <input type="text" id="code" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $voucher->code) }}" required style="text-transform: uppercase">
                        @error('code')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="quantity"><span class="text-danger">*</span> {{ __('Quantity') }}</label>
                        <input type="number" id="quantity" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $voucher->quantity) }}" required min="1" onkeyup="imposeMinMax(this)">
                        @error('quantity')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="start_date"><span class="text-danger">*</span> {{ __('Start Date') }}</label>
                        <div class="input-group date @error('start_date') is-invalid @enderror" id="start_date" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#start_date" name="start_date" value="{{ old('start_date') }}" required/>
                            <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        @error('start_date')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="end_date"><span class="text-danger">*</span> {{ __('End Date') }}</label>
                        <div class="input-group date @error('end_date') is-invalid @enderror" id="end_date" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#end_date" name="end_date" value="{{ old('end_date') }}" required/>
                            <div class="input-group-append" data-target="#end_date" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        @error('end_date')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="@error('condition') is-invalid @enderror"><span class="text-danger">*</span> {{ __('Type') }}</label>
                                <div class="form-check">
                                    <input id="percent" class="form-check-input" type="radio" name="condition" value="{{ \App\Enums\VoucherCondition::PERCENT }}" {{ old('condition', $voucher->condition) == \App\Enums\VoucherCondition::PERCENT ? 'checked' : '' }} onclick="percent_select()">
                                    <label class="form-check-label" for="percent">{{ __('Decrease By Percentage') }}</label>
                                </div>
                                <div class="form-check">
                                    <input id="amount" class="form-check-input" type="radio" name="condition" {{ old('condition', $voucher->condition) == \App\Enums\VoucherCondition::AMOUNT ? 'checked' : '' }} value="{{ \App\Enums\VoucherCondition::AMOUNT }}" onclick="amount_select()">
                                    <label class="form-check-label" for="amount">{{ __('Decrease By Amount') }}</label>
                                </div>
                                @error('condition')
                                    <span class="error invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="value"><span class="text-danger">*</span> {{ __('Amount or Percentage') }}</label>
                                <input type="number" id="value" name="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value', $voucher->value) }}" min="1" {!! old('condition', $voucher->condition) == \App\Enums\VoucherCondition::PERCENT ? 'max="100"' : '' !!} required onkeyup="imposeMinMax(this)">
                                @error('value')
                                    <span class="error invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>

                <input type="submit" form="voucherUpdate" value="{{ __('Update') }}" class="btn btn-success" onclick="!this.form && document.getElementById('voucherUpdate').submit()">

                @if ($voucher->status == \App\Enums\VoucherStatus::AVAILABLE)
                    <form class="float-right" style="display: inline;" action="{{ route('admin.vouchers.block', $voucher->id)}}" method="post">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-warning" type="submit"><i class="fas fa-lock"></i> {{ __('Block') }}</button>
                    </form>
                @elseif ($voucher->status == \App\Enums\VoucherStatus::BLOCK)
                    <form class="float-right style="display: inline;" action="{{ route('admin.vouchers.unblock', $voucher->id)}}" method="post">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-info" type="submit"><i class="fas fa-lock-open"></i> {{ __('Unblock') }}</button>
                    </form>
                @endif
            </div>
        </div>
        <!-- /.card -->

    </div>
</div>
@endsection

@section('addjs')
    <script src="{{ asset('templates/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
    $(function () {
        $('#start_date').datetimepicker({
            icons: {
                time: "fas fa-clock",
                date: "far fa-calendar",
                up: "fas fa-arrow-up",
                down: "fas fa-arrow-down"
            },
            date: new Date('{{ $voucher->start_date }}'),
            locale: '{{ config('app.locale') }}'
        });
        $('#end_date').datetimepicker({
            useCurrent: false,
            icons: {
                time: "fas fa-clock",
                date: "far fa-calendar",
                up: "fas fa-arrow-up",
                down: "fas fa-arrow-down"
            },
            date: new Date('{{ $voucher->end_date }}'),
            locale: '{{ config('app.locale') }}'
        });
        $("#start_date").on("change.datetimepicker", function (e) {
            $('#end_date').datetimepicker('minDate', e.date);
        });
        $("#end_date").on("change.datetimepicker", function (e) {
            $('#start_date').datetimepicker('maxDate', e.date);
        });

        function validateCode(event) {
           var value = String.fromCharCode(event.which);
           var pattern = new RegExp(/^[A-Za-z0-9]*$/);
           return pattern.test(value);
        }

        $('#code').bind('keypress', validateCode);

    });

    function percent_select() {
        $("#value").attr({"max" : 100, "min" : 1});
    }
    function amount_select() {
        $("#value").attr({"max" : "", "min" : 1});
    }
    function imposeMinMax(el){
        if(el.value != ""){
            if(parseInt(el.value) < parseInt(el.min)){
                el.value = el.min;
            }
            if(parseInt(el.value) > parseInt(el.max) && el.max > 0){
                el.value = el.max;
            }
        }
    }
</script>
@endsection
