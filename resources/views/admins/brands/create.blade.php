@extends('layouts.admin')

@section('title') {{ __('Add New Brand') }} @endsection

@section('page_title')
{{ __('Add New Brand') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">{{ __('Brand Management') }}</li>
<li class="breadcrumb-item active">{{ __('Add New Brand') }}</li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">{{ __('Add New Brand') }}</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.brands.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name"><span class="text-danger">*</span> {{ __('Brand name') }}</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required onkeyup="ChangeToSlug()">
                        @error('name')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">{{ __('The name is how it appears on your site') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="slug">{{ __('Slug') }}</label>
                        <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}">
                        @error('slug')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">{{ __('The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens') }}</small>
                    </div>
                    <div class="form-group form-upload">
                        <label for="image"><span class="text-danger">*</span> {{ __('Image') }}</label>
                        <div class="form-upload__preview"></div>
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
                    <input type="submit" value="{{ __('Create') }}" class="btn btn-success float-right">
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

