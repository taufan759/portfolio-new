<?php

namespace App\Console\Commands;

use App\Support\GitHub;
use Illuminate\Console\Command;

class SyncGitHub extends Command
{
    protected $signature = 'github:sync';

    protected $description = 'Refresh the public GitHub activity shown on the About page';

    public function handle(): int
    {
        if (! GitHub::refresh()) {
            $this->warn('GitHub API is unavailable right now; will retry later.');

            return self::FAILURE;
        }

        $data = GitHub::cached();
        $this->info("Synced: {$data['repos']} public repositories, last activity {$data['last']}.");

        return self::SUCCESS;
    }
}
