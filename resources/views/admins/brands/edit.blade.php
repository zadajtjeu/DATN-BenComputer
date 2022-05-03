@extends('layouts.admin')

@section('title') {{ __('Edit Brand') }} @endsection

@section('page_title')
{{ __('Edit Brand') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">{{ __('Brand Management') }}</li>
<li class="breadcrumb-item active">{{ __('Edit Brand') }}</li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">{{ __('Edit Brand') }}</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.brands.update', [$brand_edit->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="name"><span class="text-danger">*</span> {{ __('Brand name') }}</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $brand_edit->name) }}" required onkeyup="ChangeToSlug()">
                        @error('name')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">{{ __('The name is how it appears on your site') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="slug">{{ __('Slug') }}</label>
                        <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $brand_edit->name) }}">
                        @error('slug')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">{{ __('The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens') }}</small>
                    </div>
                    <div class="form-group form-upload">
                        <label for="image"><span class="text-danger">*</span> {{ __('Image') }}</label>
                        <div class="form-upload__preview">
                            <div class="form-upload__item col-2 align-self-center">
                                <img class="img-fluid mb-2 form-upload__item-thumbnail" src="{{ $brand_edit->logo->url }}">
                            </div>
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
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    <input type="submit" value="{{ __('Update') }}" class="btn btn-success float-right">
                </form>
            </div>
        </div>
        <!-- /.card -->

    </div>
</div>
@endsection

@section('addjs')
    <script>
        function ChangeToSlug() {
            var value = $("input#name").val();
            $("input#slug").val(change_alias(value));
        }
    </script>
@endsection

