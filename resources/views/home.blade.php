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
  <div class="liquid-wrap" id="liquid-wrap" data-before="{{ asset('images/hero/before.webp') }}" data-after="{{ asset('images/hero/after.webp') }}" data-flip-label="{{ __('site.hero.flip') }}">
    <img id="liquid-base" src="{{ asset('images/hero/before.webp') }}" alt="{{ config('site.name') }}" width="1341" height="1173" fetchpriority="high" />
    <img id="liquid-alt" src="{{ asset('images/hero/after.webp') }}" alt="" aria-hidden="true" width="1254" height="1254" fetchpriority="high" />
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

@if ($partners->isNotEmpty())
<!-- ================= WORKPLACES & COLLABORATIONS ================= -->
@php($reps = max(1, (int) ceil(14 / $partners->count())))
<section class="home-sec partners-sec" id="partners" aria-labelledby="partners-h">
  <h2 class="sr-only" id="partners-h">{{ __('site.home.partners_h') }}</h2>
  <div class="logo-slider" style="--logo-speed:{{ max(40, $partners->count() * $reps * 4) }}s">
    <div class="logo-track">
      @foreach ([0, 1] as $copy)
        <ul class="logo-set" @if ($copy) aria-hidden="true" @endif>
          @for ($r = 0; $r < $reps; $r++)
            @foreach ($partners as $partner)
              <li class="logo-tile">
                @if ($partner->url)<a href="{{ $partner->url }}" target="_blank" rel="noopener nofollow" @if ($copy || $r) tabindex="-1" @endif title="{{ $partner->name }}">@endif
                @if ($partner->logo)
                  <img src="{{ asset($partner->logo) }}" alt="{{ $copy || $r ? '' : $partner->name }}" title="{{ $partner->name }}" width="120" height="120" decoding="async" @if ($copy) loading="lazy" @endif>
                @else
                  <span class="logo-text">{{ $partner->name }}</span>
                @endif
                @if ($partner->url)</a>@endif
              </li>
            @endforeach
          @endfor
        </ul>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- ================= ABOUT PREVIEW ================= -->
@php($profile = \App\Models\Profile::current())
<section class="home-sec" id="about-teaser">
  <div class="shell home-inner">
    <div class="home-head">
      <div>
        <h2 class="home-h2">{{ __('site.home.about_h') }}</h2>
        <p class="home-p">{{ __('site.home.about_p') }}</p>
      </div>
      <a href="{{ route('about') }}" class="home-all">{{ __('site.home.about_cta') }} →</a>
    </div>

    <div class="about-preview">
      <div class="about-preview-main">
        <p class="about-lede">{{ $profile->text('summary') }}</p>
        <ul class="chip-list">
          @foreach (array_slice($profile->skillList(), 0, 8) as $skill)<li>{{ $skill }}</li>@endforeach
        </ul>
      </div>
      <dl class="about-facts about-facts-stack">
        <div><dt>{{ __('site.about.facts.availability') }}</dt><dd>{{ $profile->text('availability') }}</dd></div>
        <div><dt>{{ __('site.about.facts.location') }}</dt><dd>{{ $profile->text('location') }}</dd></div>
        <div><dt>{{ __('site.about.facts.education') }}</dt><dd>{{ $profile->text('education') }}</dd></div>
      </dl>
    </div>
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
    <ul class="mini-grid">
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
