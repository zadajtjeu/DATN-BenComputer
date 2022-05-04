@extends('layouts.admin')

@section('title') {{ __('Product Management') }} @endsection

@section('page_title')
{{ __('Product Management') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active">{{ __('Product Management') }}</li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header ui-sortable-handle">
                <h3 class="card-title">
                    <i class="fas fa-user-tag"></i>
                    {{ __('Products') }}
                </h3>
                <div class="card-tools">
                    <a href="{{ route('admin.products.create')}}" class="btn btn-success my-2">{{ __('Create') }}</a>
                </div>
            </div>
            <div class="card-body p-1">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('Image') }}</th>
                            <th width="40%">{{ __('Title') }}</th>
                            <th>{{ __('Quantity') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Brand') }}</th>
                            <th>{{ __('Rate') }}</th>
                            <th class="btn-action">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($products->isNotEmpty())
                            @php
                                $products->load('images');
                                $products->load('brand.logo');
                                $products->load('category');
                            @endphp
                            @foreach ($products as $key => $product)
                                <tr>
                                    <td>
                                        @if ($product->images->isNotEmpty())
                                            <img class="profile-user-img" src="{{ $product->images[0]->url }}" alt="{{ $product->title }}">
                                        @else
                                            <img class="profile-user-img" src="{{ asset('templates/adminlte/dist/img/default-150x150.png') }}" alt="{{ $product->title }}">
                                        @endif
                                    </td>
                                    <td><a href="{{ route('products.details', ['slug' => $product->slug, 'id' => $product->id]) }}">{{ $product->title }}</a></td>
                                    <td>
                                        @if ($product->quantity > 0)
                                            {{ $product->quantity }}
                                        @else
                                            <span class="badge badge-danger">{{ __('Out Stock') }}</span>
                                        @endif

                                        @if ($product->sold > 0)
                                            /{{ $product->sold }} {{ __('sold') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product->promotion_price == 0)
                                            <span class="price">{{ currency_format($product->price) }}</span>
                                        @else
                                            <span>{{ currency_format($product->promotion_price) }}</span>
                                            <span class="text-danger" style="text-decoration: line-through;">{{ currency_format($product->price) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!empty($product->category))
                                            {{ $product->category->name }}
                                        @endif
                                    </td>
                                    <td>
                                        @if (!empty($product->brand))
                                            @if (!empty($product->brand->logo->url))
                                                <img style="height:30px; max-width: 100px" src="{{ $product->brand->logo->url }}">
                                            @else
                                                {{ $product->brand->name }}
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{ $product->avg_rate }} <i class="fas fa-star text-warning"></i></i></td>

                                    <td>
                                        <a href="{{ route('admin.products.edit', $product->id)}}" class="btn btn-primary">{{ __('Edit') }}</a>

                                        <form style="display: inline;" action="{{ route('admin.products.destroy', $product->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit" onclick="return confirm('{{ __('Comfirm Delete') }}');">{{ __('Delete') }}</button>
                                        </form>
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
                    {{ $products->links() }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>

    </div>
</div>
@endsection
