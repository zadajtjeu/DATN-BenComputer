@if ($subcategory->name)
    <li>
        <a href="{{ route('categories.details', $subcategory->slug) }}">{{ $subcategory->name }} {!! $subcategory->children->isNotEmpty() ? '<i class="fa fa-angle-right"></i>' : '' !!}</a>
        @if ($subcategory->children->isNotEmpty())
            <ul class="ht-dropdown mega-child">
                @foreach ($subcategory->children as $child_cate)
                    @include('layouts.clients.components.subcategory2', ['subcategory' => $child_cate])
                @endforeach
            </ul>
        @endif
    </li>
@endif
