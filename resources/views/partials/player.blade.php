@if (config('music.enabled') && count(config('music.channels')))
<!-- ================= MUSIC PLAYER ================= -->
<div id="player" class="player" role="region" aria-label="{{ __('site.player.label') }}"
     data-channels="{{ json_encode(config('music.channels'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}"
     data-l-now="{{ __('site.player.now') }}" data-l-paused="{{ __('site.player.paused') }}"
     data-l-play="{{ __('site.player.play') }}" data-l-pause="{{ __('site.player.pause') }}"
     data-l-loading="{{ __('site.player.loading') }}" data-l-error="{{ __('site.player.error') }}"
     data-l-mute="{{ __('site.player.mute') }}" data-l-unmute="{{ __('site.player.unmute') }}">
  <audio id="player-audio" preload="none"></audio>

  <div class="player-panel" id="player-panel" hidden>
    <ul class="player-list">
      @foreach (config('music.channels') as $ch)
        <li><button type="button" class="player-ch" data-ch="{{ $ch['id'] }}"><span class="player-ch-icon" aria-hidden="true">{{ $ch['icon'] }}</span><span>{{ $ch['name'] }}</span></button></li>
      @endforeach
    </ul>
    <small class="player-credit">{{ __('site.player.credit') }}</small>
  </div>

  <div class="player-bar">
    <button type="button" class="player-toggle" id="player-toggle" aria-label="{{ __('site.player.play') }}">
      <svg class="p-play" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5.5v13a1 1 0 0 0 1.5.86l10.5-6.5a1 1 0 0 0 0-1.72L9.5 4.64A1 1 0 0 0 8 5.5Z"/></svg>
      <svg class="p-pause" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="6" y="5" width="4" height="14" rx="1"/><rect x="14" y="5" width="4" height="14" rx="1"/></svg>
    </button>
    <button type="button" class="player-info" id="player-info" aria-expanded="false" aria-controls="player-panel" aria-label="{{ __('site.player.open') }}">
      <span class="player-text"><span class="player-state" id="player-state">{{ __('site.player.paused') }}</span><span class="player-name" id="player-name"></span></span>
      <svg class="player-chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 15 6-6 6 6"/></svg>
    </button>
    <button type="button" class="player-mute" id="player-mute" aria-label="{{ __('site.player.mute') }}">
      <svg class="p-vol" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 5 6 9H3v6h3l5 4V5Z"/><path d="M15.5 8.5a5 5 0 0 1 0 7M18.5 5.5a9 9 0 0 1 0 13"/></svg>
      <svg class="p-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 5 6 9H3v6h3l5 4V5Z"/><path d="m16 9 5 6M21 9l-5 6"/></svg>
    </button>
  </div>
</div>
@endif
