@extends('layouts.admin')

@section('title') {{ __('Brands Management') }} @endsection

@section('page_title')
{{ __('Brands Management') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active">{{ __('Brands Management') }}</li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header ui-sortable-handle">
                <h3 class="card-title">
                    <i class="fas fa-user-tag"></i>
                    {{ __('Brands') }}
                </h3>
                <div class="card-tools">
                    <a href="{{ route('admin.brands.create')}}" class="btn btn-success my-2">{{ __('Create') }}</a>
                </div>
            </div>
            <div class="card-body p-1">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Image') }}</th>
                            <th class="btn-action" width="25%">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($brands->isNotEmpty())
                        @php $brands->load('logo') @endphp
                            @foreach ($brands as $key => $brand)
                                <tr>
                                    <td class="font-weight-bold">{{ $brand->name }}</td>
                                    <td><img height="30px" src="{{ $brand->logo->url }}"></td>
                                    <td>
                                        <a href="{{ route('admin.brands.edit', $brand->id)}}" class="btn btn-primary">{{ __('Edit') }}</a>

                                        <form style="display: inline;" action="{{ route('admin.brands.destroy', $brand->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit" onclick="return confirm('{{ __('Comfirm Delete') }}');">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                                <div class="alert alert-primary" role="alert">{{ __('Empty brands') }}</div>
                        @endif
                    </tbody>
                </table>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $brands->links() }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>

    </div>
</div>
@endsection
