@extends('layouts.site')
@section('title', 'Reading list — Muhammad Taufan Akbar')
@section('content')
<section class="page-main">
  <div class="shell page-inner">
    <div class="eyebrow">Books</div>
    <h1 class="page-h1">What I am reading</h1>
    @foreach (['reading' => 'Currently reading', 'finished' => 'Finished', 'wishlist' => 'Wishlist'] as $status => $label)
      @if (!empty($books[$status]) && $books[$status]->count())
        <h2 class="page-h2">{{ $label }}</h2>
        <div class="book-list">
          @foreach ($books[$status] as $book)
            <div class="book-row">
              <div>
                <strong>{{ $book->title }}</strong>
                <small>{{ $book->author }}</small>
                @if ($book->notes)<p>{{ $book->notes }}</p>@endif
              </div>
              <span class="journal-meta">@if ($book->rating){{ str_repeat('★', $book->rating) }}@endif {{ $book->finished_at?->format('M Y') }}</span>
            </div>
          @endforeach
        </div>
      @endif
    @endforeach
    @if ($books->isEmpty())<p class="journal-empty">My reading list is coming soon.</p>@endif
  </div>
</section>
@endsection
