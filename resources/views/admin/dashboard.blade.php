@extends('admin.layout')
@section('title', 'Dashboard')
@section('content')
<h1>Dashboard</h1>
<div class="grid">
  @foreach ($stats as $key => $s)
    <div class="card stat"><b>{{ $s['count'] }}</b>{{ $s['label'] }}</div>
  @endforeach
</div>
<div class="card">
  <h2 style="font-size:1.125rem;margin-bottom:.5rem">News scraper</h2>
  <p style="margin-bottom:.75rem"><small>Runs automatically every hour via the scheduler. You can also fetch now.</small></p>
  <form method="post" action="{{ route('admin.news.fetch') }}">@csrf<button class="btn">Fetch headlines now</button></form>
</div>
@endsection
