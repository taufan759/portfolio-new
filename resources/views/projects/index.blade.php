@extends('layouts.site')
@section('title', __('site.projects.title'))
@section('description', __('site.projects.description'))

@push('jsonld')
{!! \App\Support\Seo::script([
  '@type' => 'CollectionPage',
  'name' => __('site.projects.h1'),
  'url' => route('projects.index'),
  'inLanguage' => app()->getLocale(),
  'mainEntity' => ['@type' => 'ItemList', 'itemListElement' => $projects->values()->map(fn ($p, $i) => [
    '@type' => 'ListItem', 'position' => $i + 1, 'url' => route('projects.show', ['slug' => $p->slug]), 'name' => $p->title,
  ])->all()],
]) !!}
@endpush

@section('content')
<section class="page-main">
  <div class="shell page-inner">
    @include('partials.breadcrumbs', ['crumbs' => [[__('site.breadcrumb_home'), route('home')], [__('site.projects.eyebrow'), route('projects.index')]]])
    <h1 class="page-h1">{{ __('site.projects.h1') }}</h1>
    <p class="page-lead">{{ __('site.projects.lead') }}</p>

    <div class="works-filters">
      @foreach (['all', 'fullstack', 'uiux', 'ai'] as $f)
        <button type="button" class="works-filter-btn {{ $f === 'all' ? 'active' : '' }}" data-filter="{{ $f }}">{{ __('site.projects.'.$f) }}</button>
      @endforeach
    </div>

    <ul class="works-grid" id="works-grid">
      <li class="works-empty" id="works-empty" hidden>{{ __('site.projects.empty') }}</li>
      @foreach ($projects as $i => $project)
        @include('projects.card', ['project' => $project, 'i' => $i])
      @endforeach
    </ul>
  </div>
</section>
@endsection
