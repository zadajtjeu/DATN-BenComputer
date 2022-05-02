@extends('layouts.app')
@section('title')
{{ __('Sign In') }}
@endsection

@section('content')

<!-- Breadcrumb Start -->
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="active"><a href="{{ route('login') }}">{{ __('Sign in') }}</a></li>
            </ul>
        </div>
    </div>
    <!-- Container End -->
</div>
<!-- Breadcrumb End -->
<!-- LogIn Page Start -->
<div class="log-in ptb-100 ptb-sm-60">

    <div class="container">
        <div class="row">
            <!-- New Customer Start -->
            <div class="col-md-6">
                <div class="well mb-sm-30">
                    <div class="new-customer">
                        <h3 class="custom-title">{{ __('Sign up') }}</h3>
                        <p class="mtb-10"><strong></strong></p>
                        <p>{{ __('By creating an account you will be able to shop faster, be up to date on an order status, and eep track of the orders you have previously made.') }}</p>
                        <a class="customer-btn" href="{{ route('register') }}">{{ __('Sign Up Now') }}</a>
                    </div>
                </div>
            </div>
            <!-- New Customer End -->
            <!-- Returning Customer Start -->
            <div class="col-md-6">
                <div class="well">
                    <div class="return-customer">
                        <h3 class="mb-10 custom-title">{{ __('Sign In') }}</h3>
                        <p class="mtb-10"><strong></strong></p>
                        <form id="loginForm" method="POST" action="{{ route('login') }}" >
                            @csrf
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input type="text" name="email" placeholder="{{ __('Email') }}" id="input-email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group" id="show_hide_password">
                                <label for="password">{{ __('Password') }}</label>
                                <div class="input-group mb-3">
                                    <input type="password" name="password" placeholder="{{ __('Password') }}" id="input-password" class="form-control @error('password') is-invalid @enderror"  required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="btnPassword"><i id="icon_span" class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <p class="lost-password">
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                </p>
                            @endif

                            <input type="submit" value="{{ __('Login') }}" class="return-customer-btn" style="width: 100%;height: 45px;">
                            <p style="text-align: center;margin-top: 10px; margin-bottom: -7px;">{{ __('Or') }}</p>
                            <div>
                                <p class="return-customer-btn google">
                                    <a href="{{ url('/login-google') }}">
                                        <i class="fa fa-google" aria-hidden="true"></i> Google
                                    </a>
                                </p>
                            </div>

                        </form>
                        <style type="text/css">
                            .google{
                                width: 100%;
                                height: 45px;
                                background: #fff;
                                border: 1px solid #222222;
                            }
                            .google a{
                                color: #000;
                            }
                            .google a:hover{
                                color: #fff;
                            }
                        </style>
                    </div>
                </div>
            </div>
            <!-- Returning Customer End -->
        </div>
        <!-- Row End -->
    </div>
    <!-- Container End -->
</div>
<!-- LogIn Page End -->
<script type="text/javascript">
    let showPassword = false

    const ipnElement = document.querySelector('#input-password')
    const btnElement = document.querySelector('#btnPassword')
    const iconElement = document.querySelector('#icon_span')

    btnElement.addEventListener('click', function() {
      if (showPassword) {
        // Đang hiện password
        // Chuyển sang ẩn password
        iconElement.setAttribute('class', 'fa fa-eye-slash')
        ipnElement.setAttribute('type', 'password')
        showPassword = false
      } else {
        // Đang ẩn password
        // Chuyển sang hiện password
        iconElement.setAttribute('class', 'fa fa-eye')
        ipnElement.setAttribute('type', 'text')
        showPassword = true
      }
    })
</script>
@endsection
