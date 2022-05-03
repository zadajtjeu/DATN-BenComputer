@extends('layouts.admin')

@section('title') {{ __('Edit Product') }} @endsection

@section('page_title')
{{ __('Edit Product') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">{{ __('Product Management') }}</li>
<li class="breadcrumb-item active">{{ __('Edit Product') }}</li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">{{ __('Edit Product') }}</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.products.update', [$product->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="title"><span class="text-danger">*</span> {{ __('Title') }}</label>
                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $product->title) }}" required onkeyup="ChangeToSlug()">
                        @error('title')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">{{ __('The name is how it appears on your site') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="slug">{{ __('Slug') }}</label>
                        <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $product->slug) }}">
                        @error('slug')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">{{ __('The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="quantity"><span class="text-danger">*</span> {{ __('Quantity') }}</label>
                        <input type="number" id="quantity" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $product->quantity) }}" required>
                        @error('quantity')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price"><span class="text-danger">*</span> {{ __('Price') }}</label>
                        <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
                        @error('price')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="promotion_price">{{ __('Promotion Price') }}</label>
                        <input type="number" id="promotion_price" name="promotion_price" class="form-control @error('promotion_price') is-invalid @enderror" value="{{ old('promotion_price', $product->promotion_price) }}">
                        @error('promotion_price')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="brand_id"><span class="text-danger">*</span> {{ __('Brand') }}</label>
                        <select id="brand_id" name="brand_id" class="form-control custom-select @error('brand_id') is-invalid @enderror" required>
                            @foreach ($brands as $key => $brand) {
                                <option @if ($brand->id == old('brand_id', $product->brand_id)) selected @endif value="{{ $brand->id }}"> {{ $brand->name }}</option>
                            }
                            @endforeach
                        </select>
                        @error('brand_id')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="category_id"><span class="text-danger">*</span> {{ __('Category') }}</label>
                        <select id="category_id" name="category_id" class="form-control custom-select @error('category_id') is-invalid @enderror" required>
                            @foreach ($categories as $key => $category)
                                @include('layouts.admins.components.categoryoptionchoose', ['subcategory' => $category, 'prefix' => '', 'old_cate' => old('category_id', $product->category_id)])
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="content"><span class="text-danger">*</span> {{ __('Details') }}</label>
                        <textarea id="content" name="content" class="form-control">{{ old('content', $product->content) }}</textarea>
                        @error('content')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="specifications"><span class="text-danger">*</span> {{ __('Specifications') }}</label>
                        <textarea id="specifications" name="specifications" class="form-control">{{ old('specifications', $product->specifications) }}</textarea>
                        @error('specifications')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group form-upload">
                        <label for="image">{{ __('Image') }}</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image[]" accept="image/*" multiple>
                        @error('image')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">{{ __('Choose your image file') }}. {{ __('Multiple select') }}</small>
                        <div id="image_preview"></div>
                    </div>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    <input type="submit" value="{{ __('Update') }}" class="btn btn-success float-right">
                </form>
            </div>
        </div>
        <!-- /.card -->
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">{{ __('Old Image') }}</h3>
            </div>
            <div class="card-body">
                @php
                    $product->load('images')
                @endphp
                @if ($product->images->isNotEmpty())
                    <div class="row">
                        @foreach ($product->images as $image)
                            <div class="col-lg-2 col-md-4">
                                <form method="post" action="{{ route('admin.products.deleteImage', [$product->id, $image->id]) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"class="btn text-danger"><i class="far fa-trash-alt"></i></button>
                                </form>
                                <img src="{{ $image->url }}" width="200px" height="200px">
                            </div>
                        @endforeach
                    </div>
                @endif
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
        var checkNumber = function(event) {
            if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
                event.preventDefault();
            }
        }
        $(document).ready(function() {
            CKEDITOR.replace('content');
            CKEDITOR.replace('specifications');
        });

        $(function() {
            $("input[name='image[]']").on('change', function(event) {
                var files = event.target.files;
                const html = document.createElement("div");
                for (i = 0; i < files.length; i++) {
                    var image = files[i]
                    var reader = new FileReader();
                    reader.onload = function(file) {
                        var img = new Image();
                        img.src = file.target.result;
                        img.className = "col-md-2";
                        html.append(img);
                    }
                    reader.readAsDataURL(image);
                };
                $('#image_preview').html(html).slideDown();
            });
        });
    </script>
@endsection

