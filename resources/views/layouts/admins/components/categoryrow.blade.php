<tr>
    <td>{{ $prefix }} {{ $subcategory->name }}</td>
    <td>
        <a href="{{ route('admin.categories.edit', $subcategory->id)}}" class="btn btn-primary">{{ __('Edit') }}</a>

        <form style="display: inline;" action="{{ route('admin.categories.destroy', $subcategory->id)}}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit" onclick="return confirm('{{ __('Comfirm Delete Category') }}');">{{ __('Delete') }}</button>
        </form>
    </td>
</tr>
@if ($subcategory->children->isNotEmpty())
    @foreach ($subcategory->children as $child_cate)
        @include('layouts.admins.components.categoryrow', ['subcategory' => $child_cate, 'prefix' => $prefix . '—'])
    @endforeach
@endif
