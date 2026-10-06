<!-- ================= NAV MENU ================= -->
<div id="nav-menu" role="dialog" aria-modal="true" aria-label="{{ __('site.nav.overlay') }}">
  <div class="shell nm-top">
    <div class="nm-brand"><svg viewBox="0 0 48 48" fill="currentColor" aria-hidden="true"><path d="M24 2c2.2 13.8 7.9 19.6 22 22-14.1 2.4-19.8 8.2-22 22-2.2-13.8-7.9-19.6-22-22 14.1-2.4 19.8-8.2 22-22Z"/></svg><span>{{ config('site.short_name') }}</span></div>
    <button class="nm-close" id="close-nav-menu" type="button"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 4l16 16M20 4 4 20"/></svg><span>{{ __('site.nav.close') }}</span></button>
  </div>
  <nav class="nm-nav" aria-label="{{ __('site.nav.overlay') }}">
    <ul>
      @php($i = 0)
      @foreach ([['home', 'home'], ['about', 'about'], ['projects.index', 'projects'], ['blog.index', 'blog'], ['books.index', 'books'], ['news.index', 'news']] as [$name, $key])
        @php($i++)
        <li><a class="nav-menu-item" href="{{ route($name) }}" style="transition-delay:{{ 80 + $i * 45 }}ms"><span class="nav-menu-index">{{ sprintf('%02d', $i) }}</span><span class="nav-menu-label">{{ __('site.nav.'.$key) }}</span></a></li>
      @endforeach
      <li><a class="nav-menu-item" href="{{ config('site.resume') }}" target="_blank" rel="noopener" style="transition-delay:{{ 80 + 7 * 45 }}ms"><span class="nav-menu-index">07</span><span class="nav-menu-label">{{ __('site.nav.resume') }}</span></a></li>
      <li><button class="nav-menu-item" type="button" data-open-modal style="transition-delay:{{ 80 + 8 * 45 }}ms"><span class="nav-menu-index">08</span><span class="nav-menu-label">{{ __('site.nav.contact') }}</span></button></li>
    </ul>
  </nav>
  <div class="shell nm-bottom">
    <span class="nm-lang">
      @foreach (['id' => 'Bahasa Indonesia', 'en' => 'English'] as $code => $label)
        <a href="{{ $urlFor($code) }}" hreflang="{{ $code }}" lang="{{ $code }}" @if (app()->getLocale() === $code) aria-current="true" class="on" @endif>{{ $label }}</a>
      @endforeach
    </span>
    <button class="nm-start" id="nm-start-project" type="button">{{ __('site.nav.start') }}</button>
  </div>
</div>
