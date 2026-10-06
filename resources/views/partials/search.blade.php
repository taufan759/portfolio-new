<!-- ================= SEARCH ================= -->
<div id="search" class="search" role="dialog" aria-modal="true" aria-label="{{ __('site.search.button') }}" hidden
     data-src="{{ route('search.index') }}"
     data-types="{{ json_encode(__('site.search.types'), JSON_UNESCAPED_UNICODE) }}"
     data-empty="{{ __('site.search.empty') }}"
     data-hint="{{ __('site.search.hint') }}"
     data-loading="{{ __('site.search.loading') }}">
  <div class="search-panel">
    <div class="search-top">
      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
      <input id="search-input" type="search" placeholder="{{ __('site.search.placeholder') }}" autocomplete="off" autocapitalize="off" spellcheck="false" aria-controls="search-results" />
      <button type="button" id="search-close" class="search-esc" aria-label="{{ __('site.search.close') }}"><span class="search-esc-text">ESC</span><svg class="icon search-esc-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M5 5l14 14M19 5 5 19"/></svg></button>
    </div>
    <ul id="search-results" class="search-results" role="listbox"></ul>
    <p id="search-empty" class="search-empty" hidden></p>
  </div>
</div>
