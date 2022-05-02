@extends('layouts.admin')

@section('title') {{ __('Category Management') }} @endsection

@section('page_title')
{{ __('Category Management') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active">{{ __('Category Management') }}</li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">{{ __('Add New') }}</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.categories.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
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
                    <div class="form-group">
                        <label for="parent">{{ __('Parent Category') }}</label>
                        <select id="parent" name="parent_id" class="form-control custom-select @error('parent_id') is-invalid @enderror" required>
                            <option value='0'>———{{ __('None') }}———</option>
                            @foreach ($categories as $key => $category) {
                                @include('layouts.admins.components.categoryoption', ['subcategory' => $category, 'prefix' => ''])
                            }
                            @endforeach
                        </select>
                        @error('parent_id')
                            <span class="error invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">{{ __('Categories can have a hierarchy. You might have a Jazz category, and under that have children categories for Bebop and Big Band. Totally optional') }}</small>
                    </div>
                    <input type="reset" value="{{ __('Cancel') }}" class="btn btn-secondary">
                    <input type="submit" value="{{ __('Create') }}" class="btn btn-success float-right">
                </form>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <div class="col-lg-8">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">{{ __('Categories') }}</h3>
            </div>
            <div class="card-body p-1">
                <table class="table table-bordered" id="CategoryTable">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th class="btn-action" width="20%">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($categories->isNotEmpty())
                            @foreach ($categories as $key => $category)
                                @include('layouts.admins.components.categoryrow', ['subcategory' => $category, 'prefix' => ''])
                            @endforeach
                        @else
                                <div class="alert alert-primary" role="alert">{{ __('Empty category') }}</div>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card -->
    </div>

    </div>
</div>
@endsection

@section('addcss')
    <link rel="stylesheet" href="{{ asset('templates/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection

@section('addjs')
    <script src="{{ asset('templates/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('templates/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('templates/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('templates/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(function () {
            $("#CategoryTable").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "url": "{{ asset('templates/datatables.net-plugins/i18n/' . app()->getLocale() . '.json') }}"
                }
            });
        });
        $(document).ready(function() {

            function change_alias( alias )
            {
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

            $("input#name").keyup(function() {
                var value = $(this).val();
                var nodeUrl = $("input#slug");
                var tmp = nodeUrl.val();
                nodeUrl.val(change_alias(value));
            }).keyup();
        });
    </script>
@endsection
