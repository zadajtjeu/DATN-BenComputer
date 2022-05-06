@extends('layouts.admin')

@section('title') {{ __('Edit User') }} @endsection

@section('page_title')
{{ __('Edit User') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">{{ __('User Management') }}</li>
<li class="breadcrumb-item active">{{ __('Edit User') }}</li>
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">{{ __('Edit User') }}</h3>
            </div>
            <div class="card-body">
                <form id="userUpdate" method="post" action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="name"><span class="text-danger">*</span> {{ __('Name') }}</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email"><span class="text-danger">*</span> {{ __('Email') }}</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone"><span class="text-danger">*</span> {{ __('Phone') }}</label>
                        <input type="phone" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" required>
                        @error('phone')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">{{ __('Address') }}</label>
                        <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $user->address) }}">
                        @error('address')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <input type="submit" form="userUpdate" value="{{ __('Update') }}" class="btn btn-success">
                </form>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <div class="col-lg-5">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">{{ __('Reset Password') }}</h3>
            </div>
            <div class="card-body">
                <form id="userUpdate" method="post" action="{{ route('admin.users.password', $user->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="password"><span class="text-danger">*</span> {{ __('Password') }}</label>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" value="" required>
                        @error('password')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm"><span class="text-danger">*</span> {{ __('Confirm Password') }}</label>
                        <input type="password" id="password-confirm" name="password_confirmation" class="form-control" value="" required>
                    </div>

                    <input type="submit" value="{{ __('Reset Password') }}" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">{{ __('Edit Role') }}</h3>
            </div>
            <div class="card-body">
                <form id="userUpdate" method="post" action="{{ route('admin.users.role', $user->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <select class="form-control @error('role') is-invalid @enderror" name="role">
                          <option {{ old('role', $user->role) == \App\Enums\UserRole::ADMIN ? 'selected' : '' }} value="{{ \App\Enums\UserRole::ADMIN }}">{{ __('Admin') }}</option>
                          <option {{ old('role', $user->role) == \App\Enums\UserRole::MANAGER ? 'selected' : '' }} value="{{ \App\Enums\UserRole::MANAGER }}">{{ __('Manager') }}</option>
                          <option {{ old('role', $user->role) == \App\Enums\UserRole::USER ? 'selected' : '' }} value="{{ \App\Enums\UserRole::USER }}">{{ __('User') }}</option>
                        </select>

                        @error('role')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <input type="submit" value="{{ __('Update') }}" class="btn btn-info">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
