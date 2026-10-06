@extends('layouts.site')
@section('title', __('site.news.title'))
@section('description', __('site.news.lead'))
{{-- Aggregated third-party headlines add no original value; keep them out of the index but let crawlers follow links. --}}
@section('robots', 'noindex,follow')

@section('content')
<section class="page-main">
  <div class="shell page-inner">
    @include('partials.breadcrumbs', ['crumbs' => [[__('site.breadcrumb_home'), route('home')], [__('site.news.eyebrow'), route('news.index')]]])
    <h1 class="page-h1">{{ __('site.news.h1') }}</h1>
    <p class="page-lead">{{ __('site.news.lead') }}</p>
    <div class="book-list">
      @forelse ($news as $item)
        <a href="{{ $item->url }}" target="_blank" rel="noopener nofollow" class="book-row">
          <div><strong>{{ $item->title }}</strong><small>{{ $item->source }}</small></div>
          <span class="journal-meta">{{ $item->published_at?->diffForHumans() }}</span>
        </a>
      @empty
        <p class="journal-empty">{{ __('site.news.empty') }}</p>
      @endforelse
    </div>
    <div class="pager">{{ $news->links('pagination::simple-default') }}</div>
  </div>
</section>
@endsection
