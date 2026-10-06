<li class="reveal" style="--dy:48px" data-delay="{{ min($i, 8) * 90 }}" data-category="{{ $project->category }}">
  <a href="{{ route('projects.show', ['slug' => $project->slug]) }}" class="portfolio-card-link">
    <article class="portfolio-card">
      <div class="pc-top">
        <span>{{ $project->kind }}@if ($project->year) — {{ $project->year }}@endif</span>
        <span class="portfolio-badge"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></span>
      </div>
      <div class="pc-image">
        <div class="pc-browserbar"><span></span><span></span><span></span></div>
        <div class="pc-image-frame"><img src="{{ asset($project->image) }}" alt="{{ $project->title }}" width="1000" height="500" loading="lazy" decoding="async" /></div>
      </div>
      <div class="pc-bottom">
        <h3>{{ $project->title }}</h3>
        <p>{{ $project->t('description') }}</p>
        <div class="pc-tags">
          @foreach ($project->tags ?? [] as $tag)<span class="tag-chip">{{ $tag }}</span>@endforeach
        </div>
      </div>
    </article>
  </a>
</li>
