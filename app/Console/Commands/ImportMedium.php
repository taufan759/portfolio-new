<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Support\HtmlToMarkdown;
use App\Support\Images;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ImportMedium extends Command
{
    protected $signature = 'medium:import
        {handle=@taufan759 : Medium profile handle, e.g. @taufan759}
        {--lang=id : Language the articles are written in (id or en)}
        {--dry-run : Show what would be imported without saving}';

    protected $description = 'Import articles from a Medium profile feed into the blog (skips articles already imported)';

    public function handle(): int
    {
        $handle = '@'.ltrim($this->argument('handle'), '@');
        $lang = $this->option('lang') === 'en' ? 'en' : 'id';
        $suffix = $lang === 'id' ? '_id' : '';

        $response = Http::timeout(30)
            ->withUserAgent('TaufanPortfolioImport/1.0 (+https://github.com/taufan759/portfolio-new)')
            ->get("https://medium.com/feed/{$handle}");

        if (! $response->successful()) {
            $this->error("Could not read the feed (HTTP {$response->status()}).");

            return self::FAILURE;
        }

        $xml = @simplexml_load_string($response->body(), \SimpleXMLElement::class, LIBXML_NOCDATA);
        if (! $xml || ! isset($xml->channel->item)) {
            $this->error('The feed has no articles or could not be parsed.');

            return self::FAILURE;
        }

        $imported = 0;

        foreach ($xml->channel->item as $item) {
            $title = trim((string) $item->title);
            $url = strtok(trim((string) $item->link), '?');

            if (Post::where('source_url', $url)->exists()) {
                $this->line("skip   {$title} (already imported)");

                continue;
            }

            $html = (string) $item->children('content', true)->encoded;
            $date = Carbon::parse((string) $item->pubDate);

            if ($this->option('dry-run')) {
                $this->info("would import  {$title}  [{$date->toDateString()}]");

                continue;
            }

            $cover = null;
            $converter = new HtmlToMarkdown(function (string $src) use (&$cover) {
                $stored = $this->downloadImage($src);
                if ($stored === null) {
                    return null;
                }
                $cover ??= $stored; // the first image is the article cover

                return '/'.$stored;
            });

            $markdown = $converter->convert($html);

            // The cover is shown separately, so drop it from the top of the body.
            if ($cover) {
                $markdown = preg_replace('/^!\['.'[^\]]*'.'\]\('.preg_quote('/'.$cover, '/').'\)\s*(\*[^\n]*\*)?\s*/', '', $markdown, 1);
            }

            $post = new Post;
            $post->fill([
                'slug' => $this->uniqueSlug($title),
                'title'.$suffix => $title,
                'excerpt'.$suffix => $this->excerpt($markdown),
                'body'.$suffix => trim($markdown),
                'cover' => $cover,
                'source_url' => $url,
                'published_at' => $date,
                'is_published' => true,
            ])->save();

            $imported++;
            $this->info("import {$title}");
        }

        $this->info($this->option('dry-run') ? 'Dry run finished.' : "Done. {$imported} imported.");

        return self::SUCCESS;
    }

    private function downloadImage(string $src): ?string
    {
        try {
            $res = Http::timeout(30)->withUserAgent('TaufanPortfolioImport/1.0')->get($src);
        } catch (\Throwable) {
            return null;
        }

        return $res->successful() ? Images::storeWebpFromString($res->body()) : null;
    }

    private function excerpt(string $markdown): string
    {
        foreach (preg_split("/\n{2,}/", $markdown) as $block) {
            $text = trim(preg_replace('/[*_>#`\[\]]|\(https?:[^)]*\)|!\([^)]*\)/', '', $block));
            if (mb_strlen($text) > 40 && ! str_starts_with(trim($block), '![')) {
                return Str::limit($text, 220);
            }
        }

        return '';
    }

    private function uniqueSlug(string $title): string
    {
        $slug = Str::limit(Str::slug($title), 90, '') ?: 'post';
        $candidate = $slug;
        $i = 2;

        while (Post::where('slug', $candidate)->exists()) {
            $candidate = $slug.'-'.$i++;
        }

        return $candidate;
    }
}
