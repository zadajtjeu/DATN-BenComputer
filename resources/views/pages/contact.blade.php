@extends('layouts.app')
@section('title')
    {{ __('About') }}
@endsection
@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{route('home')}}">{{ trans('Home') }}</a></li>
                <li class="active">{{ trans('About') }}</li>
            </ul>
        </div>
    </div>
    <!-- Container End -->
</div>
<!-- Breadcrumb End -->
<!-- Contact Email Area Start -->
<div class="contact-area ptb-100 ptb-sm-60">
    <div class="container">
        <h3 class="mb-20">{{ trans('Contact') }}</h3>
        <p class="text-capitalize mb-20"></p><br>
        <form id="contact-form" class="contact-form" action="{{route('home')}}" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="address-wrapper row">
                <div class="col-md-12">
                    <div class="address-fname">
                        <input class="form-control" type="text" name="name" placeholder="{{ trans('Name') }}">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="address-email">
                        <input class="form-control" type="email" name="email" placeholder="Email">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="address-textarea">
                        <textarea name="content" class="form-control" placeholder="{{ trans('Text') }}"></textarea>
                    </div>
                </div>
            </div>
            <p class="form-message"></p>
            <div class="footer-content mail-content clearfix">
                <div class="send-email float-md-right">
                    <input value="{{ trans('Send') }}" class="return-customer-btn" type="submit">
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Contact Email Area End -->
<!-- Google Map Start -->
<div class="goole-map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125317.66191195612!2d106.5869040563149!3d11.025348113916458!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174d17273d88fa1%3A0x4ce77ac2d75e8e4c!2zVHAuIFRo4bunIEThuqd1IE3hu5l0LCBCw6xuaCBExrDGoW5nLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2sus!4v1605159415568!5m2!1svi!2sus" id="map" style="height:400px; width: 100%"></iframe>
</div>
<!-- Google Map End -->
@endsection
