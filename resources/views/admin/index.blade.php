@extends('admin.layout')
@section('title', $def['label'])
@section('content')
<div class="row" style="justify-content:space-between;margin-bottom:1rem">
  <h1 style="margin:0">{{ $def['label'] }}</h1>
  @unless ($def['readonly'] ?? false)
    <a class="btn" href="{{ route('admin.create', $resource) }}">+ New</a>
  @endunless
</div>
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
