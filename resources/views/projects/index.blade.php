@extends('layouts.site')
@section('title', __('site.projects.title'))
@section('description', __('site.projects.description'))

@push('jsonld')
{!! \App\Support\Seo::script([
  '@type' => 'CollectionPage',
  'name' => __('site.projects.h1'),
  'url' => route('projects.index'),
  'inLanguage' => app()->getLocale(),
  'mainEntity' => ['@type' => 'ItemList', 'numberOfItems' => $total, 'itemListElement' => $projects->getCollection()->values()->map(fn ($p, $i) => [
    '@type' => 'ListItem', 'position' => $projects->firstItem() + $i, 'url' => route('projects.show', ['slug' => $p->slug]), 'name' => $p->title,
  ])->all()],
]) !!}
@endpush

@section('content')
<section class="page-main">
  <div class="shell page-inner">
    @include('partials.breadcrumbs', ['crumbs' => [[__('site.breadcrumb_home'), route('home')], [__('site.projects.eyebrow'), route('projects.index')]]])
    <h1 class="page-h1">{{ __('site.projects.h1') }}</h1>
    <p class="page-lead">{{ __('site.projects.lead') }}</p>

    <nav class="filter-bar" aria-label="{{ __('site.projects.category') }}">
      <a href="{{ route('projects.index') }}" class="filter-chip {{ $category ? '' : 'active' }}" @if (! $category) aria-current="true" @endif>{{ __('site.projects.all') }} <span>{{ $total }}</span></a>
      @foreach (\App\Http\Controllers\ProjectController::CATEGORIES as $c)
        @if (($counts[$c] ?? 0) > 0)
          <a href="{{ route('projects.index', ['category' => $c]) }}" class="filter-chip {{ $category === $c ? 'active' : '' }}" @if ($category === $c) aria-current="true" @endif>{{ __('site.projects.'.$c) }} <span>{{ $counts[$c] }}</span></a>
        @endif
      @endforeach
    </nav>

    @if ($projects->isEmpty())
      <p class="journal-empty">{{ __('site.projects.empty') }}</p>
    @else
      <ul class="mini-grid" id="works-grid">
        @foreach ($projects as $i => $project)
          @include('projects.mini', ['project' => $project, 'i' => $i])
        @endforeach
      </ul>

      <div class="list-foot">
        <span class="journal-meta">{{ __('site.projects.showing', ['from' => $projects->firstItem(), 'to' => $projects->lastItem(), 'total' => $projects->total()]) }}</span>
        @if ($projects->hasPages())
          <div class="pager">{{ $projects->links('pagination::simple-default') }}</div>
        @endif
      </div>
    @endif
  </div>
</section>
@endsection
