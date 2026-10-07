<!-- ================= FOOTER ================= -->
<footer>
  <div class="shell footer-inner">
    <div class="footer-cta">
      <h2 class="footer-h2 reveal">
        <span class="line-clip"><span class="line-inner" style="transition-delay:0ms">{{ __('site.footer.cta1') }}</span></span>
        <span class="line-clip"><span class="line-inner" style="transition-delay:100ms">{{ __('site.footer.cta2') }}</span></span>
      </h2>
      <button type="button" class="pill-btn light with-arrow arrow-up hover-pill" data-open-modal>
        <span style="padding-left:.5rem">{{ __('site.footer.start') }}</span>
        <span class="pill-arrow-badge"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></span>
      </button>
    </div>

    <div class="footer-columns">
      <div class="footer-col">
        <div class="footer-brand"><svg viewBox="0 0 48 48" fill="currentColor" aria-hidden="true"><path d="M24 2c2.2 13.8 7.9 19.6 22 22-14.1 2.4-19.8 8.2-22 22-2.2-13.8-7.9-19.6-22-22 14.1-2.4 19.8-8.2 22-22Z"/></svg><span>{{ config('site.short_name') }}</span></div>
        <p class="footer-tagline">{{ __('site.footer.tagline') }}</p>
        <p class="footer-tagline" style="margin-top:.75rem"><a href="mailto:{{ config('site.email') }}" class="animated-link"><span class="animated-link-inner">{{ config('site.email') }}</span></a></p>
        <p class="footer-tagline" style="margin-top:.25rem"><a href="tel:{{ config('site.phone') }}" class="animated-link"><span class="animated-link-inner">{{ config('site.phone_display') }}</span></a></p>
      </div>
      <div class="footer-col">
        <div class="footer-col-title">{{ __('site.footer.explore') }}</div>
        <ul>
          @foreach ([['about', 'about'], ['projects.index', 'projects'], ['gallery.index', 'gallery'], ['blog.index', 'blog'], ['books.index', 'books'], ['news.index', 'news']] as [$name, $key])
            <li><a href="{{ route($name) }}" class="animated-link"><span class="animated-link-inner">{{ __('site.nav.'.$key) }}</span></a></li>
          @endforeach
          <li><a href="{{ config('site.resume') }}" target="_blank" rel="noopener" class="animated-link"><span class="animated-link-inner">{{ __('site.nav.resume') }}</span></a></li>
        </ul>
      </div>
      <div class="footer-col">
        <div class="footer-col-title">{{ __('site.footer.social') }}</div>
        <ul>
          @foreach (config('site.social') as $label => $url)
            <li><a href="{{ $url }}" target="_blank" rel="me noopener" class="animated-link"><span class="animated-link-inner">{{ $label }}</span></a></li>
          @endforeach
        </ul>
      </div>
      <div class="footer-col">
        <div class="footer-col-title">{{ __('site.footer.contact') }}</div>
        <ul>
          <li><button type="button" class="animated-link" data-open-modal><span class="animated-link-inner">{{ __('site.nav.contact') }}</span></button></li>
          <li><a href="mailto:{{ config('site.email') }}" class="animated-link"><span class="animated-link-inner">Email</span></a></li>
          <li><a href="{{ url('/llms.txt') }}" class="animated-link"><span class="animated-link-inner">llms.txt</span></a></li>
        </ul>
      </div>
    </div>

    <div class="footer-legal">
      <span>© {{ date('Y') }} {{ config('site.name') }}. {{ __('site.footer.rights') }}</span>
    </div>
  </div>
  <div class="footer-watermark" aria-hidden="true">TAUFAN</div>
</footer>
