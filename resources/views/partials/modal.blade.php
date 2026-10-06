<!-- ================= REQUEST MODAL ================= -->
<div id="request-modal" role="dialog" aria-modal="true" aria-label="Get in touch">
  <div class="modal-panel" id="modal-panel">
    <button class="modal-close" id="modal-close"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 4l16 16M20 4 4 20"/></svg></button>

    <div id="modal-form-state">
      <div class="modal-heading">
        <div class="modal-eyebrow"><span class="dot"></span>Get in touch</div>
        <h2 class="modal-h2">Tell me about your project.</h2>
      </div>
      <form class="modal-form" id="request-form" data-action="{{ route('contact.store') }}">
        <div class="modal-field">
          <label for="f-name">Name</label>
          <input id="f-name" name="name" type="text" required placeholder="Your name" />
        </div>
        <div class="modal-field">
          <label for="f-email">Email</label>
          <input id="f-email" name="email" type="email" required placeholder="you@company.com" />
        </div>
        <div class="modal-field">
          <label for="f-project">Project</label>
          <textarea id="f-project" name="project" rows="4" required placeholder="A few words about your project, timeline, and budget."></textarea>
        </div>
        <div class="modal-bottom-row">
          <span class="modal-note">I reply within one business day.</span>
          <span class="pill-btn dark with-arrow arrow-up hover-pill">
            <button type="submit" id="submit-btn" style="display:flex;align-items:center;gap:.75rem;background:none;border:none;color:inherit;font:inherit;cursor:pointer;padding-left:.5rem">
              <span id="submit-label">Send request</span>
            </button>
            <span class="pill-arrow-badge"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7M8 7h9v9"/></svg></span>
          </span>
        </div>
      </form>
    </div>

    <div id="modal-success-state" class="modal-success" hidden>
      <div class="modal-success-badge"><svg viewBox="0 0 48 48" fill="currentColor"><path d="M24 2c2.2 13.8 7.9 19.6 22 22-14.1 2.4-19.8 8.2-22 22-2.2-13.8-7.9-19.6-22-22 14.1-2.4 19.8-8.2 22-22Z"/></svg></div>
      <h2>Message received</h2>
      <p>Thanks for reaching out — I'll get back to you within one business day.</p>
      <span class="pill-btn dark no-arrow hover-pill" id="modal-success-close" role="button" tabindex="0" style="cursor:pointer">Close</span>
    </div>
  </div>
</div>
