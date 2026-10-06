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
        <li class="hover-nav"><button class="nav-label" type="button" data-open-modal>{{ __('site.nav.contact') }}</button></li>
      </ul>
    </nav>

    <div class="header-right">
      <div class="lang-switch" role="group" aria-label="{{ __('site.nav.language') }}">
        @foreach (['id' => 'ID', 'en' => 'EN'] as $code => $label)
          <a href="{{ $urlFor($code) }}" hreflang="{{ $code }}" lang="{{ $code }}" @if (app()->getLocale() === $code) aria-current="true" class="on" @endif>{{ $label }}</a>
        @endforeach
      </div>
      <button class="menu-btn hover-menu" id="open-nav-menu" type="button" aria-label="{{ __('site.nav.menu') }}">
        <span class="menu-btn-inner">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
          <span class="menu-word">{{ __('site.nav.menu') }}</span>
        </span>
      </button>
    </div>
  </div>
</header>
