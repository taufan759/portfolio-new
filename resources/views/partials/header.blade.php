<!-- ================= HEADER ================= -->
<header id="site-header">
  <div class="shell header-inner">
    <a class="brand-btn hover-brand" href="{{ route('home') }}" aria-label="{{ config('site.name') }} — {{ __('site.nav.home') }}">
      <svg viewBox="0 0 48 48" fill="currentColor" aria-hidden="true"><path d="M24 2c2.2 13.8 7.9 19.6 22 22-14.1 2.4-19.8 8.2-22 22-2.2-13.8-7.9-19.6-22-22 14.1-2.4 19.8-8.2 22-22Z"/></svg>
      <span>{{ config('site.short_name') }}</span>
    </a>

    <nav class="primary-nav" aria-label="{{ __('site.nav.primary') }}">
      <ul>
        @foreach ([['about', 'about', 'about'], ['projects.index', 'projects.*', 'projects'], ['blog.index', 'blog.*', 'blog'], ['books.index', 'books.*', 'books'], ['news.index', 'news.*', 'news']] as [$name, $pattern, $key])
          <li class="hover-nav"><a class="nav-label" href="{{ route($name) }}" @if (request()->routeIs($pattern)) aria-current="page" @endif>{{ __('site.nav.'.$key) }}</a></li>
        @endforeach
      </ul>
    </nav>

    <div class="header-right">
      <button type="button" class="icon-btn" data-open-search aria-label="{{ __('site.search.button') }}" title="{{ __('site.search.button') }} (Ctrl K)">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
      </button>
      <button type="button" class="icon-btn theme-toggle" id="theme-toggle" aria-label="{{ __('site.theme.toggle') }}" title="{{ __('site.theme.toggle') }}">
        <svg class="t-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>
        <svg class="t-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z"/></svg>
      </button>
      <div class="lang-switch" role="group" aria-label="{{ __('site.nav.language') }}">
        @foreach (['id' => 'ID', 'en' => 'EN'] as $code => $label)
          <a href="{{ $urlFor($code) }}" hreflang="{{ $code }}" lang="{{ $code }}" @if (app()->getLocale() === $code) aria-current="true" class="on" @endif>{{ $label }}</a>
        @endforeach
      </div>
      <button type="button" class="icon-btn hide-sm" data-open-modal aria-label="{{ __('site.nav.contact') }}" title="{{ __('site.nav.contact') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
      </button>
      <a class="icon-btn hide-sm" href="{{ config('site.resume') }}" target="_blank" rel="noopener" aria-label="{{ __('site.nav.resume') }}" title="{{ __('site.nav.resume') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-5Z"/><path d="M14 3v5h5M9 13h6M9 17h6"/></svg>
      </a>
      <button class="icon-btn only-sm" id="open-nav-menu" type="button" aria-label="{{ __('site.nav.menu') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>
    </div>
  </div>
</header>
