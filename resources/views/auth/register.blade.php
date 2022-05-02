@extends('layouts.app')

@section('title')
{{ __('Sign Up') }}
@endsection

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="active"><a href="{{ route('register') }}">{{ __('Sign Up') }}</a></li>
            </ul>
        </div>
    </div>
    <!-- Container End -->
</div>
<!-- Breadcrumb End -->
<!-- Register Account Start -->
<div class="register-account ptb-100 ptb-sm-60">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="register-title">
                    <h3 class="mb-10">{{ __('Sign Up') }}</h3>
                    <p class="mb-10">{{ __('If you already have an account with us, please') }} <a href="{{ route('login') }}">{{ __('Sign In') }}</a></p>
                </div>
            </div>
        </div>
        <!-- Row End -->
        <div class="row">
            <div class="col-sm-12">
                <form class="form-register" method="POST" action="{{ route('register') }}">
                    @csrf
                    <fieldset>
                        <legend>{{ __('Your Personal Details') }}</legend>
                        <div class="form-group d-md-flex align-items-md-center">
                            <label class="control-label col-md-2" for="name"><span class="require">*</span>{{ __('Full Name') }}</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="{{ __('Full Name') }}" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group d-md-flex align-items-md-center">
                            <label class="control-label col-md-2" for="email"><span class="require">*</span>{{ __('Email') }}</label>
                            <div class="col-md-10">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="{{ __('Email Address') }}" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group d-md-flex align-items-md-center">
                            <label class="control-label col-md-2" for="phone"><span class="require">*</span>{{ __('Phone Number') }}</label>
                            <div class="col-md-10">
                                <input type="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="{{ __('Phone Number') }}" value="{{ old('phone') }}" required autocomplete="phone">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group d-md-flex align-items-md-center">
                            <label class="control-label col-md-2" for="address"><span class="require">*</span>{{ __('Address') }}</label>
                            <div class="col-md-10">
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="{{ __('Address') }}" required autocomplete="address">{{ old('address') }}</textarea>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>{{ __('Your Password') }}</legend>
                        <div class="form-group d-md-flex align-items-md-center">
                            <label class="control-label col-md-2" for="password"><span class="require">*</span>{{ __('Password') }}:</label>
                            <div class="col-md-10">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="{{ __('Password') }}" required autocomplete="new-password">
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

                    <div class="terms">
                        <div class="float-md-right">
                            <input type="submit" value="{{ __('Sign Up') }}" class="return-customer-btn">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Row End -->
    </div>
    <!-- Container End -->
</div>
<!-- Register Account End -->
@endsection
