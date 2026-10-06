@extends('admin.layout')
@section('title', $item->exists ? 'Edit' : 'New')
@section('content')
<h1>{{ $item->exists ? 'Edit' : 'New' }} — {{ $def['label'] }}</h1>
<div class="card">
  <form method="post" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.update', [$resource, $item->id]) : route('admin.store', $resource) }}">
    @csrf
    @if ($item->exists) @method('PUT') @endif

    @foreach ($def['fields'] as $field)
      @php
        $name = $field[0]; $type = $field[1];
        $value = old($name, $item->exists ? $item->{$name} : ($name === 'is_published' ? true : null));
        if ($type === 'tags' && is_array($value)) $value = implode(', ', $value);
        if ($value instanceof \Carbon\CarbonInterface) $value = $value->format('Y-m-d');
      @endphp

      @if ($type === 'checkbox')
        <label style="font-weight:400"><input type="checkbox" name="{{ $name }}" value="1" @checked($value)> {{ str_replace('_', ' ', $name) }}</label>
      @else
        <label for="f-{{ $name }}">{{ str_replace('_', ' ', $name) }}</label>
        @if ($type === 'textarea')
          <textarea id="f-{{ $name }}" name="{{ $name }}" rows="{{ $field['rows'] ?? 4 }}">{{ $value }}</textarea>
        @elseif ($type === 'select')
          <select id="f-{{ $name }}" name="{{ $name }}">
            @foreach ($field['options'] as $k => $label)<option value="{{ $k }}" @selected($value == $k)>{{ $label }}</option>@endforeach
          </select>
        @elseif ($type === 'image')
          <input id="f-{{ $name }}" type="file" name="{{ $name }}" accept="image/png,image/jpeg,image/webp">
          @if ($item->exists && $item->{$name})<img class="thumb" src="{{ asset($item->{$name}) }}" alt="">@endif
        @else
          <input id="f-{{ $name }}" type="{{ in_array($type, ['number', 'date']) ? $type : 'text' }}" name="{{ $name }}" value="{{ $value }}">
        @endif
        @isset($field['help'])<small>{{ $field['help'] }}</small>@endisset
        @error($name)<div class="err">{{ $message }}</div>@enderror
      @endif
    @endforeach

    <div class="row" style="margin-top:1.5rem">
      <button class="btn">Save</button>
      <a class="btn ghost" href="{{ route('admin.index', $resource) }}">Cancel</a>
    </div>
  </form>
</div>
@endsection
