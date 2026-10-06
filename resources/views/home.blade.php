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

<!-- ================= SELECTED PROJECTS ================= -->
<section id="works">
  <div class="shell works-inner">
    <div class="works-head">
      <h2 class="works-h2 reveal"><span class="line-clip"><span class="line-inner">{{ __('site.home.projects') }}</span></span></h2>
      <a href="{{ route('projects.index') }}" class="journal-more">{{ __('site.home.projects_all') }}</a>
    </div>
    <ul class="works-grid">
      @foreach ($projects as $i => $project)
        @include('projects.card', ['project' => $project, 'i' => $i])
      @endforeach
    </ul>
  </div>
</section>

<!-- ================= READING & WRITING ================= -->
<section id="journal">
  <div class="shell journal-inner">
    <div class="journal-grid two">
      <div class="journal-col reveal" style="--dy:24px">
        <div class="journal-col-head"><h2>{{ __('site.home.reading') }}</h2><a href="{{ route('books.index') }}" class="journal-more">{{ __('site.home.reading_all') }}</a></div>
        @forelse ($books as $book)
          <div class="journal-row">
            <span class="journal-title">{{ $book->title }}<small>{{ $book->author }}</small></span>
            <span class="journal-meta">{{ __('site.home.reading_label') }}</span>
          </div>
        @empty
          <p class="journal-empty">{{ __('site.home.reading_empty') }}</p>
        @endforelse
      </div>

      <div class="journal-col reveal" style="--dy:24px" data-delay="90">
        <div class="journal-col-head"><h2>{{ __('site.home.writing') }}</h2><a href="{{ route('blog.index') }}" class="journal-more">{{ __('site.home.writing_all') }}</a></div>
        @forelse ($posts as $post)
          <a href="{{ route('blog.show', ['slug' => $post->slug]) }}" class="journal-row">
            <span class="journal-title">{{ $post->t('title') }}</span>
            <span class="journal-meta">{{ $post->published_at?->translatedFormat('d M Y') }}</span>
          </a>
        @empty
          <p class="journal-empty">{{ __('site.home.writing_empty') }}</p>
        @endforelse
      </div>
    </div>
  </div>
</section>
@endsection
