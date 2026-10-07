@extends('layouts.site')
@section('title', __('site.books.title'))
@section('description', __('site.books.description'))

@section('content')
<section class="page-main">
  <div class="shell page-inner">
    @include('partials.breadcrumbs', ['crumbs' => [[__('site.breadcrumb_home'), route('home')], [__('site.books.eyebrow'), route('books.index')]]])
    <h1 class="page-h1">{{ __('site.books.h1') }}</h1>
    @foreach (['reading', 'finished', 'wishlist'] as $status)
      @if (!empty($books[$status]) && $books[$status]->count())
        <h2 class="page-h2">{{ __('site.books.'.$status) }}</h2>
        <div class="book-list">
          @foreach ($books[$status] as $book)
            <div class="book-row has-cover">
              @if ($book->cover)<img class="book-cover" src="{{ asset($book->cover) }}" alt="{{ $book->title }}" width="56" height="84" loading="lazy" decoding="async">@endif
              <div class="book-info">
                <strong>{{ $book->title }}</strong>
                <small>{{ $book->author }}</small>
                @if (filled($book->t('notes')))<p>{{ $book->t('notes') }}</p>@endif
              </div>
              <span class="journal-meta">@if ($book->rating){{ str_repeat('★', $book->rating) }}@endif {{ $book->finished_at?->translatedFormat('M Y') }}</span>
            </div>
          @endforeach
        </div>
      @endif
    @endforeach
    @if ($books->isEmpty())<p class="journal-empty">{{ __('site.books.empty') }}</p>@endif
  </div>
</section>
@endsection
