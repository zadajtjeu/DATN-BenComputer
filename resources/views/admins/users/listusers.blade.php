@extends('layouts.admin')

@section('title') {{ __('User Management') }} @endsection

@section('page_title')
{{ __('User Management') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active">{{ __('User Management') }}</li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header ui-sortable-handle">
                <h3 class="card-title">
                    <i class="fas fa-user-tag"></i>
                    {{ __('Users') }}
                </h3>
            </div>
            <div class="card-body p-1">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Address') }}</th>
                            <th class="text-center">{{ __('Role') }}</th>
                            <th class="text-center">{{ __('Status') }}</th>
                            <th class="text-center">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->isNotEmpty())
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>
                                        {{ $user->name }}
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                    <td>
                                        {{ $user->phone }}
                                    </td>
                                    <td>
                                        {{ $user->address }}
                                    </td>
                                    <td class="text-center">
                                        @if ($user->role == \App\Enums\UserRole::ADMIN)
                                            <i class="fas fa-user-secret text-warning" title="{{ __('Admin') }}"></i>
                                        @elseif ($user->role == \App\Enums\UserRole::MANAGER)
                                            <i class="fas fa-user-shield text-primary" title="{{ __('Manager') }}"></i>
                                        @else
                                            <i class="fas fa-user" title="{{ __('User') }}"></i>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if ($user->status == \App\Enums\UserStatus::BANNED)
                                            <i class="fas fa-user-lock text-danger" title="{{ __('Banned') }}"></i>
                                        @elseif ($user->status == \App\Enums\UserStatus::ACTIVE)
                                            <i class="fas fa-unlock-alt text-info" title="{{ __('Active') }}"></i>
                                        @endif
                                    </td>
                                    <td>

                                        @if ($user->role != App\Enums\UserRole::ADMIN)
                                            @if ($user->status == App\Enums\UserStatus::ACTIVE)
                                                <form class="list-inline-item" action="{{ route('admin.users.block', $user->id)}}" method="post">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="btn btn-xs btn-warning" type="submit" onclick="return confirm('{{ __('Comfirm Block') }}');"><i class="fas fa-lock"></i> {{ __('Block') }}</button>
                                                </form>
                                            @else
                                                <form class="list-inline-item" action="{{ route('admin.users.unblock', $user->id)}}" method="post">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="btn btn-xs btn-info" type="submit" onclick="return confirm('{{ __('Comfirm UnBlock') }}');"><i class="fas fa-unlock"></i> {{ __('UnBlock') }}</button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                                <div class="alert alert-primary" role="alert">{{ __('Empty') }}</div>
                        @endif
                    </tbody>
                </table>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>

    </div>
</div>
@endsection

