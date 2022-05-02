@extends('layouts.app')

@section('title')
{{ __('Confirm Password') }}
@endsection

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li><a href="{{ route('login') }}">{{ __('Password') }}</a></li>
                <li class="active"><a href="#">{{ __('Confirm Password') }}</a></li>
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
            <h3 class="mb-10 custom-title">{{ __('Confirm Password') }}</h3>
        </div>

        <div class="alert alert-warning" role="alert">
            {{ __('Please confirm your password before continuing.') }}
        </div>
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="form-group d-md-flex">
                <label class="control-label col-md-2" for="password"><span class="require">*</span>{{ __('Password') }}</label>
                <div class="col-md-10">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" autofocus>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="buttons newsletter-input">
                <div class="float-left float-sm-left">
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                </div>
                <div class="float-right float-sm-right">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Confirm Password') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!-- Container End -->
</div>
<!-- Register Account End -->

@endsection
