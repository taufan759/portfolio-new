<li class="reveal" style="--dy:24px" data-delay="{{ min($i, 8) * 60 }}" data-category="{{ $project->category }}">
  <a href="{{ route('projects.show', ['slug' => $project->slug]) }}" class="mini-card">
    <img src="{{ asset($project->image) }}" alt="{{ $project->title }}" width="1000" height="500" loading="lazy" decoding="async">
    <div class="mini-body">
      <span class="journal-meta">{{ $project->kind }}@if ($project->year) · {{ $project->year }}@endif</span>
      <h3>{{ $project->title }}</h3>
      <p>{{ $project->t('description') }}</p>
      <div class="mini-tags">@foreach (array_slice($project->tags ?? [], 0, 3) as $tag)<span>{{ $tag }}</span>@endforeach</div>
    </div>
  </a>
</li>
