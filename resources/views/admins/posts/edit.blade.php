@extends('layouts.admin')

@section('title') {{ __('Edit Post') }} @endsection

@section('page_title')
{{ __('Edit Post') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">{{ __('Post Management') }}</li>
<li class="breadcrumb-item active">{{ __('Edit Post') }}</li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">{{ __('Edit Post') }}</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.posts.update', $post->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="title"><span class="text-danger">*</span> {{ __('Title') }}</label>
                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}" required onkeyup="ChangeToSlug()">
                        @error('title')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">{{ __('The name is how it appears on your site') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="slug">{{ __('Slug') }}</label>
                        <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $post->slug) }}">
                        @error('slug')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">{{ __('The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens') }}</small>
                    </div>

                    <div class="form-group">
                        <label for="post_type_id"><span class="text-danger">*</span> {{ __('Post Type') }}</label>
                        <select id="post_type_id" name="post_type_id" class="form-control custom-select @error('post_type_id') is-invalid @enderror" required>
                            @foreach ($postTypes as $key => $category)
                                @include('layouts.admins.components.categoryoptionchoose', ['subcategory' => $category, 'prefix' => '', 'old_cate' => old('post_type_id', $post->post_type_id)])
                            @endforeach
                        </select>
                        @error('post_type_id')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <input type="text" id="description" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description', $post->description) }}">
                        @error('description')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="content"><span class="text-danger">*</span> {{ __('Content') }}</label>
                        <textarea id="content" name="content" class="form-control">{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group form-upload">
                        <label for="image"><span class="text-danger">*</span> {{ __('Image') }}</label>
                        <div class="form-upload__preview">
                            @if ($post->thumbnail)
                                <div class="form-upload__item col-2 align-self-center">
                                    <img class="img-fluid mb-2 form-upload__item-thumbnail" src="{{ $post->thumbnail->url }}">
                                </div>
                            @endif
                        </div>
                        <div class="custom-file @error('image') is-invalid @enderror">
                            <input type="file" class="form-upload__control js-form-upload-control custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                            <label class="custom-file-label" for="image">{{ __('Choose file') }}</label>
                        </div>
                        @error('image')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">{{ __('Choose your image file') }}</small>
                    </div>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    <input type="submit" value="{{ __('Update') }}" class="btn btn-success float-right">
                </form>
            </div>
        </div>
        <!-- /.card -->

    </div>
</div>
@endsection

@section('addjs')
    <script src="{{ asset('templates/ckeditor/ckeditor.js') }}"></script>
    <script>
        function ChangeToSlug() {
            var value = $("input#title").val();
            $("input#slug").val(change_alias(value));
        }
        $(document).ready(function() {
            CKEDITOR.replace('content');
        });
    </script>
@endsection

