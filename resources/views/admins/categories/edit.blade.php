@extends('layouts.admin')

@section('title') {{ __('Edit Category') }} @endsection

@section('page_title')
{{ __('Edit Category') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">{{ __('Category Management') }}</li>
<li class="breadcrumb-item active">{{ __('Edit Category') }}</li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">{{ __('Edit Category') }}</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.categories.update', [$category_edit->id]) }}">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category_edit->name) }}" required onkeyup="ChangeToSlug()">
                        @error('name')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">{{ __('The name is how it appears on your site') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="slug">{{ __('Slug') }}</label>
                        <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $category_edit->slug) }}">
                        @error('slug')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">{{ __('The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="parent">{{ __('Parent Category') }}</label>
                        <select id="parent" name="parent_id" class="form-control custom-select @error('parent_id') is-invalid @enderror" required>
                            <option value='0'>———Default———</option>
                            @foreach ($categories as $key => $category)
                                @if ($category->id == $category_edit->id)
                                    @continue
                                @endif
                                @include('layouts.admins.components.categoryoption', ['subcategory' => $category, 'prefix' => ''])
                            @endforeach
                        </select>
                        @error('parent_id')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">{{ __('Categories can have a hierarchy. You might have a Jazz category, and under that have children categories for Bebop and Big Band. Totally optional') }}</small>
                    </div>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
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
        function change_alias(alias) {
            var str = alias;
            str= str.toLowerCase();
            str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");
            str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");
            str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");
            str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ợ|ở|ỡ|ớ/g,"o");
            str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");
            str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");
            str= str.replace(/đ/g,"d");
            str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-");
            /* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */
            str = str.replace(/\-\-\-\-\-/gi, '-');
            str = str.replace(/\-\-\-\-/gi, '-');
            str = str.replace(/\-\-\-/gi, '-');
            str = str.replace(/\-\-/gi, '-');
            str= str.replace(/-+-/g,"-"); //thay thế 2- thành 1-
            str= str.replace(/^\-+|\-+$/g,"");
            //cắt bỏ ký tự - ở đầu và cuối chuỗi
            return str;
        }

        function ChangeToSlug() {
            var value = $("input#name").val();
            $("input#slug").val(change_alias(value));
        }
    </script>
@endsection
