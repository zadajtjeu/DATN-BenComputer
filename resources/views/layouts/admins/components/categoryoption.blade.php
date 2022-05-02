<option @if ($subcategory->id == old('parent_id')) selected @elseif (isset($category_edit) && $category_edit->parent_id == $subcategory->id) selected @endif value="{{ $subcategory->id }}">{{ $prefix }} {{ $subcategory->name }}</option>
@if ($subcategory->children->isNotEmpty())
    @foreach ($subcategory->children as $child_cate)
        @if (!empty($category_edit) && ($child_cate->id == $category_edit->id))
            @continue
        @endif
        @include('layouts.admins.components.categoryoption', ['subcategory' => $child_cate, 'prefix' => $prefix . '—'])
    @endforeach
@endif
