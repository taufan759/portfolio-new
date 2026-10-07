@extends('layouts.site')
@section('title', __('site.gallery.title'))
@section('description', __('site.gallery.description'))

@push('jsonld')
{!! \App\Support\Seo::script([
  '@type' => 'ImageGallery',
  'name' => __('site.gallery.h1'),
  'url' => route('gallery.index'),
  'inLanguage' => app()->getLocale(),
  'author' => ['@id' => \App\Support\Seo::personId()],
  'image' => $items->getCollection()->take(12)->map(fn ($i) => [
    '@type' => 'ImageObject',
    'contentUrl' => asset($i->image),
    'name' => $i->t('title') ?: null,
    'caption' => $i->t('caption') ?: null,
    'contentLocation' => $i->location ?: null,
    'dateCreated' => $i->taken_at?->toDateString(),
  ])->map(fn ($a) => array_filter($a))->values()->all(),
]) !!}
@endpush

@section('content')
<section class="page-main">
  <div class="shell page-inner">
    @include('partials.breadcrumbs', ['crumbs' => [[__('site.breadcrumb_home'), route('home')], [__('site.gallery.eyebrow'), route('gallery.index')]]])
    <h1 class="page-h1">{{ __('site.gallery.h1') }}</h1>
    <p class="page-lead">{{ __('site.gallery.lead') }}</p>

    @if ($items->isEmpty())
      <p class="journal-empty">{{ __('site.gallery.empty') }}</p>
    @else
      <ul class="gal-grid">
        @foreach ($items as $item)
          <li>@include('gallery.item', ['item' => $item])</li>
        @endforeach
      </ul>

      <div class="list-foot">
        <span class="journal-meta">{{ __('site.gallery.showing', ['from' => $items->firstItem(), 'to' => $items->lastItem(), 'total' => $items->total()]) }}</span>
        @if ($items->hasPages())<div class="pager">{{ $items->links('pagination::simple-default') }}</div>@endif
      </div>
    @endif
  </div>
</section>
@endsection
