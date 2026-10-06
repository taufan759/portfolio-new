<!-- ================= REQUEST MODAL ================= -->
<div id="request-modal" role="dialog" aria-modal="true" aria-label="{{ __('site.modal.label') }}">
  <div class="modal-panel" id="modal-panel">
    <button class="modal-close" id="modal-close" type="button" aria-label="{{ __('site.nav.close') }}"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 4l16 16M20 4 4 20"/></svg></button>

    <div id="modal-form-state">
      <div class="modal-heading">
        <div class="modal-eyebrow"><span class="dot"></span>{{ __('site.modal.label') }}</div>
        <h2 class="modal-h2">{{ __('site.modal.h2') }}</h2>
      </div>
      <form class="modal-form" id="request-form" data-action="{{ route('contact.store') }}" data-sending="{{ __('site.modal.sending') }}" data-send="{{ __('site.modal.send') }}" data-failed="{{ __('site.modal.failed') }}">
        <div class="modal-field">
          <label for="f-name">{{ __('site.modal.name') }}</label>
          <input id="f-name" name="name" type="text" required autocomplete="name" placeholder="{{ __('site.modal.name_ph') }}" />
        </div>
        <div class="modal-field">
          <label for="f-email">{{ __('site.modal.email') }}</label>
          <input id="f-email" name="email" type="email" required autocomplete="email" placeholder="{{ __('site.modal.email_ph') }}" />
        </div>
        <div class="modal-field">
          <label for="f-project">{{ __('site.modal.project') }}</label>
          <textarea id="f-project" name="project" rows="4" required placeholder="{{ __('site.modal.project_ph') }}"></textarea>
        </div>
        <div class="modal-bottom-row">
          <span class="modal-note">{{ __('site.modal.note') }}</span>
          <span class="pill-btn dark with-arrow arrow-up hover-pill">
            <button type="submit" id="submit-btn" style="display:flex;align-items:center;gap:.75rem;background:none;border:none;color:inherit;font:inherit;cursor:pointer;padding-left:.5rem">
              <span id="submit-label">{{ __('site.modal.send') }}</span>
            </button>
            <span class="pill-arrow-badge"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></span>
          </span>
        </div>
      </form>
    </div>

    <div id="modal-success-state" class="modal-success" hidden>
      <div class="modal-success-badge"><svg viewBox="0 0 48 48" fill="currentColor" aria-hidden="true"><path d="M24 2c2.2 13.8 7.9 19.6 22 22-14.1 2.4-19.8 8.2-22 22-2.2-13.8-7.9-19.6-22-22 14.1-2.4 19.8-8.2 22-22Z"/></svg></div>
      <h2>{{ __('site.modal.done_h') }}</h2>
      <p>{{ __('site.modal.done_p') }}</p>
      <button type="button" class="pill-btn dark no-arrow hover-pill" id="modal-success-close">{{ __('site.nav.close') }}</button>
    </div>
  </div>
</div>
