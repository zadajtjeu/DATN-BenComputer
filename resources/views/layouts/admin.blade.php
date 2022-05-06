@include('layouts.admins.header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('themes/images/logo.png') }}" alt="{{ config('app.name', 'Ben Computer') }}" height="60">
        </div>

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">{{ __('Dashboard') }}</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('home') }}" class="nav-link">{{ __('Home') }}</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <!-- Language -->
                @if (Route::has('language'))
                    <li class="nav-item dropdown">
                        <a id="languageDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            @if (App::isLocale('vi'))
                                {{ __('Vietnamese') }}
                            @else
                                {{ __('English') }}
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('language', ['en']) }}"> {{ __('English') }}</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('language', ['vi']) }}"> {{ __('Vietnamese') }}</a>
                            </li>
                        </ul>
                    </li>
                @endif
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>


        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <a href="index3.html" class="brand-link">
                <img src="{{ asset('themes/images/logowhite.png') }}" alt="{{ config('app.name', 'Ben Computer') }}Logo" class="brand-image " style="opacity: .8">
                <span class="brand-text font-weight-light">{{ config('app.name', 'Ben Computer') }}</span>
            </a>

            <div class="sidebar">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('templates/adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="{{ auth()->user()->name }}">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar nav-flat flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>{{ __('Dashboard') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    {{ __('Post Management') }}
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.posts.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('All Posts') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.posts.create') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('Add New') }}</p>
                                    </a>
                                </li>
                                @if (isAdmin())
                                    <li class="nav-item">
                                        <a href="{{ route('admin.posttypes.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ __('Post Types') }}</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-columns"></i>
                                <p>
                                    {{ __('Product Management') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.products.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('All Products') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.products.create') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('Add New') }}</p>
                                    </a>
                                </li>
                                @if (isAdmin())
                                    <li class="nav-item">
                                        <a href="{{ route('admin.brands.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ __('Brands') }}</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.categories.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ __('Categories') }}</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-box"></i>
                                <p>
                                    {{ __('Order Management') }}
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.orders.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('All Orders') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.orders.new') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('Unapproved Orders') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.orders.process') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('Approved Orders') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.orders.shipping') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('Shipping Orders') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    {{ __('User Management') }}
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if (isAdmin())
                                    <li class="nav-item">
                                        <a href="{{ route('admin.users.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ __('All Accounts') }}</p>
                                        </a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.list') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('Client Accounts') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @if (isAdmin())
                            <li class="nav-item">
                                <a href="{{ route('admin.vouchers.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-tag"></i>
                                    <p>{{ __('Voucher Management') }}</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>

            </div>

        </aside>

        <div class="content-wrapper">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('page_title', __('Dashboard'))</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                                @yield('breadcrumb', '')
                            </ol>
                        </div>
                    </div>
                </div>
            </div>


            <section class="content">
                <div class="container-fluid">
                    @yield('content', '')
                </div>
            </section>

        </div>

    @include('layouts.admins.footer')
</body>

</html>
