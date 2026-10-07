<?php

namespace App\Support;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * Public GitHub activity for the About page. Read from the cache on page views; refreshed after the response
 * is sent (or by `php artisan github:sync`), so a slow or unavailable GitHub API never delays a page.
 */
class GitHub
{
    private const KEY = 'github.summary';

    public static function user(): string
    {
        return config('site.github');
    }

    /** @return array{repos:int,since:string,last:string,items:array<int,array>}|null */
    public static function cached(): ?array
    {
        $data = Cache::get(self::KEY);

        return is_array($data) && $data !== [] ? $data : null;
    }

    public static function refreshIfStale(): void
    {
        if (! Cache::has(self::KEY)) {
            self::refresh();
        }
    }

    public static function refresh(): bool
    {
        $user = self::user();

        try {
            $http = Http::timeout(8)->acceptJson()->withUserAgent('TaufanPortfolio/1.0 (+https://github.com/'.$user.')');
            $profile = $http->get("https://api.github.com/users/{$user}");
            $repos = $http->get("https://api.github.com/users/{$user}/repos", ['sort' => 'pushed', 'per_page' => 50]);

            if (! $profile->successful() || ! $repos->successful()) {
                throw new \RuntimeException('GitHub API unavailable');
            }
        } catch (\Throwable) {
            // Try again in a quarter of an hour instead of on every request.
            Cache::put(self::KEY, [], 900);

            return false;
        }

        $own = collect($repos->json())
            ->reject(fn ($r) => $r['fork'] || strcasecmp($r['name'], $user) === 0 || preg_match('/^submission/i', $r['name']))
            ->values();

        $items = $own->take(6)->map(fn ($r) => [
            'name' => $r['name'],
            'description' => $r['description'] ?? '',
            'language' => $r['language'],
            'url' => $r['html_url'],
            'pushed_at' => $r['pushed_at'],
            'stars' => $r['stargazers_count'],
        ])->all();

        $latest = collect($repos->json())->pluck('pushed_at')->filter()->max();

        Cache::put(self::KEY, [
            'repos' => (int) $profile->json('public_repos'),
            'since' => Carbon::parse($profile->json('created_at'))->format('Y'),
            'last' => $latest ? Carbon::parse($latest)->toDateString() : '',
            'items' => $items,
        ], 21600);

        return true;
    }
}
