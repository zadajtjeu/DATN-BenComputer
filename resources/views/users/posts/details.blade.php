@extends('layouts.app')

@section('title') {{ __('News') }} @endsection

@section('description') {{ Str::words(strip_tags($post->description), 20) }} @endsection

@section('images'){{ isset($post->thumbnail) ? $post->thumbnail->url : asset('themes/images/logo.png') }}@endsection
@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li><a href="{{ route('posts.news') }}">{{ __('News') }}</a></li>
                @if (!empty($post->postType))
                    @php
                       $cate = $post->postType;
                       $list_cate = '<li class="active"><a href="' . route('posts.type', ['slug' => $cate->slug]) . '">' . $cate->name . '</a></li>';
                    @endphp
                    @while(!$cate->isParent())
                        @php
                           $cate = $cate->parent;
                           $list_cate = '<li><a href="' . route('posts.type', ['slug' => $cate->slug]) . '">' . $cate->name . '</a></li>' . $list_cate;
                        @endphp
                    @endwhile
                    {!! $list_cate !!}
                @endif
            </ul>
        </div>
    </div>
    <!-- Container End -->
</div>
<!-- Breadcrumb End -->
<div class="blog ptb-20  ptb-sm-60">
    <div class="container">
        <div class="main-blog">
            <div class="row justify-content-center">
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="single-sidebar-desc mb-all-40">
                        <div class="sidebar-img">
                            <img src="{{ isset($post->thumbnail) ? $post->thumbnail->url : 'https://i.ibb.co/TgF9hCQ/image.png' }}" alt="{{ $post->title }}">
                        </div>
                        <div class="sidebar-post-content">
                            <h3 class="sidebar-lg-title">{{ $post->title }}</h3>
                            <ul class="post-meta d-sm-inline-flex">
                                <li><span>{{ __('Writer') }}</span> {{ $post->user->name }}</li>
                                <li><span> {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span></li>
                            </ul>
                        </div>
                        <article class="sidebar-desc mb-50">{!! $post->content !!}</article>
                    </div>
                </div>
            </div>
            <!-- Row End -->
        </div>
    </div>
    <!-- Container End -->
</div>
@endsection
