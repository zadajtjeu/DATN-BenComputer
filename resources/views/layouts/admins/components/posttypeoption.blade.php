<option @if ($subposttype->id == old('parent_id')) selected @elseif (isset($posttype_edit) && $posttype_edit->parent_id == $subposttype->id) selected @endif value="{{ $subposttype->id }}">{{ $prefix }} {{ $subposttype->name }}</option>
@if ($subposttype->children->isNotEmpty())
    @foreach ($subposttype->children as $child_cate)
        @if (!empty($posttype_edit) && ($child_cate->id == $posttype_edit->id))
            @continue
        @endif
        @include('layouts.admins.components.posttypeoption', ['subposttype' => $child_cate, 'prefix' => $prefix . '—'])
    @endforeach
@endif
