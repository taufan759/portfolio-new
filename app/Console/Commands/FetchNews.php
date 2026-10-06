<?php

namespace App\Console\Commands;

use App\Models\NewsItem;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FetchNews extends Command
{
    protected $signature = 'news:fetch {--source= : Only fetch one configured source by name}';

    protected $description = 'Fetch the latest tech headlines from public RSS/Atom feeds';

    public function handle(): int
    {
        $sources = config('news.sources');

        if ($only = $this->option('source')) {
            $sources = array_intersect_key($sources, [$only => true]);
        }

        $added = 0;

        foreach ($sources as $name => $feedUrl) {
            try {
                $response = Http::timeout(config('news.timeout'))
                    ->withUserAgent('TaufanPortfolioBot/1.0 (+https://github.com/taufan759/portfolio-new)')
                    ->get($feedUrl);

                if (! $response->successful()) {
                    $this->warn("{$name}: HTTP {$response->status()}");
                    continue;
                }

                $count = $this->store($name, $response->body());
                $added += $count;
                $this->info("{$name}: {$count} new");
            } catch (\Throwable $e) {
                $this->warn("{$name}: {$e->getMessage()}");
            }
        }

        NewsItem::where('created_at', '<', now()->subDays(config('news.keep_days')))->delete();

        $this->info("Done. {$added} new headlines.");

        return self::SUCCESS;
    }

    private function store(string $source, string $xmlBody): int
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
            $link = (string) ($item->link['href'] ?? $item->link);
            $link = trim($link);

            if ($title === '' || ! Str::startsWith($link, ['http://', 'https://'])) {
                continue;
            }

            $summary = (string) ($item->description ?? $item->summary ?? $item->content ?? '');
            $summary = Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags(html_entity_decode($summary)))), 280);

            $date = (string) ($item->pubDate ?? $item->published ?? $item->updated ?? '');

            try {
                $publishedAt = $date !== '' ? Carbon::parse($date) : now();
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
