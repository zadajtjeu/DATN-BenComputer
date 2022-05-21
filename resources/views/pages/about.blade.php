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
<!-- About Area Start -->
<div class="contact-area ptb-100 ptb-sm-60">
    <div class="container">
        <h1 class="mb-20"><span id="Gioi_thieu_cong_ty">Giới thiệu công ty</span></h1>
        <hr>
        <h2 class="mb-20"><span id="LICH_SU_HINH_THANH_PHAT_TRIEN">LỊCH SỬ HÌNH THÀNH &amp; PHÁT TRIỂN</span></h2>
        <div class="mb-20">
            <p>Công ty Cổ Phần Bền ( Ben Computer ) được thành lập năm 2001 với sở hữu thương hiệu Ben được Bộ khoa học công nghệ cấp giấy chứng nhận số 42378 ngày 25 tháng 07 năm 2002.</p>
            <p>Ben Computer là một Công ty hoạt động trong lĩnh vực kinh doanh Notebook, PC nguyên chiếc, lắp ráp máy tính thương hiệu Ben và phân phối các sản phẩm CNTT. Sau 20 năm nỗ lực xây dựng và phát triển, Ben Computer đã thu được nhiều thành công, xây dựng được hệ thống khách hàng và đối tác trên toàn quốc, được khách hàng và đối tác biết đến như một Công ty máy tính chuyên nghiệp, uy tín hàng đầu tại Việt Nam.</p>
            <p>Hiện nay, Ben Computer đã là đối tác của các hãng công nghệ toàn cầu và các nhà phân phối lớn như: Dell, Intel, IBM, HP, Lenovo, Sony, Samsung, LG, Toshiba, Acer, AMP, Apple,…</p>
        </div>

    </div>
</div>
<!-- About Area End -->
@endsection
