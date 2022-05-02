@extends('layouts.app')

@section('title') {{ __('Reset Password') }} @endsection

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li><a href="{{ route('login') }}">{{ __('Password') }}</a></li>
                <li class="active"><a href="{{ route('password.request') }}">{{ __('Reset Password') }}</a></li>
            </ul>
        </div>
    </div>
    <!-- Container End -->
</div>
<!-- Breadcrumb End -->
<!-- Register Account Start -->
<div class="Lost-pass ptb-100 ptb-sm-60">
    <div class="container">
        <div class="register-title">
            <h3 class="mb-10 custom-title">{{ __('Reset Password') }}</h3>
        </div>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <form class="password-forgot clearfix" action="{{ route('password.email') }}" method="POST">
            @csrf
            <fieldset>
                <legend>{{ __('Your Personal Details') }}</legend>
                <div class="form-group d-md-flex">
                    <label class="control-label col-md-2" for="email"><span class="require">*</span>{{ __('Email Address') }}</label>
                    <div class="col-md-10">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </fieldset>
            <div class="buttons newsletter-input">
                <div class="float-left float-sm-left">
                    <a class="customer-btn mr-20" href="{{ route('login') }}">{{ __('Back') }}</a>
                </div>
                <div class="float-right float-sm-right">
                    <input type="submit" value="{{ __('Send Password Reset Link') }}" class="return-customer-btn">
                </div>
            </div>
        </form>
    </div>
    <!-- Container End -->
</div>
<!-- Register Account End -->

@endsection
