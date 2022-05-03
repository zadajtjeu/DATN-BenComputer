<option @if (isset($old_cate) && $subcategory->id == $old_cate) selected @elseif (isset($choose_cate) && $choose_cate == $subcategory->id) selected @endif value="{{ $subcategory->id }}">{{ $prefix }} {{ $subcategory->name }}</option>
@if ($subcategory->children->isNotEmpty())
    @foreach ($subcategory->children as $child_cate)
        @include('layouts.admins.components.categoryoptionchoose', ['subcategory' => $child_cate, 'prefix' => $prefix . '—'])
    @endforeach
@endif
