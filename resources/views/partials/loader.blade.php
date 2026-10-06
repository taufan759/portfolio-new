<div id="loader" aria-hidden="true">
  <div class="loader-center">
    <div class="loader-brand">
      <svg viewBox="0 0 48 48" fill="currentColor"><path d="M24 2c2.2 13.8 7.9 19.6 22 22-14.1 2.4-19.8 8.2-22 22-2.2-13.8-7.9-19.6-22-22 14.1-2.4 19.8-8.2 22-22Z"/></svg>
      <span>{{ config('site.short_name') }}</span>
    </div>
    <p class="loader-tag">{{ __('site.hero.loader_tag') }}</p>
  </div>
  <div class="loader-progress">
    <div class="loader-track"><div class="loader-fill" id="loader-fill"></div></div>
    <div class="loader-meta">
      <span>{{ __('site.hero.loading') }}</span>
      <span class="loader-count" id="loader-count">000</span>
    </div>
  </div>
</div>
