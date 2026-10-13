@php
  $locale = app()->getLocale();
  $route = Route::current();
  $routeName = $route?->getName();
  $routeParams = $route?->parameters() ?? [];
  $urlFor = fn (string $l) => $routeName ? route($routeName, array_merge($routeParams, ['locale' => $l])) : url('/'.$l);

  // A page that exists in one language only points its canonical there and skips hreflang.
  $onlyLocale = trim($__env->yieldContent('only_locale'));
  $canonical = \App\Support\Seo::absolute($urlFor($onlyLocale ?: $locale));
  if ((int) request('page') > 1) {
      $canonical .= '?page='.(int) request('page');
  }

  $pageTitle = trim($__env->yieldContent('title')) ?: __('site.seo.default_title');
  $pageDescription = trim($__env->yieldContent('description')) ?: __('site.seo.default_description');
  $ogImage = \App\Support\Seo::absolute(asset(trim($__env->yieldContent('og_image')) ?: config('site.og_image')));
  $robots = \App\Support\Seo::isIndexableHost()
      ? (trim($__env->yieldContent('robots')) ?: 'index,follow,max-image-preview:large')
      : 'noindex,nofollow';
  $ogType = trim($__env->yieldContent('og_type')) ?: 'website';
  $otherLocale = $locale === 'id' ? 'en' : 'id';
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $pageDescription }}" />
<meta name="robots" content="{{ $robots }}" />
<meta name="author" content="{{ config('site.name') }}" />
@if (config('site.google_verification'))<meta name="google-site-verification" content="{{ config('site.google_verification') }}" />@endif
<meta name="color-scheme" content="light dark" />
<meta name="theme-color" content="#0a0a0a" />
<script>(function(){try{var t=localStorage.getItem("theme");if(t!=="light"&&t!=="dark"){t=matchMedia("(prefers-color-scheme: dark)").matches?"dark":"light"}document.documentElement.setAttribute("data-theme",t)}catch(e){}})();</script>
<link rel="canonical" href="{{ $canonical }}" />
@unless ($onlyLocale)
<link rel="alternate" hreflang="id" href="{{ \App\Support\Seo::absolute($urlFor('id')) }}" />
<link rel="alternate" hreflang="en" href="{{ \App\Support\Seo::absolute($urlFor('en')) }}" />
<link rel="alternate" hreflang="x-default" href="{{ \App\Support\Seo::absolute($urlFor('en')) }}" />
@endunless
<meta property="og:site_name" content="{{ config('site.name') }}" />
<meta property="og:type" content="{{ $ogType }}" />
<meta property="og:title" content="{{ $pageTitle }}" />
<meta property="og:description" content="{{ $pageDescription }}" />
<meta property="og:url" content="{{ $canonical }}" />
<meta property="og:image" content="{{ $ogImage }}" />
<meta property="og:image:alt" content="{{ $pageTitle }}" />
<meta property="og:locale" content="{{ $locale === 'id' ? 'id_ID' : 'en_US' }}" />
@unless ($onlyLocale)
<meta property="og:locale:alternate" content="{{ $otherLocale === 'id' ? 'id_ID' : 'en_US' }}" />
@endunless
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $pageTitle }}" />
<meta name="twitter:description" content="{{ $pageDescription }}" />
<meta name="twitter:image" content="{{ $ogImage }}" />
<link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml" />
<link rel="preload" href="{{ asset('fonts/onest-latin.woff2') }}" as="font" type="font/woff2" crossorigin>
<style>@font-face{font-family:'Onest';font-style:normal;font-weight:400 700;font-display:swap;src:url({{ asset('fonts/onest-latin-ext.woff2') }}) format('woff2');unicode-range:U+0100-02BA,U+02BD-02C5,U+02C7-02CC,U+02CE-02D7,U+02DD-02FF,U+0304,U+0308,U+0329,U+1D00-1DBF,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20C4,U+2113,U+2C60-2C7F,U+A720-A7FF}@font-face{font-family:'Onest';font-style:normal;font-weight:400 700;font-display:swap;src:url({{ asset('fonts/onest-latin.woff2') }}) format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}</style>
<link rel="stylesheet" href="{{ asset('css/site.css') }}?v={{ filemtime(public_path('css/site.css')) }}">
<link rel="stylesheet" href="{{ asset('css/pages.css') }}?v={{ filemtime(public_path('css/pages.css')) }}">
{!! \App\Support\Seo::siteScript() !!}
@stack('jsonld')
</head>
<body class="@yield('body_class')">
<a href="#main" class="skip-link">{{ __('site.skip') }}</a>

@yield('loader')
@include('partials.header', ['urlFor' => $urlFor, 'otherLocale' => $otherLocale])

<main id="main">
@yield('content')
</main>

@include('partials.footer')
@include('partials.navmenu', ['urlFor' => $urlFor, 'otherLocale' => $otherLocale])
@include('partials.modal')
@include('partials.search')
@include('partials.player')

<link rel="modulepreload" href="{{ asset('js/vendor/lenis.js') }}">
<script type="importmap">
{ "imports": { "lenis": "{{ asset('js/vendor/lenis.js') }}" } }
</script>
<script type="module" src="{{ asset('js/site.js') }}?v={{ filemtime(public_path('js/site.js')) }}"></script>
<script type="module" src="{{ asset('js/extras.js') }}?v={{ filemtime(public_path('js/extras.js')) }}"></script>
</body>
</html>
