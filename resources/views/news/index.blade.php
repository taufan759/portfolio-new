@extends('layouts.site')
@section('title', 'Tech news — Muhammad Taufan Akbar')
@section('content')
<section class="page-main">
  <div class="shell page-inner">
    <div class="eyebrow">Tech news</div>
    <h1 class="page-h1">Berita teknologi pilihan</h1>
    <p class="page-lead">Dikumpulkan otomatis dari media teknologi Indonesia dan disaring sesuai bidang saya: web development, AI, dan UI/UX. Setiap tautan menuju sumber aslinya.</p>
    <div class="book-list">
      @forelse ($news as $item)
        <a href="{{ $item->url }}" target="_blank" rel="noopener nofollow" class="book-row">
          <div><strong>{{ $item->title }}</strong><small>{{ $item->source }}</small></div>
          <span class="journal-meta">{{ $item->published_at?->diffForHumans() }}</span>
        </a>
      @empty
        <p class="journal-empty">Belum ada berita. Daftar ini diperbarui otomatis.</p>
      @endforelse
    </div>
    <div class="pager">{{ $news->links('pagination::simple-default') }}</div>
  </div>
</section>
@endsection
