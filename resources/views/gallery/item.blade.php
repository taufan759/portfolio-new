@php
  $label = collect([$item->t('title'), $item->t('caption')])->filter()->implode(' — ');
  [$tw, $th] = $item->thumbSize();
  $meta = collect([$item->location, $item->taken_at?->translatedFormat('d M Y')])->filter()->implode(' · ');
@endphp
<a href="{{ asset($item->image) }}" class="gal-item" data-lightbox data-alt="{{ $item->t('title') ?: config('site.name') }}" data-caption="{{ trim($label.($meta ? ' ('.$meta.')' : '')) }}">
  <img src="{{ asset($item->thumb()) }}" alt="{{ $item->t('title') ?: __('site.gallery.eyebrow') }}" loading="lazy" decoding="async" width="{{ $tw }}" height="{{ $th }}">
  @if (filled($item->t('title')))<span class="gal-cap">{{ $item->t('title') }}</span>@endif
</a>
