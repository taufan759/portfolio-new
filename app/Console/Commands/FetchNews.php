<?php

namespace App\Console\Commands;

use App\Support\NewsFetcher;
use Illuminate\Console\Command;

class FetchNews extends Command
{
    protected $signature = 'news:fetch {--source= : Only fetch one configured source by name}';

    protected $description = 'Fetch the latest Indonesian tech headlines relevant to web/AI/UI-UX work from public RSS feeds';

    public function handle(NewsFetcher $fetcher): int
    {
        foreach ($fetcher->run($this->option('source')) as $name => $status) {
            $this->line("{$name}: {$status}");
        }

        return self::SUCCESS;
    }
}
