@extends('layouts.site')

@section('loader')
@include('partials.loader')
@endsection

@push('jsonld')
{!! \App\Support\Seo::script(['@type' => 'ProfilePage', 'url' => route('home'), 'inLanguage' => app()->getLocale(), 'mainEntity' => ['@id' => \App\Support\Seo::personId()]]) !!}
@endpush

@section('content')
<!-- ================= HERO ================= -->
<section id="home">
  <div class="liquid-wrap" id="liquid-wrap" data-after="{{ asset('images/hero/after.webp') }}">
    <img id="liquid-base" src="{{ asset('images/hero/before.webp') }}" alt="{{ config('site.name') }}" fetchpriority="high" />
    <canvas id="liquid-canvas" aria-hidden="true"></canvas>
  </div>
  <div class="hero-vignette"></div>
  <div class="hero-watermark reveal" style="--dy:20px" data-hero-delay="300" aria-hidden="true">TAUFAN</div>

  <div class="shell hero-grid">
    <div class="hero-left">
      <div class="hero-eyebrow-row reveal" style="--dy:10px" data-hero-delay="200">
        <span class="dot"></span><span>{{ __('site.hero.eyebrow') }}</span>
      </div>

      <h1 class="hero-h1 reveal" data-hero-delay="250">
        <span class="line-clip"><span class="line-inner" style="transition-delay:0ms">{{ __('site.hero.l1') }}</span></span>
        <span class="line-clip"><span class="line-inner" style="transition-delay:120ms">{{ __('site.hero.l2') }}</span></span>
        <span class="line-clip"><span class="line-inner" style="transition-delay:240ms">{{ __('site.hero.l3') }}</span></span>
      </h1>

      <p class="hero-lead reveal" style="--dy:10px" data-hero-delay="500">{{ __('site.hero.lead') }}</p>

      <div class="hero-cta-row reveal" style="--dy:10px" data-hero-delay="650">
        <button type="button" class="pill-btn dark with-arrow arrow-right hover-pill" data-open-modal>
          <span style="padding-left:.5rem">{{ __('site.hero.talk') }}</span>
          <span class="pill-arrow-badge"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
        </button>
        <a href="{{ route('projects.index') }}" class="pill-btn outline no-arrow hover-pill">{{ __('site.hero.work') }}</a>
        <a href="{{ route('about') }}" class="pill-btn outline no-arrow hover-pill">{{ __('site.hero.about') }}</a>
      </div>
    </div>
  </div>

  <div class="shell hero-statusbar reveal" data-hero-delay="800">
    <span>{{ __('site.hero.since') }}</span>
    <span class="mid">{{ __('site.hero.based') }}</span>
  </div>
</section>

<!-- ================= OVERVIEW OF EVERY MENU ================= -->
<section id="overview">
  <div class="shell overview-inner">
    <h2 class="overview-h2 reveal"><span class="line-clip"><span class="line-inner">{{ __('site.home.overview') }}</span></span></h2>
    @php
      $cards = [
        ['about', 'about', __('site.nav.about'), null],
        ['projects.index', 'projects', __('site.nav.projects'), __('site.home.count_projects', ['count' => $projectCount])],
        ['blog.index', 'blog', __('site.nav.blog'), $post ? __('site.home.latest').': '.$post->t('title') : __('site.home.soon')],
        ['books.index', 'books', __('site.nav.books'), $book ? __('site.home.reading_now').': '.$book->title : __('site.home.soon')],
        ['news.index', 'news', __('site.nav.news'), $news ? __('site.home.latest').': '.$news->title : null],
      ];
    @endphp
    <ul class="overview-grid">
      @foreach ($cards as $i => [$route, $key, $label, $detail])
        <li class="reveal" style="--dy:24px" data-delay="{{ $i * 70 }}">
          <a href="{{ route($route) }}" class="overview-card">
            <span class="overview-index">{{ sprintf('%02d', $i + 1) }}</span>
            <h3>{{ $label }}</h3>
            <p>{{ __('site.home.ov.'.$key) }}</p>
            @if ($detail)<span class="overview-detail">{{ $detail }}</span>@endif
            <span class="overview-open">{{ __('site.home.open') }} <span aria-hidden="true">→</span></span>
          </a>
        </li>
      @endforeach
    </ul>
  </div>
</section>
@endsection
