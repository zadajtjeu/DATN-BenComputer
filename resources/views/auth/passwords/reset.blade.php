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
                <li class="active"><a href="#">{{ __('Reset Password') }}</a></li>
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
        <form class="form-register clearfix" action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <fieldset>
                <legend>{{ __('Your Personal Details') }}</legend>
                <div class="form-group d-md-flex align-items-md-center">
                    <label class="control-label col-md-2" for="email"><span class="require">*</span>{{ __('Email Address') }}</label>
                    <div class="col-md-10">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group d-md-flex align-items-md-center">
                    <label class="control-label col-md-2" for="password"><span class="require">*</span>{{ __('Password') }}:</label>
                    <div class="col-md-10">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="{{ __('Password') }}" required autocomplete="new-password" autofocus>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group d-md-flex align-items-md-center">
                    <label class="control-label col-md-2" for="password-confirm"><span class="require">*</span>{{ __('Confirm Password') }}</label>
                    <div class="col-md-10">
                        <input type="password" class="form-control" id="password-confirm" name="password_confirmation"placeholder="{{ __('Re-Enter Password') }}"  required autocomplete="new-password">
                    </div>
                </div>
            </fieldset>
            <div class="buttons newsletter-input">
                <div class="float-right float-sm-right">
                    <input type="submit" value="{{ __('Reset Password') }}" class="customer-btn">
                </div>
            </div>
        </form>
    </div>
    <!-- Container End -->
</div>
<!-- Register Account End -->

@endsection
