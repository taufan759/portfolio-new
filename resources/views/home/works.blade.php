  <!-- ================= PORTFOLIO ================= -->
  <section id="works">
    <div class="shell works-inner">
      <div class="works-head">
        <div class="eyebrow bordered reveal">Portfolio</div>
        <h2 class="works-h2 reveal" data-delay="120">
          <span class="line-clip"><span class="line-inner">Selected Work</span></span>
        </h2>
      </div>

      <div class="works-filters reveal" data-delay="180">
        <button class="works-filter-btn active" data-filter="all">All Work</button>
        <button class="works-filter-btn" data-filter="fullstack">Full-Stack Development</button>
        <button class="works-filter-btn" data-filter="uiux">UI/UX Design</button>
        <button class="works-filter-btn" data-filter="ai">AI Integration</button>
      </div>

      <ul class="works-grid" id="works-grid">
        <li class="works-empty" id="works-empty" hidden>More work in this category is on the way — check back soon.</li>
        @foreach ($projects as $i => $project)
        <li class="reveal" style="--dy:48px" data-delay="{{ min($i, 8) * 90 }}" data-category="{{ $project->category }}">
          <a href="{{ $project->url ?: '#' }}" @if($project->url) target="_blank" rel="noopener" @endif class="portfolio-card-link">
            <article class="portfolio-card">
              <div class="pc-top">
                <span>{{ $project->kind }} — {{ $project->year }}</span>
                <span class="portfolio-badge"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7M8 7h9v9"/></svg></span>
              </div>
              <div class="pc-image">
                <div class="pc-browserbar"><span></span><span></span><span></span></div>
                <div class="pc-image-frame"><img src="{{ asset($project->image) }}" alt="{{ $project->title }} screenshot" width="1000" height="500" loading="lazy" decoding="async" /></div>
              </div>
              <div class="pc-bottom">
                <h3>{{ $project->title }}</h3>
                <p>{{ $project->description }}</p>
                <div class="pc-tags">
                  @foreach ($project->tags ?? [] as $tag)<span class="tag-chip">{{ $tag }}</span>@endforeach
                </div>
              </div>
            </article>
          </a>
        </li>
        @endforeach
      </ul>
    </div>
  </section>
