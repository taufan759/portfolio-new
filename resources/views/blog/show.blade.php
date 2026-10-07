@extends('layouts.site')
@section('title', $post->t('title').' | '.config('site.name'))
@section('description', filled($post->t('excerpt')) ? $post->t('excerpt') : \Illuminate\Support\Str::limit(strip_tags(\Illuminate\Support\Str::markdown($post->t('body') ?? '')), 155))
@section('only_locale', \App\Support\Seo::onlyLocale($post))
@section('og_type', 'article')
@if ($post->cover)@section('og_image', $post->cover)@endif

@push('jsonld')
{!! \App\Support\Seo::script(array_filter([
  '@type' => 'BlogPosting',
  'headline' => $post->t('title'),
  'description' => $post->t('excerpt'),
  'image' => $post->cover ? asset($post->cover) : asset(config('site.og_image')),
  'datePublished' => $post->published_at?->toAtomString(),
  'dateModified' => $post->updated_at?->toAtomString(),
  'inLanguage' => app()->getLocale(),
  'mainEntityOfPage' => route('blog.show', ['slug' => $post->slug]),
  'author' => ['@id' => \App\Support\Seo::personId()],
  'publisher' => ['@id' => \App\Support\Seo::personId()],
  'sameAs' => $post->source_url ?: null,
])) !!}
@endpush

@section('content')
<article class="page-main">
  <div class="shell page-inner article">
    @include('partials.breadcrumbs', ['crumbs' => [
      [__('site.breadcrumb_home'), route('home')],
      [__('site.blog.eyebrow'), route('blog.index')],
      [$post->t('title'), route('blog.show', ['slug' => $post->slug])],
    ]])
    <time class="journal-meta" datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->translatedFormat('d F Y') }}</time>
    <h1 class="page-h1">{{ $post->t('title') }}</h1>
    @if ($post->source_url)
      @php($sourceSite = ucfirst(strtok(preg_replace('/^www\./', '', parse_url($post->source_url, PHP_URL_HOST) ?? ''), '.')))
      <p class="source-note">{{ __('site.blog.originally', ['site' => $sourceSite]) }} · <a href="{{ $post->source_url }}" target="_blank" rel="noopener nofollow">{{ $sourceSite }} ↗</a></p>
    @endif
    @if ($post->cover)<img class="article-cover" src="{{ asset($post->cover) }}" alt="" width="1200" height="630" decoding="async">@endif
    <div class="prose">{!! \Illuminate\Support\Str::markdown($post->t('body') ?? '', ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}</div>
    <a href="{{ route('blog.index') }}" class="journal-more" style="display:inline-block;margin-top:2rem">{{ __('site.blog.back') }}</a>
  </div>
</article>
@endsection
