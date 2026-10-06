@extends('layouts.site')
@section('title', 'Blog — Muhammad Taufan Akbar')
@section('content')
<section class="page-main">
  <div class="shell page-inner">
    <div class="eyebrow">Blog</div>
    <h1 class="page-h1">Notes on building software</h1>
    <div class="post-grid">
      @forelse ($posts as $post)
        <a href="{{ route('blog.show', $post->slug) }}" class="post-card">
          @if ($post->cover)<img src="{{ asset($post->cover) }}" alt="" loading="lazy" decoding="async" width="800" height="450">@endif
          <div class="post-card-body">
            <span class="journal-meta">{{ $post->published_at?->format('d M Y') }}</span>
            <h2>{{ $post->title }}</h2>
            <p>{{ $post->excerpt }}</p>
          </div>
        </a>
      @empty
        <p class="journal-empty">No posts yet.</p>
      @endforelse
    </div>
    <div class="pager">{{ $posts->links('pagination::simple-default') }}</div>
  </div>
</section>
@endsection
