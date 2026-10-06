@extends('layouts.site')
@section('title', __('site.blog.title'))
@section('description', __('site.blog.description'))

@push('jsonld')
{!! \App\Support\Seo::script(['@type' => 'Blog', 'name' => __('site.blog.title'), 'url' => route('blog.index'), 'inLanguage' => app()->getLocale(), 'author' => ['@id' => \App\Support\Seo::personId()]]) !!}
@endpush

@section('content')
<section class="page-main">
  <div class="shell page-inner">
    @include('partials.breadcrumbs', ['crumbs' => [[__('site.breadcrumb_home'), route('home')], [__('site.blog.eyebrow'), route('blog.index')]]])
    <h1 class="page-h1">{{ __('site.blog.h1') }}</h1>
    <p class="page-lead">{{ __('site.blog.lead') }}</p>
    <div class="post-grid">
      @forelse ($posts as $post)
        <a href="{{ route('blog.show', ['slug' => $post->slug]) }}" class="post-card">
          @if ($post->cover)<img src="{{ asset($post->cover) }}" alt="" loading="lazy" decoding="async" width="800" height="450">@endif
          <div class="post-card-body">
            <time class="journal-meta" datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->translatedFormat('d M Y') }}</time>
            <h2>{{ $post->t('title') }}</h2>
            <p>{{ $post->t('excerpt') }}</p>
          </div>
        </a>
      @empty
        <p class="journal-empty">{{ __('site.blog.empty') }}</p>
      @endforelse
    </div>
    <div class="pager">{{ $posts->links('pagination::simple-default') }}</div>
  </div>
</section>
@endsection
