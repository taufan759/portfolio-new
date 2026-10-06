<?php

namespace App\Support;

use App\Models\NewsItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class NewsFetcher
{
    /**
     * Fetch all (or one) configured sources.
     *
     * @return array<string, string> source => status message
     */
    public function run(?string $only = null): array
    {
        $sources = config('news.sources');

        if ($only) {
            $sources = array_intersect_key($sources, [$only => true]);
        }

        $report = [];

        foreach ($sources as $name => $source) {
            try {
                $response = Http::timeout(config('news.timeout'))
                    ->withUserAgent('TaufanPortfolioBot/1.0 (+https://github.com/taufan759/portfolio-new)')
                    ->get($source['url']);

                if (! $response->successful()) {
                    $report[$name] = "HTTP {$response->status()}";
                    continue;
                }

                $report[$name] = $this->store($name, $response->body(), $source['filter'] ?? true).' new';
            } catch (\Throwable $e) {
                $report[$name] = $e->getMessage();
            }
        }

        NewsItem::where('created_at', '<', now()->subDays(config('news.keep_days')))->delete();
        // Drop items from sources that are no longer configured.
        NewsItem::whereNotIn('source', array_keys(config('news.sources')))->delete();

        Cache::put('news.last_fetch', now()->timestamp);

        return $report;
    }

    /** Fetch if the data is stale. Safe to call on every request; a lock prevents parallel runs. */
    public function refreshIfStale(): void
    {
        $last = Cache::get('news.last_fetch');

        if ($last && now()->timestamp - $last < config('news.refresh_minutes') * 60) {
            return;
        }

        $lock = Cache::lock('news.fetching', 120);

        if ($lock->get()) {
            try {
                $this->run();
            } finally {
                $lock->release();
            }
        }
    }

    private function isRelevant(string $text): bool
    {
        $words = array_map(fn ($w) => preg_quote($w, '/'), config('news.keywords'));

        return (bool) preg_match('/\b('.implode('|', $words).')\b/iu', $text);
    }

    private function store(string $source, string $xmlBody, bool $filter): int
    {
        $previous = libxml_use_internal_errors(true);
        $xml = simplexml_load_string($xmlBody, \SimpleXMLElement::class, LIBXML_NONET | LIBXML_NOCDATA);
        libxml_use_internal_errors($previous);

        if (! $xml) {
            return 0;
        }

        // RSS 2.0 uses channel/item, Atom uses entry.
        $items = isset($xml->channel->item) ? $xml->channel->item : ($xml->entry ?? []);
        $new = 0;
        $seen = 0;

        foreach ($items as $item) {
            if ($seen++ >= config('news.per_source')) {
                break;
            }

            $title = trim((string) $item->title);
            $link = trim((string) ($item->link['href'] ?? $item->link));

            if ($title === '' || ! Str::startsWith($link, ['http://', 'https://'])) {
                continue;
            }

            $summary = (string) ($item->description ?? $item->summary ?? $item->content ?? '');
            $summary = Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags(html_entity_decode($summary)))), 280);

            if ($filter && ! $this->isRelevant($title.' '.$summary)) {
                continue;
            }

            $date = (string) ($item->pubDate ?? $item->published ?? $item->updated ?? '');

            try {
                // Dates without a timezone are Indonesian local time; never store a date in the future.
                $publishedAt = $date !== '' ? Carbon::parse($date, 'Asia/Jakarta')->utc() : now();
                $publishedAt = $publishedAt->isFuture() ? now() : $publishedAt;
            } catch (\Throwable) {
                $publishedAt = now();
            }

            $record = NewsItem::firstOrCreate(
                ['url' => $link],
                ['title' => Str::limit($title, 250, ''), 'source' => $source, 'summary' => $summary ?: null, 'published_at' => $publishedAt]
            );

            if ($record->wasRecentlyCreated) {
                $new++;
            }
        }

        return $new;
    }
}
