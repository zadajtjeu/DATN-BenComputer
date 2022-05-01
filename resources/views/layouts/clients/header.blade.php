<!DOCTYPE html>
<html lang="vi" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, maximum-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <!--SeoMeta-->
    <meta name="description" content="@yield('description', 'Cửa Hàng Máy Tính LapTop Chuyên Nghiệp')" />
    <meta name="author" content="{{ config('app.name', 'Ben Computer') }}">
    <meta name="copyright" content="{{ config('app.name', 'Ben Computer') }}">

    <title>{{ config('app.name', 'Ben Computer') }} - @yield('title', 'Cửa Hàng Máy Tính LapTop Chuyên Nghiệp')</title>

    <!-- SEO -->
    <!--OpenGraph-->
    <meta property="og:title" content="{{ config('app.name', 'Ben Computer') }} - @yield('title', 'Cửa Hàng Máy Tính Laptop Chuyên Nghiệp')" />
    <meta property="og:description" content="@yield('description', 'Cửa Hàng Máy Tính LapTop Chuyên Nghiệp')" />
    <meta property="og:url" content="@yield('canonical', url()->current())" />
    <meta property="og:image" content="@yield('images', asset('themes/images/logo.png'))" />
    <meta property="og:site_name" content="{{ config('app.name', 'Ben Computer') }}" />
    <meta property="og:type" content="Website" />
    <meta property="og:locale" content="vi_VN" />

    <link rel="canonical" href='@yield('canonical', url()->current())' />

    <!-- Fontawesome css -->
    <link rel="stylesheet" href="{{ asset('templates/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons css -->
    <link rel="stylesheet" href="{{ asset('templates/Ionicons/css/ionicons.min.css') }}">
    <!-- linearicons css -->
    <link rel="stylesheet" href="{{ asset('templates/linearicons/dist/web-font/style.css') }}">
    <!-- Nice select css -->
    <link rel="stylesheet" href="{{ asset('templates/jquery-nice-select/css/nice-select.css') }}">
    <!-- Jquery fancybox css -->
    <link rel="stylesheet" href="{{ asset('templates/fancybox/dist/jquery.fancybox.css') }}">
    <!-- Jquery ui price slider css -->
    <link rel="stylesheet" href="{{ asset('templates/jquery-ui/themes/smoothness/jquery-ui.min.css') }}">
    <!-- Meanmenu css -->
    <link rel="stylesheet" href="{{ asset('css/meanmenu.css') }}">
    <!-- Nivo slider css -->
    <link rel="stylesheet" href="{{ asset('templates/nivo-slider/nivo-slider.css') }}">
    <!-- Owl carousel css -->
    <link rel="stylesheet" href="{{ asset('templates/owl.carousel/dist/assets/owl.carousel.min.css') }}">
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="{{ asset('templates/bootstrap/dist/css/bootstrap.css') }}">
    <!--link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}"-->
    <!-- Custom css -->
    <link rel="stylesheet" href="{{ asset('css/default.css') }}">
    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Responsive css -->
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- Modernizer js -->
    <script src="{{ asset('js/modernizr.js') }}"></script>
    <!-- Notification -->
    <script src="{{ asset('templates/toastr/toastr.js') }}"></script>


</head>
