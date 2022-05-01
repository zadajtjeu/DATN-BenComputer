<li{{ $subcategory->children->isNotEmpty() ? ' class="has-sub"' : ''}}><a href="#">{{ $subcategory->name }}</a>
    @if ($subcategory->children->isNotEmpty())
        <ul class="category-sub">
            @foreach ($subcategory->children as $child_cate)
                @include('layouts.clients.components.subcategory', ['subcategory' => $child_cate])
            @endforeach
        </ul>
    @endif
</li>
