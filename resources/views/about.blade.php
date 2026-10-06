@php($profile = \App\Models\Profile::current())
@extends('layouts.site')
@section('title', __('site.about.title'))
@section('description', __('site.about.description'))

@push('jsonld')
{!! \App\Support\Seo::script(['@type' => 'AboutPage', 'name' => __('site.about.title'), 'url' => route('about'), 'inLanguage' => app()->getLocale(), 'mainEntity' => ['@id' => \App\Support\Seo::personId()]]) !!}
{!! \App\Support\Seo::script(\App\Support\Seo::faq(__('site.about.faq_items'))) !!}
@endpush

@section('content')
<!-- ================= INTRODUCTION ================= -->
<section class="page-main">
  <div class="shell page-inner about-intro">
    @include('partials.breadcrumbs', ['crumbs' => [[__('site.breadcrumb_home'), route('home')], [__('site.about.eyebrow'), route('about')]]])
    <h1 class="page-h1">{{ config('site.name') }}</h1>
    <p class="about-role">{{ $profile->text('headline') }}</p>
    <p class="about-lede">{{ $profile->text('summary') }}</p>

    <dl class="about-facts">
      <div><dt>{{ __('site.about.facts.location') }}</dt><dd>{{ $profile->text('location') }}</dd></div>
      <div><dt>{{ __('site.about.facts.education') }}</dt><dd>{{ $profile->text('education') }}</dd></div>
      <div><dt>{{ __('site.about.facts.languages') }}</dt><dd>{{ __('site.about.languages_value') }}</dd></div>
      <div><dt>{{ __('site.about.facts.availability') }}</dt><dd>{{ $profile->text('availability') }}</dd></div>
    </dl>

    <div class="about-find-label">{{ __('site.about.find') }}</div>
    <div class="about-links">
      @foreach (config('site.social') as $label => $url)
        <a href="{{ $url }}" target="_blank" rel="me noopener" class="pill-btn outline no-arrow hover-pill">{{ $label }}</a>
      @endforeach
      <a href="{{ config('site.resume') }}" target="_blank" rel="noopener" class="pill-btn dark no-arrow hover-pill">{{ __('site.nav.resume') }}</a>
    </div>
  </div>
</section>

<!-- ================= BACKGROUND ================= -->
<section class="home-sec alt">
  <div class="shell home-inner about-story">
    <h2 class="home-h2">{{ __('site.about.story') }}</h2>
    <div class="prose">{!! \Illuminate\Support\Str::markdown($profile->text('story'), ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}</div>
  </div>
</section>

<!-- ================= AREAS OF FOCUS ================= -->
<section class="home-sec">
  <div class="shell home-inner">
    <h2 class="home-h2">{{ __('site.about.focus') }}</h2>
    <ul class="focus-grid">
      @foreach (__('site.about.focus_items') as $i => [$name, $desc])
        <li class="focus-card reveal" style="--dy:20px" data-delay="{{ $i * 70 }}">
          <span class="focus-index">{{ sprintf('%02d', $i + 1) }}</span>
          <h3>{{ $name }}</h3>
          <p>{{ $desc }}</p>
        </li>
      @endforeach
    </ul>
  </div>
</section>

<!-- ================= TOOLS & ORGANIZATIONS ================= -->
<section class="home-sec alt">
  <div class="shell home-inner">
    <h2 class="home-h2">{{ __('site.about.skills') }}</h2>
    <ul class="chip-list">
      @foreach ($profile->skillList() as $skill)<li>{{ $skill }}</li>@endforeach
    </ul>

    <h2 class="home-h2 chip-gap">{{ __('site.about.orgs') }}</h2>
    <ul class="chip-list plain">
      @foreach (config('site.orgs') as $org)<li>{{ $org }}</li>@endforeach
    </ul>
  </div>
</section>

<!-- ================= AT A GLANCE ================= -->
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

<!-- ================= CERTIFICATIONS ================= -->
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
<section class="faq-section" id="faq">
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
