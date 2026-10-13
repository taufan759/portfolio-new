@extends('admin.layout')
@section('title', 'Dashboard')
@section('content')
<h1>Dashboard</h1>

<h2 style="font-size:1.125rem;margin-bottom:.5rem">Website visitors</h2>
<div class="grid">
  @foreach ([['Today', $traffic['today']], ['Last 7 days', $traffic['week']], ['Last 30 days', $traffic['month']]] as [$label, $t])
    <div class="card stat"><b>{{ number_format($t['visitors']) }}</b>{{ $label }}: visitors<br><small>{{ number_format($t['views']) }} page views</small></div>
  @endforeach
  <div class="card stat"><b>{{ number_format($traffic['total']) }}</b>Page views, all time</div>
</div>

@php($max = max(1, collect($traffic['days'])->max('visitors')))
<div class="card" style="margin-bottom:1rem">
  <h2 style="font-size:1.125rem;margin-bottom:.75rem">Visitors per day (last 14 days)</h2>
  <div style="display:flex;align-items:flex-end;gap:.375rem;height:7rem">
    @foreach ($traffic['days'] as $d)
      <div title="{{ $d['date'] }}: {{ $d['visitors'] }}" style="flex:1;display:flex;flex-direction:column;justify-content:flex-end;align-items:center;height:100%;font-size:.6875rem;color:#777">
        <span>{{ $d['visitors'] ?: '' }}</span>
        <div style="width:100%;background:#0a0a0a;border-radius:.25rem .25rem 0 0;height:{{ max(2, round($d['visitors'] / $max * 80)) }}%;opacity:{{ $d['visitors'] ? 1 : .15 }}"></div>
      </div>
    @endforeach
  </div>
  <div style="display:flex;justify-content:space-between;font-size:.6875rem;color:#777;margin-top:.25rem"><span>{{ $traffic['days'][0]['date'] }}</span><span>{{ end($traffic['days'])['date'] }}</span></div>
</div>

<div class="grid" style="grid-template-columns:repeat(auto-fit,minmax(16rem,1fr))">
  <div class="card">
    <h2 style="font-size:1.125rem;margin-bottom:.5rem">Top pages (30 days)</h2>
    <table>@forelse ($traffic['pages'] as $p)<tr><td class="t">{{ $p->path }}</td><td style="text-align:right">{{ $p->c }}</td></tr>@empty<tr><td><small>No visits yet.</small></td></tr>@endforelse</table>
  </div>
  <div class="card">
    <h2 style="font-size:1.125rem;margin-bottom:.5rem">Where they came from</h2>
    <table>@forelse ($traffic['referrers'] as $r)<tr><td class="t">{{ $r->referrer }}</td><td style="text-align:right">{{ $r->c }}</td></tr>@empty<tr><td><small>Mostly direct visits so far.</small></td></tr>@endforelse</table>
    <p style="margin-top:.75rem"><small>Language: ID {{ $traffic['locales']['id'] ?? 0 }} · EN {{ $traffic['locales']['en'] ?? 0 }}</small></p>
  </div>
</div>
<p style="margin:.75rem 0 1.5rem"><small>Counts exclude bots. No IP addresses or cookies are stored, and a returning visitor counts once per day. Counting starts from the day this feature went live.</small></p>

<h2 style="font-size:1.125rem;margin-bottom:.5rem">Content</h2>
<div class="grid">
  @foreach ($stats as $key => $s)
    <div class="card stat"><b>{{ $s['count'] }}</b>{{ $s['label'] }}</div>
  @endforeach
</div>
<div class="card">
  <h2 style="font-size:1.125rem;margin-bottom:.5rem">News scraper</h2>
  <p style="margin-bottom:.75rem"><small>Runs automatically every 3 hours via the scheduler (max 5 new headlines per language per day). You can also fetch now.</small></p>
  <form method="post" action="{{ route('admin.news.fetch') }}">@csrf<button class="btn">Fetch headlines now</button></form>
</div>
@endsection
