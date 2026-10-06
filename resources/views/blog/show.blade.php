@extends('layouts.site')
@section('title', $post->title.' — Muhammad Taufan Akbar')
@section('description', $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->body), 150))
@section('content')
<article class="page-main">
  <div class="shell page-inner article">
    <a href="{{ route('blog.index') }}" class="journal-more">← All posts</a>
    <span class="journal-meta">{{ $post->published_at?->format('d F Y') }}</span>
    <h1 class="page-h1">{{ $post->title }}</h1>
    @if ($post->cover)<img class="article-cover" src="{{ asset($post->cover) }}" alt="" width="1200" height="630" decoding="async">@endif
    <div class="prose">{!! \Illuminate\Support\Str::markdown($post->body ?? '', ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}</div>
  </div>
</article>
@endsection
