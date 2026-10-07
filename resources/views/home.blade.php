@extends('layouts.site')

@section('body_class', 'page-home')

@section('loader')
@include('partials.loader')
@endsection

@push('jsonld')
{!! \App\Support\Seo::script(['@type' => 'ProfilePage', 'url' => route('home'), 'inLanguage' => app()->getLocale(), 'mainEntity' => ['@id' => \App\Support\Seo::personId()]]) !!}
@endpush

@section('content')
<!-- ================= HERO ================= -->
<section id="home">
  <div class="liquid-wrap" id="liquid-wrap" data-after="{{ asset('images/hero/after.webp') }}" data-flip-label="{{ __('site.hero.flip') }}">
    <img id="liquid-base" src="{{ asset('images/hero/before.webp') }}" alt="{{ config('site.name') }}" fetchpriority="high" />
    <canvas id="liquid-canvas" aria-hidden="true"></canvas>
  </div>
  <div class="hero-vignette"></div>
  <div class="hero-watermark reveal" style="--dy:20px" data-hero-delay="300" aria-hidden="true">TAUFAN</div>

  <div class="shell hero-grid">
    <div class="hero-left">
      <div class="hero-eyebrow-row reveal" style="--dy:10px" data-hero-delay="200">
        <span class="dot"></span><span>{{ \App\Models\Profile::current()->text('headline') }}</span>
      </div>

      <h1 class="hero-h1 reveal" data-hero-delay="250">
        <span class="line-clip"><span class="line-inner" style="transition-delay:0ms">{{ __('site.hero.l1') }}</span></span>
        <span class="line-clip"><span class="line-inner" style="transition-delay:120ms">{{ __('site.hero.l2') }}</span></span>
        <span class="line-clip"><span class="line-inner" style="transition-delay:240ms">{{ __('site.hero.l3') }}</span></span>
      </h1>

      <p class="hero-lead reveal" style="--dy:10px" data-hero-delay="500">{{ \App\Models\Profile::current()->text('intro') }}</p>

      <div class="hero-cta-row reveal" style="--dy:10px" data-hero-delay="650">
        <a href="{{ route('projects.index') }}" class="pill-btn dark with-arrow arrow-right hover-pill">
          <span style="padding-left:.5rem">{{ __('site.hero.work') }}</span>
          <span class="pill-arrow-badge"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
        </a>
        <a href="{{ route('about') }}" class="pill-btn outline no-arrow hover-pill">{{ __('site.hero.about') }}</a>
      </div>
    </div>
  </div>

  <div class="shell hero-statusbar reveal" data-hero-delay="800">
    <span>{{ __('site.hero.since') }}</span>
    <span class="mid">{{ __('site.hero.based') }}</span>
  </div>
</section>

<!-- ================= ABOUT TEASER ================= -->
<section class="home-sec" id="about-teaser">
  <div class="shell home-inner home-about">
    <div>
      <h2 class="home-h2">{{ __('site.home.about_h') }}</h2>
      <p class="home-p">{{ __('site.home.about_p') }}</p>
    </div>
    <a href="{{ route('about') }}" class="pill-btn dark with-arrow arrow-right hover-pill">
      <span style="padding-left:.5rem">{{ __('site.home.about_cta') }}</span>
      <span class="pill-arrow-badge"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
    </a>
  </div>
</section>

<!-- ================= PROJECTS PREVIEW ================= -->
<section class="home-sec alt" id="works">
  <div class="shell home-inner">
    <div class="home-head">
      <div>
        <h2 class="home-h2">{{ __('site.nav.projects') }}</h2>
        <p class="home-p">{{ __('site.home.projects_p') }}</p>
      </div>
      <a href="{{ route('projects.index') }}" class="home-all">{{ __('site.home.all_count', ['count' => $projectCount]) }} →</a>
    </div>
    <ul class="mini-grid four">
      @foreach ($projects as $i => $project)
        @include('projects.mini', ['project' => $project, 'i' => $i])
      @endforeach
    </ul>
  </div>
</section>

<!-- ================= CURRENTLY READING ================= -->
<section class="home-sec" id="reading">
  <div class="shell home-inner">
    <div class="home-head">
      <h2 class="home-h2">{{ __('site.books.reading') }}</h2>
      <a href="{{ route('books.index') }}" class="home-all">{{ __('site.home.reading_all') }}</a>
    </div>
    <div class="book-list">
      @forelse ($books as $book)
        <div class="book-row has-cover">
          @if ($book->cover)<img class="book-cover" src="{{ asset($book->cover) }}" alt="{{ $book->title }}" width="56" height="84" loading="lazy" decoding="async">@endif
          <div class="book-info"><strong>{{ $book->title }}</strong><small>{{ $book->author }}</small></div>
        </div>
      @empty
        <p class="journal-empty">{{ __('site.home.reading_empty') }}</p>
      @endforelse
    </div>
  </div>
</section>

<!-- ================= WRITING PREVIEW ================= -->
<section class="home-sec alt" id="writing">
  <div class="shell home-inner">
    <div class="home-head">
      <div>
        <h2 class="home-h2">{{ __('site.home.writing') }}</h2>
        <p class="home-p">{{ __('site.home.writing_p') }}</p>
      </div>
      @if ($postCount > 0)<a href="{{ route('blog.index') }}" class="home-all">{{ __('site.home.all_count', ['count' => $postCount]) }} →</a>@endif
    </div>
    <div class="post-list">
      @forelse ($posts as $post)
        <a href="{{ route('blog.show', ['slug' => $post->slug]) }}" class="post-row">
          <div>
            <time class="journal-meta" datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->translatedFormat('d M Y') }}</time>
            <h3>{{ $post->t('title') }}</h3>
            @if (filled($post->t('excerpt')))<p>{{ $post->t('excerpt') }}</p>@endif
          </div>
          <span class="journal-more">{{ __('site.home.read_more') }} →</span>
        </a>
      @empty
        <p class="journal-empty">{{ __('site.home.writing_empty') }}</p>
      @endforelse
    </div>
  </div>
</section>

<!-- ================= NEWS PREVIEW ================= -->
<section class="home-sec" id="news">
  <div class="shell home-inner">
    <div class="home-head">
      <h2 class="home-h2">{{ __('site.home.news_h') }}</h2>
      <a href="{{ route('news.index') }}" class="home-all">{{ __('site.home.news_all') }}</a>
    </div>
    <div class="book-list">
      @forelse ($news as $item)
        <a href="{{ $item->url }}" target="_blank" rel="noopener nofollow" class="book-row">
          <div><strong>{{ $item->title }}</strong><small>{{ $item->source }}</small></div>
          <span class="journal-meta">{{ $item->published_at?->diffForHumans(null, true, true) }}</span>
        </a>
      @empty
        <p class="journal-empty">{{ __('site.news.empty') }}</p>
      @endforelse
    </div>
  </div>
</section>
@endsection
