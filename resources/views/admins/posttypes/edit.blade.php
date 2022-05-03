@extends('layouts.admin')

@section('title') {{ __('Edit Post Type') }} @endsection

@section('page_title')
{{ __('Edit Post Type') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">{{ __('Post Type Management') }}</li>
<li class="breadcrumb-item active">{{ __('Edit Post Type') }}</li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">{{ __('Edit Post Type') }}</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.posttypes.update', [$posttype_edit->id]) }}">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="name"><span class="text-danger">*</span> {{ __('Name') }}</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $posttype_edit->name) }}" required onkeyup="ChangeToSlug()">
                        @error('name')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">{{ __('The name is how it appears on your site') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="slug">{{ __('Slug') }}</label>
                        <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $posttype_edit->slug) }}">
                        @error('slug')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">{{ __('The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="parent"><span class="text-danger">*</span> {{ __('Parent Post Type') }}</label>
                        <select id="parent" name="parent_id" class="form-control custom-select @error('parent_id') is-invalid @enderror" required>
                            <option value='0'>———{{ __('None') }}———</option>
                            @foreach ($postTypes as $key => $posttype)
                                @if ($posttype->id == $posttype_edit->id)
                                    @continue
                                @endif
                                @include('layouts.admins.components.posttypeoption', ['subposttype' => $posttype, 'prefix' => ''])
                            @endforeach
                        </select>
                        @error('parent_id')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">{{ __('Categories can have a hierarchy. You might have a Jazz category, and under that have children categories for Bebop and Big Band. Totally optional') }}</small>
                    </div>
                    <a href="{{ route('admin.posttypes.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
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
