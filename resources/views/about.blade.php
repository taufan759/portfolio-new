@extends('layouts.site')
@section('title', __('site.about.title'))
@section('description', __('site.about.description'))

@push('jsonld')
{!! \App\Support\Seo::script(['@type' => 'AboutPage', 'name' => __('site.about.title'), 'url' => route('about'), 'inLanguage' => app()->getLocale(), 'mainEntity' => ['@id' => \App\Support\Seo::personId()]]) !!}
{!! \App\Support\Seo::script(\App\Support\Seo::faq(__('site.about.faq_items'))) !!}
@endpush

@section('content')
<!-- ================= INTRO ================= -->
<section class="page-main">
  <div class="shell page-inner about-intro">
    @include('partials.breadcrumbs', ['crumbs' => [[__('site.breadcrumb_home'), route('home')], [__('site.about.eyebrow'), route('about')]]])
    <h1 class="page-h1">{{ __('site.about.h1') }}</h1>
    <div class="about-copy">
      <p class="about-lede">{{ __('site.about.p1') }}</p>
      <p>{{ __('site.about.p2') }}</p>
      <p class="journal-meta" style="white-space:normal">{{ __('site.about.location') }}</p>
      <div class="about-detail">
        <span>GPA 3.98/4.00</span><span class="sep">·</span><span>TOEFL 563</span><span class="sep">·</span><span>{{ __('site.about.edu') }}</span>
      </div>
      <div class="about-find-label">{{ __('site.about.find') }}</div>
      <div class="about-links">
        @foreach (config('site.social') as $label => $url)
          <a href="{{ $url }}" target="_blank" rel="me noopener" class="pill-btn outline no-arrow hover-pill">{{ $label }}</a>
        @endforeach
        <a href="{{ config('site.resume') }}" target="_blank" rel="noopener" class="pill-btn dark no-arrow hover-pill">{{ __('site.nav.resume') }}</a>
      </div>
    </div>
  </div>
</section>

<!-- ================= SERVICES ================= -->
<section id="services">
  <div class="shell services-inner">
    <h2 class="services-h2 reveal"><span class="line-clip"><span class="line-inner">{{ __('site.about.services') }}</span></span></h2>
    <ul>
      @foreach (__('site.about.service_items') as $i => [$name, $desc])
        <li class="service-item reveal" style="--dy:24px" data-delay="{{ $i * 80 }}">
          <div class="service-row-inner">
            <span class="service-index">{{ sprintf('%02d', $i + 1) }}</span>
            <h3 class="service-title">{{ $name }}</h3>
            <p class="service-desc">{{ $desc }}</p>
          </div>
        </li>
      @endforeach
    </ul>
  </div>
</section>

<!-- ================= PROCESS ================= -->
<section class="process-section" id="process">
  <div class="process-grid-bg"></div>
  <div class="process-glow"></div>
  <div class="shell process-inner">
    <div class="process-head">
      <h2 class="process-h2 reveal"><span class="line-clip"><span class="line-inner">{{ __('site.about.process') }}</span></span></h2>
    </div>
    <ul class="process-list">
      @foreach (__('site.about.process_items') as $i => [$name, $desc])
        <li class="process-step reveal" style="--dy:28px" data-delay="{{ $i * 120 }}">
          <span class="process-index">{{ sprintf('%02d', $i + 1) }}</span>
          <h3>{{ $name }}</h3>
          <p>{{ $desc }}</p>
        </li>
        @unless ($loop->last)<li class="process-connector" aria-hidden="true"><span class="process-connector-line"></span></li>@endunless
      @endforeach
    </ul>
  </div>
</section>

<!-- ================= STATS ================= -->
<section class="stats-section">
  <div class="shell stats-outer">
    <div class="stats-panel reveal" style="--dy:40px;--sc:.99">
      <div class="eyebrow light">{{ __('site.about.stats') }}</div>
      <ul class="stats-grid">
        @foreach ([25, 13, 2, 20] as $i => $n)
          <li class="reveal" style="--dy:20px" data-delay="{{ $i * 90 }}">
            <div class="stat-number"><span class="stat-count" data-target="{{ $n }}">{{ $n }}</span>+</div>
            <div class="stat-label">{{ __('site.about.stat_items')[$i] }}</div>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
</section>

<!-- ================= CERTIFICATES ================= -->
<section id="certificates">
  <div class="shell certificates-inner">
    <div class="eyebrow reveal">{{ __('site.about.certs') }}</div>
    <h2 class="certificates-h2 reveal" data-delay="120"><span class="line-clip"><span class="line-inner">{{ __('site.about.certs_h') }}</span></span></h2>
    <ul class="certificates-grid">
      @foreach ($certificates as $i => $cert)
        <li class="reveal" style="--dy:24px" data-delay="{{ min($i, 11) * 60 }}">
          <div class="cert-card">
            <div class="cert-image"><img src="{{ asset($cert->image) }}" alt="{{ $cert->title }} — {{ $cert->issuer }}" width="800" height="600" loading="lazy" decoding="async" /></div>
            <div class="cert-info"><h3>{{ $cert->title }}</h3><p>{{ $cert->issuer }}</p></div>
          </div>
        </li>
      @endforeach
      <li class="reveal" style="--dy:24px" data-delay="720">
        <a href="{{ config('site.social.LinkedIn') }}details/certifications/" target="_blank" rel="noopener" class="cert-card cert-card-more">
          <span class="cert-more-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></span>
          <p>{{ __('site.about.certs_more') }}</p>
        </a>
      </li>
    </ul>
  </div>
</section>

<!-- ================= FAQ ================= -->
<section class="faq-section">
  <div class="shell page-inner">
    <h2 class="page-h2 faq-h2">{{ __('site.about.faq') }}</h2>
    <div class="faq">
      @foreach (__('site.about.faq_items') as [$q, $a])
        <details @if ($loop->first) open @endif>
          <summary>{{ $q }}</summary>
          <p>{{ $a }}</p>
        </details>
      @endforeach
    </div>
  </div>
</section>
@endsection
