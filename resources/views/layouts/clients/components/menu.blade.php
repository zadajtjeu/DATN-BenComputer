<!-- Vertical Menu Start Here -->
<div class="col-xl-3 col-lg-4 d-none d-lg-block">
    <div class="vertical-menu mb-all-30">
        <nav>
            <ul class="vertical-menu-list">
                @foreach ($menu_categories as $category)
                    @include('layouts.clients.components.subcategory2', ['subcategory' => $category])
                @endforeach
            </ul>
        </nav>
    </div>
</div>
<!-- Vertical Menu End Here -->
