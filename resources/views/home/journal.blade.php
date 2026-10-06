  <!-- ================= JOURNAL ================= -->
  <section id="journal">
    <div class="shell journal-inner">
      <div class="eyebrow reveal">Journal</div>
      <h2 class="journal-h2 reveal" data-delay="120">
        <span class="line-clip"><span class="line-inner">Writing, reading &amp; news</span></span>
      </h2>

      <div class="journal-grid">
        <div class="journal-col reveal" style="--dy:24px" data-delay="0">
          <div class="journal-col-head"><h3>Blog</h3><a href="{{ route('blog.index') }}" class="journal-more">All posts →</a></div>
          @forelse ($posts as $post)
            <a href="{{ route('blog.show', $post->slug) }}" class="journal-row">
              <span class="journal-title">{{ $post->title }}</span>
              <span class="journal-meta">{{ $post->published_at?->format('d M Y') }}</span>
            </a>
          @empty
            <p class="journal-empty">First posts are on the way.</p>
          @endforelse
        </div>

        <div class="journal-col reveal" style="--dy:24px" data-delay="90">
          <div class="journal-col-head"><h3>Books</h3><a href="{{ route('books.index') }}" class="journal-more">Reading list →</a></div>
          @forelse ($books as $book)
            <div class="journal-row">
              <span class="journal-title">{{ $book->title }}<small>{{ $book->author }}</small></span>
              <span class="journal-meta">{{ $book->status === 'reading' ? 'Reading' : ($book->rating ? str_repeat('★', $book->rating) : ucfirst($book->status)) }}</span>
            </div>
          @empty
            <p class="journal-empty">My reading list is coming soon.</p>
          @endforelse
        </div>

        <div class="journal-col reveal" style="--dy:24px" data-delay="180">
          <div class="journal-col-head"><h3>Tech news</h3><a href="{{ route('news.index') }}" class="journal-more">All news →</a></div>
          @forelse ($news as $item)
            <a href="{{ $item->url }}" target="_blank" rel="noopener nofollow" class="journal-row">
              <span class="journal-title">{{ $item->title }}<small>{{ $item->source }}</small></span>
              <span class="journal-meta">{{ $item->published_at?->diffForHumans(null, true, true) }}</span>
            </a>
          @empty
            <p class="journal-empty">News feed updates automatically.</p>
          @endforelse
        </div>
      </div>
    </div>
  </section>
