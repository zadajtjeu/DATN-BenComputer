@extends('layouts.admin')

@section('title') {{ __('Post Management') }} @endsection

@section('page_title')
{{ __('Post Management') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active">{{ __('Post Management') }}</li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header ui-sortable-handle">
                <h3 class="card-title">
                    <i class="fas fa-user-tag"></i>
                    {{ __('Posts') }}
                </h3>
            </div>
            <div class="card-body p-1">
                <div class="card-tools text-right">
                    <a href="{{ route('admin.posts.create')}}" class="btn btn-success my-2">{{ __('Create') }}</a>
                </div>
                @if ($posts->isNotEmpty())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Thumbnail') }}</th>
                                <th width="40%">{{ __('Title') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Post Type') }}</th>
                                <th>{{ __('Writer') }}</th>
                                <th>{{ __('Created at') }}</th>
                                <th class="btn-action">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $posts->load('thumbnail');
                                $posts->load('postType');
                                $posts->load('user');
                            @endphp
                            @foreach ($posts as $key => $post)
                                <tr>
                                    <td>
                                        @if ($post->thumbnail)
                                            <img class="profile-user-img" src="{{ $post->thumbnail->url }}" alt="{{ $post->title }}">
                                        @else
                                            <img class="profile-user-img" src="{{ asset('templates/adminlte/dist/img/default-150x150.png') }}" alt="{{ $post->title }}">
                                        @endif
                                    </td>
                                    <td><a href="{{ route('posts.details', ['slug' => $post->slug]) }}">{{ $post->title }}</a></td>
                                    <td>
                                        {{ \Illuminate\Support\Str::limit($post->description, 150, $end='...') }}
                                    </td>
                                    <td>
                                        {{ $post->postType->name }}
                                    </td>
                                    <td>
                                        {{ $post->user->name }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</td>

                                    <td>
                                        <a href="{{ route('admin.posts.edit', $post->id)}}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>

                                        <form style="display: inline;" action="{{ route('admin.posts.destroy', $post->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('{{ __('Comfirm Delete') }}');">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                        <div class="alert alert-primary" role="alert">{{ __('Empty') }}</div>
                @endif
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>

    </div>
</div>
@endsection
