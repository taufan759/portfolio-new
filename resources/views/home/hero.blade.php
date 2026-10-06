  <!-- ================= HERO ================= -->
  <section id="home">
    <div class="liquid-wrap" id="liquid-wrap" data-after="{{ asset('images/hero/after.webp') }}">
      <img id="liquid-base" src="{{ asset('images/hero/before.webp') }}" alt="Muhammad Taufan Akbar" />
      <canvas id="liquid-canvas" aria-hidden="true"></canvas>
    </div>
    <div class="hero-vignette"></div>
    <div class="hero-watermark reveal" style="--dy:20px" data-hero-delay="300">TAUFAN</div>

    <div class="shell hero-grid">
      <div class="hero-left">
        <div class="hero-eyebrow-row reveal" style="--dy:10px" data-hero-delay="200">
          <span class="dot"></span><span>Full-Stack Developer & AI Enthusiast</span>
        </div>

        <h1 class="hero-h1 reveal" data-hero-delay="250">
          <span class="line-clip"><span class="line-inner" style="transition-delay:0ms">Crafting ideas,</span></span>
          <span class="line-clip"><span class="line-inner" style="transition-delay:120ms">into scalable</span></span>
          <span class="line-clip"><span class="line-inner" style="transition-delay:240ms">digital products</span></span>
        </h1>

        <div class="hero-rating reveal" style="--dy:10px" data-hero-delay="650">
          <span class="hero-stars">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.5l2.9 5.88 6.49.94-4.7 4.58 1.11 6.46L12 17.9l-5.8 3.05 1.1-6.46-4.69-4.58 6.49-.94L12 2.5z"/></svg>
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.5l2.9 5.88 6.49.94-4.7 4.58 1.11 6.46L12 17.9l-5.8 3.05 1.1-6.46-4.69-4.58 6.49-.94L12 2.5z"/></svg>
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.5l2.9 5.88 6.49.94-4.7 4.58 1.11 6.46L12 17.9l-5.8 3.05 1.1-6.46-4.69-4.58 6.49-.94L12 2.5z"/></svg>
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.5l2.9 5.88 6.49.94-4.7 4.58 1.11 6.46L12 17.9l-5.8 3.05 1.1-6.46-4.69-4.58 6.49-.94L12 2.5z"/></svg>
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.5l2.9 5.88 6.49.94-4.7 4.58 1.11 6.46L12 17.9l-5.8 3.05 1.1-6.46-4.69-4.58 6.49-.94L12 2.5z"/></svg>
          </span>
          <span class="hero-rating-text">25+ projects delivered</span>
        </div>

        <div class="hero-cta-row reveal" style="--dy:10px" data-hero-delay="750">
          <span class="pill-btn dark with-arrow arrow-right hover-pill" data-open-modal role="button" tabindex="0" style="cursor:pointer">
            <span style="padding-left:.5rem">Let's Talk</span>
            <span class="pill-arrow-badge"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
          </span>
          <span class="pill-btn outline no-arrow hover-pill" data-scrollto="works" role="button" tabindex="0" style="cursor:pointer">View Work</span>
        </div>
      </div>

      <div class="hero-right">
        <div class="hero-card reveal" style="--dy:16px;--sc:.96" data-hero-delay="400">
          <div class="hero-card-row" id="hero-carousel">
            <div class="hero-card-tile"><svg viewBox="0 0 48 48" fill="currentColor"><path d="M24 2c2.2 13.8 7.9 19.6 22 22-14.1 2.4-19.8 8.2-22 22-2.2-13.8-7.9-19.6-22-22 14.1-2.4 19.8-8.2 22-22Z"/></svg></div>
            <div class="hero-card-panel">
              <div class="hero-card-slot" id="hero-card-slot">
                <div class="hero-card-item active" data-i="0">
                  <div class="hero-card-caption">Full-Stack Development</div>
                  <div class="hero-card-title">Built to scale.</div>
                </div>
              </div>
              <div class="hero-card-bottom">
                <div class="hero-card-dots" id="hero-card-dots">
                  <span class="hero-card-dot active"></span>
                  <span class="hero-card-dot"></span>
                  <span class="hero-card-dot"></span>
                </div>
                <div class="hero-card-nav">
                  <button class="hero-card-btn prev" id="hero-prev" aria-label="Previous"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></button>
                  <button class="hero-card-btn next" id="hero-next" aria-label="Next"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="partners-block reveal" style="--dy:14px" data-hero-delay="550">
          <div class="partners-label">Worked with</div>
          <div class="partners-grid">
            <span class="partner-item"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="3.2" fill="currentColor" stroke="none"/></svg>BSI</span>
            <span class="partner-item"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="3.2" fill="currentColor" stroke="none"/></svg>GreatEdu</span>
            <span class="partner-item"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="3.2" fill="currentColor" stroke="none"/></svg>DBS</span>
            <span class="partner-item"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="3.2" fill="currentColor" stroke="none"/></svg>Dicoding</span>
            <span class="partner-item"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="3.2" fill="currentColor" stroke="none"/></svg>Kemenag</span>
            <span class="partner-item"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="3.2" fill="currentColor" stroke="none"/></svg>Adaptable</span>
            <span class="partner-item"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="3.2" fill="currentColor" stroke="none"/></svg>Nibras</span>
          </div>
        </div>
      </div>
    </div>

    <div class="shell hero-statusbar reveal" data-hero-delay="900">
      <span>Building since 2023</span>
      <span class="mid">Based in Tegal, Indonesia</span>
      <span class="right">Scroll to explore <span>↓</span></span>
    </div>
  </section>
