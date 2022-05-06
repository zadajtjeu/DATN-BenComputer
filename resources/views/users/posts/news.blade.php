@extends('layouts.app')

@section('title') {{ __('News') }} @endsection

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-area mt-30">
    <div class="container">
        <div class="breadcrumb">
            <ul class="d-flex align-items-center">
                <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li><a href="{{ route('posts.news') }}">{{ __('News') }}</a></li>
                @if (!empty($postType))
                    @php
                       $cate = $postType;
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
            <div class="row">
                @php
                    $posts->load('thumbnail');
                    $posts->load('postType');
                @endphp
                @forelse ($posts as $post)
                    <!-- Single Blog Start -->
                    <div class="col-lg-6 col-sm-12">
                        <div class="single-latest-blog">
                            <div class="blog-img">
                                <a href="{{ route('posts.details', $post->slug) }}"><img src="{{ isset($post->thumbnail) ? $post->thumbnail->url : 'https://i.ibb.co/TgF9hCQ/image.png' }}" style="max-height: 214px;" alt="{{ $post->title }}"></a>
                            </div>
                            <div class="blog-desc">
                                <h4><a href="{{ route('posts.details', $post->slug) }}">{{ $post->title }}</a></h4>
                                <ul class="meta-box d-flex">
                                    <li><a href="{{ route('posts.type', $post->postType->slug) }}">{{ $post->postType->name }}</a></li>
                                </ul>
                                <p>{{ Str::words(strip_tags($post->description), 20) }}</p>
                                <a class="readmore" href="{{ route('posts.details', $post->slug) }}">{{ __('Read More') }}</a>
                            </div>
                            <div class="blog-date">{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</div>
                        </div>
                    </div>
                    <!-- Single Blog End -->
                @empty
                    <div class="alert alert-info col-12">{{ __('Empty') }}</div>
                @endforelse
            </div>
            <!-- Row End -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="pro-pagination">
                        <ul class="blog-pagination">
                            {{ $posts->links() }}
                        </ul>
                        <div class="product-pagination">
                            <span class="grid-item-list">{{ __('Showing :from to :to of :total (:page Pages)', ['from' => $posts->perPage() * ($posts->currentPage() - 1) + 1, 'to' => $posts->perPage() * $posts->currentPage() < $posts->total() ? $posts->perPage() * $posts->currentPage() : $posts->total(), 'total' => $posts->total(), 'page' => $posts->lastPage()]) }}</span>
                        </div>
                    </div>
                    <!-- Product Pagination Info -->
                </div>
            </div>
            <!-- Row End -->
        </div>
    </div>
    <!-- Container End -->
</div>
@endsection
