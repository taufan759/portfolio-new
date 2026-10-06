@extends('layouts.site')
@section('title', 'Tech news — Muhammad Taufan Akbar')
@section('content')
<section class="page-main">
  <div class="shell page-inner">
    <div class="eyebrow">Tech news</div>
    <h1 class="page-h1">Curated tech headlines</h1>
    <p class="page-lead">Headlines are collected automatically from public RSS feeds. Each link goes to the original publisher.</p>
    <div class="book-list">
      @forelse ($news as $item)
        <a href="{{ $item->url }}" target="_blank" rel="noopener nofollow" class="book-row">
          <div><strong>{{ $item->title }}</strong><small>{{ $item->source }}</small></div>
          <span class="journal-meta">{{ $item->published_at?->diffForHumans() }}</span>
        </a>
      @empty
        <p class="journal-empty">No headlines yet. The scraper runs on a schedule.</p>
      @endforelse
    </div>
    <div class="pager">{{ $news->links('pagination::simple-default') }}</div>
  </div>
</section>
@endsection
