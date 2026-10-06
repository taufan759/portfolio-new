  <!-- ================= CERTIFICATES ================= -->
  <section id="certificates">
    <div class="shell certificates-inner">
      <div class="eyebrow reveal">Certificates</div>
      <h2 class="certificates-h2 reveal" data-delay="120">
        <span class="line-clip"><span class="line-inner">Continuous learning</span></span>
      </h2>
      <ul class="certificates-grid">
        @foreach ($certificates as $i => $cert)
        <li class="reveal" style="--dy:24px" data-delay="{{ min($i, 11) * 60 }}">
          <div class="cert-card">
            <div class="cert-image"><img src="{{ asset($cert->image) }}" alt="{{ $cert->title }} certificate" width="800" height="600" loading="lazy" decoding="async" /></div>
            <div class="cert-info"><h3>{{ $cert->title }}</h3><p>{{ $cert->issuer }}</p></div>
          </div>
        </li>
        @endforeach
        <li class="reveal" style="--dy:24px" data-delay="720">
          <a href="https://www.linkedin.com/in/taufanhs/details/certifications/" target="_blank" rel="noopener" class="cert-card cert-card-more">
            <span class="cert-more-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7M8 7h9v9"/></svg></span>
            <p>View more on LinkedIn</p>
          </a>
        </li>
      </ul>
    </div>
  </section>
