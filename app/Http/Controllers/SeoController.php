<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use App\Models\Post;
use App\Models\Project;
use Illuminate\Support\Facades\URL;

class SeoController extends Controller
{
    private const PAGES = ['home', 'about', 'projects.index', 'gallery.index', 'blog.index', 'books.index'];

    public function robots()
    {
        $body = "User-agent: *\nDisallow: /admin\n\nSitemap: ".url('/sitemap.xml')."\n";

        return response($body, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    public function sitemap()
    {
        $entries = [];

        foreach (self::PAGES as $name) {
            $entries[] = ['name' => $name, 'params' => [], 'locales' => SetLocale::LOCALES, 'lastmod' => null];
        }

        foreach (Project::where('is_published', true)->get() as $project) {
            $entries[] = [
                'name' => 'projects.show', 'params' => ['slug' => $project->slug],
                'locales' => $this->localesFor($project), 'lastmod' => $project->updated_at,
            ];
        }

        foreach (Post::where('is_published', true)->get() as $post) {
            $entries[] = [
                'name' => 'blog.show', 'params' => ['slug' => $post->slug],
                'locales' => $this->localesFor($post), 'lastmod' => $post->updated_at,
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n"
            .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">'."\n";

        foreach ($entries as $e) {
            foreach ($e['locales'] as $locale) {
                $xml .= '  <url><loc>'.e($this->url($e['name'], $e['params'], $locale)).'</loc>';

                if ($e['lastmod']) {
                    $xml .= '<lastmod>'.$e['lastmod']->toAtomString().'</lastmod>';
                }

                // Alternates only make sense when the page exists in more than one language.
                if (count($e['locales']) > 1) {
                    foreach ($e['locales'] as $alt) {
                        $xml .= '<xhtml:link rel="alternate" hreflang="'.$alt.'" href="'.e($this->url($e['name'], $e['params'], $alt)).'"/>';
                    }
                    $xml .= '<xhtml:link rel="alternate" hreflang="x-default" href="'.e($this->url($e['name'], $e['params'], 'en')).'"/>';
                }

                $xml .= "</url>\n";
            }
        }

        return response($xml.'</urlset>', 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    /** Plain-text summary for AI crawlers (llms.txt convention). */
    public function llms()
    {
        $site = config('site');
        $lines = [
            "# {$site['name']}",
            '',
            "> Portfolio of {$site['name']}, a full-stack developer and AI enthusiast based in {$site['city']}, {$site['region']}, Indonesia. Builds web applications with Laravel, React and Node.js, designs interfaces in Figma, and integrates AI features. The site is available in Indonesian (/id) and English (/en).",
            '',
            '## Main pages',
            '- [About]('.$this->url('about', [], 'en').'): background, services, process, certificates and FAQ',
            '- [Projects]('.$this->url('projects.index', [], 'en').'): selected web, UI/UX and AI projects, each with a case page',
            '- [Blog]('.$this->url('blog.index', [], 'en').'): notes on building software',
            '- [Books]('.$this->url('books.index', [], 'en').'): reading list',
            '',
            '## Projects',
        ];

        foreach (Project::where('is_published', true)->orderBy('sort')->get() as $p) {
            $lines[] = '- ['.$p->title.']('.$this->url('projects.show', ['slug' => $p->slug], 'en').'): '.$p->description;
        }

        $posts = Post::where('is_published', true)->latest('published_at')->limit(20)->get();
        if ($posts->isNotEmpty()) {
            $lines[] = '';
            $lines[] = '## Articles';
            foreach ($posts as $p) {
                $lines[] = '- ['.$p->title.']('.$this->url('blog.show', ['slug' => $p->slug], 'en').')';
            }
        }

        $lines[] = '';
        $lines[] = '## Contact';
        $lines[] = "- Email: {$site['email']}";
        foreach ($site['social'] as $name => $url) {
            $lines[] = "- {$name}: {$url}";
        }

        return response(implode("\n", $lines)."\n", 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    private function url(string $name, array $params, string $locale): string
    {
        return route($name, $params + ['locale' => $locale]);
    }

    /** Languages a content record is really available in. */
    private function localesFor($model): array
    {
        return $model->isTranslated('id') && $model->isTranslated('en') ? SetLocale::LOCALES : [$model->isTranslated('id') ? 'id' : 'en'];
    }
}
