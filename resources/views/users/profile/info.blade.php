@extends('layouts.app')

@section('title') {{ __('Order History') }} @endsection

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="active"><a href="{{ route('profile') }}">{{ __('Profile') }}</a></li>
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
            <div class="col-lg-4 col-sm-12">
                <ul class="list-group">
                  <li class="list-group-item">
                    <a href="{{ route('profile') }}">{{ __('My Account') }}</a>
                  </li>
                  <li class="list-group-item">
                    <a href="#">{{ __('Edit profile') }}</a>
                  </li>
                  <li class="list-group-item">
                    <a href="#">{{ __('Change password') }}</a>
                  </li>
                  <li class="list-group-item">
                    <a href="{{ route('user.orderhistory') }}">{{ __('Order History') }}</a>
                  </li>
                </ul>
            </div>
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <div class="card-header p-3">{{ __('Profile') }}</div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">{{ __('Full Name') }}</label>
                                <p class="mt-2 text-secondary">
                                    <i class="fa fa-star mr-1" aria-hidden="true"></i>
                                    {{ $user->name }}
                                </p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">{{ __('Email') }}</label>
                                <p class="mt-2 text-secondary">
                                    <i class="fa fa-envelope-o mr-1" aria-hidden="true"></i>
                                    {{ $user->email }}
                                </p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="labels">{{ __('Phone') }}</label>
                                <p class="mt-2 text-secondary">
                                    <i class="fa fa-phone mr-1" aria-hidden="true"></i>
                                    {{ $user->phone }}
                                </p>
                            </div>
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
