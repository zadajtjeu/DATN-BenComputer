<tr>
    <td>{{ $prefix }} {{ $subposttype->name }}</td>
    <td>
        <a href="{{ route('admin.posttypes.edit', $subposttype->id)}}" class="btn btn-primary">{{ __('Edit') }}</a>

        <form style="display: inline;" action="{{ route('admin.posttypes.destroy', $subposttype->id)}}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit" onclick="return confirm('{{ __('Comfirm Delete') }}');">{{ __('Delete') }}</button>
        </form>
    </td>
</tr>
@if ($subposttype->children->isNotEmpty())
    @foreach ($subposttype->children as $child_cate)
        @include('layouts.admins.components.posttyperow', ['subposttype' => $child_cate, 'prefix' => $prefix . '—'])
    @endforeach
@endif
