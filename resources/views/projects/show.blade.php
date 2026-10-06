@php
  $locale = app()->getLocale();
  $title = $project->title;
  $description = $project->t('description');
  $categoryLabel = __('site.projects.'.$project->category);
@endphp
@extends('layouts.site')
@section('title', $title.' — '.$categoryLabel.' | '.config('site.name'))
@section('description', \Illuminate\Support\Str::limit(strip_tags($description), 160))
@section('only_locale', \App\Support\Seo::onlyLocale($project))
@section('og_image', $project->image)
@section('og_type', 'article')

@push('jsonld')
{!! \App\Support\Seo::script(array_filter([
  '@type' => 'CreativeWork',
  'name' => $title,
  'description' => $description,
  'url' => route('projects.show', ['slug' => $project->slug]),
  'image' => asset($project->image),
  'genre' => $categoryLabel,
  'dateCreated' => $project->year ? (string) $project->year : null,
  'keywords' => implode(', ', $project->tags ?? []),
  'inLanguage' => $locale,
  'author' => ['@id' => \App\Support\Seo::personId()],
  'sameAs' => $project->url ?: null,
])) !!}
@endpush

@section('content')
<article class="page-main">
  <div class="shell page-inner article project-page">
    @include('partials.breadcrumbs', ['crumbs' => [
      [__('site.breadcrumb_home'), route('home')],
      [__('site.projects.eyebrow'), route('projects.index')],
      [$title, route('projects.show', ['slug' => $project->slug])],
    ]])

    <div class="eyebrow">{{ $categoryLabel }}</div>
    <h1 class="page-h1">{{ $title }}</h1>
    <p class="page-lead">{{ $description }}</p>

    <dl class="project-meta">
      @if ($project->kind)<div><dt>{{ __('site.projects.type') }}</dt><dd>{{ $project->kind }}</dd></div>@endif
      @if ($project->year)<div><dt>{{ __('site.projects.year') }}</dt><dd>{{ $project->year }}</dd></div>@endif
      <div><dt>{{ __('site.projects.tech') }}</dt><dd>{{ implode(', ', $project->tags ?? []) }}</dd></div>
    </dl>

    <img class="article-cover" src="{{ asset($project->image) }}" alt="{{ $title }}" width="1200" height="630" decoding="async" fetchpriority="high">

    @if (filled($project->t('details')))
      <div class="prose">{!! \Illuminate\Support\Str::markdown($project->t('details'), ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}</div>
    @endif

    <div class="project-cta">
      @if ($project->url)
        <a href="{{ $project->url }}" target="_blank" rel="noopener" class="pill-btn dark with-arrow arrow-up hover-pill">
          <span style="padding-left:.5rem">{{ __('site.projects.visit') }}</span>
          <span class="pill-arrow-badge"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></span>
        </a>
      @else
        <span class="journal-meta">{{ __('site.projects.no_link') }}</span>
      @endif
      <a href="{{ route('projects.index') }}" class="journal-more">{{ __('site.projects.back') }}</a>
    </div>
  </div>

  @if ($related->isNotEmpty())
    <section class="shell works-inner">
      <h2 class="page-h2">{{ __('site.projects.more') }}</h2>
      <ul class="mini-grid">
        @foreach ($related as $i => $p)
          @include('projects.mini', ['project' => $p, 'i' => $i])
        @endforeach
      </ul>
    </section>
  @endif
</article>
@endsection
