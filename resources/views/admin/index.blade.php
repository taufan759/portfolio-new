@extends('admin.layout')
@section('title', $def['label'])
@section('content')
<div class="row" style="justify-content:space-between;margin-bottom:1rem">
  <h1 style="margin:0">{{ $def['label'] }}</h1>
  @unless ($def['readonly'] ?? false)
    <a class="btn" href="{{ route('admin.create', $resource) }}">+ New</a>
  @endunless
</div>
@if ($def['bulk'] ?? false)
<div class="card" style="margin-bottom:1rem">
  <strong>Bulk upload</strong>
  <p style="margin:.25rem 0 .75rem;color:#666">Select many photos at once. Fields below are optional and apply to every photo in this upload; you can edit each photo afterwards.</p>
  <form method="post" action="{{ route('admin.gallery.bulk') }}" enctype="multipart/form-data">
    @csrf
    <label for="bulk-photos">Photos</label>
    <input id="bulk-photos" type="file" name="photos[]" accept="image/png,image/jpeg,image/webp" multiple required>
    <label for="bulk-title">Event / talk (English)</label>
    <input id="bulk-title" type="text" name="title" maxlength="200">
    <label for="bulk-title-id">Event / talk (Indonesian)</label>
    <input id="bulk-title-id" type="text" name="title_id" maxlength="200">
    <label for="bulk-location">Location</label>
    <input id="bulk-location" type="text" name="location" maxlength="160">
    <label for="bulk-date">Date</label>
    <input id="bulk-date" type="date" name="taken_at">
    @error('photos')<div class="err">{{ $message }}</div>@enderror
    @error('photos.*')<div class="err">{{ $message }}</div>@enderror
    <div class="row" style="margin-top:1rem"><button class="btn">Upload photos</button></div>
  </form>
</div>
@endif
<div class="card" style="overflow-x:auto">
  <table>
    <thead><tr>@foreach ($def['columns'] as $c)<th>{{ str_replace('_', ' ', $c) }}</th>@endforeach<th></th></tr></thead>
    <tbody>
    @forelse ($rows as $row)
      <tr>
        @foreach ($def['columns'] as $c)
          @php($v = $row->{$c})
          <td class="t">{{ is_bool($v) ? ($v ? 'yes' : 'no') : ($v instanceof \Carbon\CarbonInterface ? $v->format('d M Y H:i') : \Illuminate\Support\Str::limit((string) $v, 80)) }}</td>
        @endforeach
        <td>
          <div class="row" style="justify-content:flex-end">
            @unless ($def['readonly'] ?? false)<a class="btn ghost" href="{{ route('admin.edit', [$resource, $row->id]) }}">Edit</a>@endunless
            <form method="post" action="{{ route('admin.destroy', [$resource, $row->id]) }}" onsubmit="return confirm('Delete this item?')">@csrf @method('DELETE')<button class="btn danger">Delete</button></form>
          </div>
        </td>
      </tr>
    @empty
      <tr><td colspan="{{ count($def['columns']) + 1 }}">Nothing here yet.</td></tr>
    @endforelse
    </tbody>
  </table>
</div>
<div class="pager">{{ $rows->links('pagination::simple-default') }}</div>
@endsection
