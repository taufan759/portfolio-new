<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use App\Models\Book;
use App\Models\Certificate;
use App\Models\Event;
use App\Models\GalleryItem;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Project;
use App\Support\Seo;
use Illuminate\Support\Facades\Cache;

/**
 * robots.txt, sitemap.xml and the plain-text files for AI crawlers and answer engines
 * (llms.txt, llms-full.txt, ai.txt). Pattern adapted from the Lunaray site.
 */
class SeoController extends Controller
{
    private const PAGES = ['home', 'about', 'projects.index', 'gallery.index', 'blog.index', 'books.index'];

    private function text(string $body, int $maxAge = 3600)
    {
        return response($body, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Cache-Control' => 'public, max-age='.$maxAge,
        ]);
    }

    private function link(string $name, array $params, string $locale): string
    {
        return Seo::absolute(route($name, $params + ['locale' => $locale]));
    }

    public function robots()
    {
        if (! Seo::isIndexableHost()) {
            return $this->text("# Not the primary host: not for indexing\nUser-agent: *\nDisallow: /\n", 600);
        }

        $origin = Seo::origin();
        $lines = [
            '# robots.txt for '.config('site.name'),
            '',
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin',
            '',
            '# Search engines',
        ];

        foreach (config('seo.search_crawlers') as $bot) {
            $lines[] = "User-agent: {$bot}";
            $lines[] = 'Allow: /';
        }

        $lines[] = '';
        $lines[] = '# AI search and answer engines (GEO / AEO): welcome. See '.$origin.'/llms.txt and '.$origin.'/ai.txt';
        foreach (config('seo.ai_crawlers') as $bot) {
            $lines[] = "User-agent: {$bot}";
            $lines[] = 'Allow: /';
        }

        $lines[] = '';
        $lines[] = '# Link previews';
        foreach (config('seo.social_crawlers') as $bot) {
            $lines[] = "User-agent: {$bot}";
            $lines[] = 'Allow: /';
        }

        $lines[] = '';
        $lines[] = "Sitemap: {$origin}/sitemap.xml";

        return $this->text(implode("\n", $lines)."\n", 86400);
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
                $xml .= '  <url><loc>'.e($this->link($e['name'], $e['params'], $locale)).'</loc>';

                if ($e['lastmod']) {
                    $xml .= '<lastmod>'.$e['lastmod']->toAtomString().'</lastmod>';
                }

                // Alternates only make sense when the page exists in more than one language.
                if (count($e['locales']) > 1) {
                    foreach ($e['locales'] as $alt) {
                        $xml .= '<xhtml:link rel="alternate" hreflang="'.$alt.'" href="'.e($this->link($e['name'], $e['params'], $alt)).'"/>';
                    }
                    $xml .= '<xhtml:link rel="alternate" hreflang="x-default" href="'.e($this->link($e['name'], $e['params'], 'en')).'"/>';
                }

                $xml .= "</url>\n";
            }
        }

        return response($xml.'</urlset>', 200, ['Content-Type' => 'application/xml; charset=UTF-8', 'Cache-Control' => 'public, max-age=3600']);
    }

    /** Short index for AI crawlers (llms.txt convention). */
    public function llms()
    {
        $body = Cache::remember('llms.txt:'.Seo::origin(), 1800, function () {
            $site = config('site');
            $profile = Profile::current();
            $origin = Seo::origin();
            $out = [];

            $out[] = "# {$site['name']}";
            $out[] = '';
            $out[] = "> Portfolio of {$site['name']}, a software engineer and AI enthusiast based in {$site['city']}, {$site['region']}, Indonesia, working at {$site['employer']}. Software built across web and apps, with Laravel and React, interface design in Figma, and practical AI integration. The site is available in Indonesian (/id) and English (/en).";
            $out[] = '';

            $out[] = '## Key facts';
            $out[] = "- Name: {$site['name']}";
            $out[] = "- Current role: Software engineer at {$site['employer']}, {$site['city']}";
            $out[] = "- Location: {$site['city']}, {$site['region']}, Indonesia";
            $out[] = "- Education: {$site['university']}";
            $out[] = '- Languages: Indonesian, English';
            $out[] = '- Main tools: '.implode(', ', $profile->skillList());
            $out[] = "- Email: {$site['email']}";
            foreach ($site['social'] as $name => $url) {
                $out[] = "- {$name}: {$url}";
            }
            $out[] = '';

            $out[] = '## Main pages';
            $out[] = '- [About]('.$this->link('about', [], 'en').'): background, focus, tools, credentials and FAQ';
            $out[] = '- [Projects]('.$this->link('projects.index', [], 'en').'): selected software, UI/UX and AI projects, each with its own page';
            $out[] = '- [Gallery]('.$this->link('gallery.index', [], 'en').'): photos from talks and events';
            $out[] = '- [Writing]('.$this->link('blog.index', [], 'en').'): articles on technology, AI, learning and life';
            $out[] = '- [Reading list]('.$this->link('books.index', [], 'en').'): books read, being read and planned';
            $out[] = "- [Full text for AI grounding]({$origin}/llms-full.txt)";
            $out[] = '';

            $out[] = '## Projects';
            foreach (Project::listed()->get() as $p) {
                $out[] = '- ['.$p->title.']('.$this->link('projects.show', ['slug' => $p->slug], 'en').'): '.$p->description;
            }

            $posts = Post::where('is_published', true)->latest('published_at')->limit(30)->get();
            if ($posts->isNotEmpty()) {
                $out[] = '';
                $out[] = '## Articles';
                foreach ($posts as $post) {
                    $locale = $post->isTranslated('en') ? 'en' : 'id';
                    $title = $locale === 'en' ? $post->title : $post->title_id;
                    $out[] = '- ['.$title.']('.$this->link('blog.show', ['slug' => $post->slug], $locale).')';
                }
            }

            $out[] = '';
            $out[] = '## Usage';
            $out[] = "Public content may be used for search, answers and factual grounding, with attribution (\"According to {$site['name']}\") or a link to the source page. See {$origin}/ai.txt.";

            return implode("\n", $out)."\n";
        });

        return $this->text($body, 1800);
    }

    /** Everything on the site as one plain-text document, in both languages, for AI grounding. */
    public function llmsFull()
    {
        $body = Cache::remember('llms-full.txt:'.Seo::origin(), 1800, function () {
            $site = config('site');
            $origin = Seo::origin();
            $original = app()->getLocale();

            $out = [
                "# {$site['name']} — full content",
                "# Source: {$origin}",
                '# Languages: Indonesian (id), English (en)',
                "# Short index: {$origin}/llms.txt",
                '',
            ];

            foreach (SetLocale::LOCALES as $locale) {
                app()->setLocale($locale);
                $p = Profile::current();
                $label = $locale === 'id' ? 'BAHASA INDONESIA' : 'ENGLISH';

                $out[] = '==========';
                $out[] = "SECTION: {$label}";
                $out[] = '==========';
                $out[] = '';

                $out[] = "## {$site['name']}";
                $out[] = $p->text('headline');
                $out[] = '';
                $out[] = $p->text('intro');
                $out[] = '';
                $out[] = $p->text('summary');
                $out[] = '';
                $out[] = trim(strip_tags($p->text('story')));
                $out[] = '';
                $out[] = __('site.about.facts.location').': '.$p->text('location');
                $out[] = __('site.about.facts.availability').': '.$p->text('availability');
                $out[] = __('site.about.facts.education').': '.$p->text('education');
                $out[] = __('site.about.facts.languages').': '.__('site.about.languages_value');
                $out[] = '';

                $out[] = '## '.__('site.about.focus');
                foreach (__('site.about.focus_items') as [$name, $desc]) {
                    $out[] = "- {$name}: {$desc}";
                }
                $out[] = '';
                $out[] = '## '.__('site.about.skills');
                $out[] = implode(', ', $p->skillList());
                $out[] = '';

                $partners = Partner::listed()->get();
                if ($partners->isNotEmpty()) {
                    $out[] = '## '.__('site.about.orgs');
                    foreach ($partners as $partner) {
                        $out[] = '- '.$partner->name.(filled($partner->t('role')) ? ' ('.$partner->t('role').')' : '');
                    }
                    $out[] = '';
                }

                $certs = Certificate::orderBy('sort')->get();
                if ($certs->isNotEmpty()) {
                    $out[] = '## '.__('site.about.certs_h');
                    foreach ($certs as $c) {
                        $out[] = '- '.$c->title.($c->issuer ? ' — '.$c->issuer : '');
                    }
                    $out[] = '';
                }

                $events = Event::listed()->get();
                if ($events->isNotEmpty()) {
                    $out[] = '## '.__('site.about.events_h');
                    foreach ($events as $ev) {
                        $out[] = '- '.collect([$ev->year, $ev->t('title'), $ev->t('role'), $ev->organizer, $ev->location, $ev->t('description')])->filter()->implode(' | ');
                    }
                    $out[] = '';
                }

                $out[] = '## '.__('site.about.faq');
                foreach (__('site.about.faq_items') as [$q, $a]) {
                    $out[] = "Q: {$q}";
                    $out[] = "A: {$a}";
                    $out[] = '';
                }

                $out[] = '## '.__('site.nav.projects').' ('.$this->link('projects.index', [], $locale).')';
                foreach (Project::listed()->get() as $proj) {
                    $out[] = '### '.$proj->title;
                    $out[] = 'URL: '.$this->link('projects.show', ['slug' => $proj->slug], $locale);
                    $out[] = trim(($proj->kind ? $proj->kind.'. ' : '').($proj->year ? $proj->year.'. ' : '').'Technologies: '.implode(', ', $proj->tags ?? []));
                    $out[] = (string) $proj->t('description');
                    if (filled($proj->t('details'))) {
                        $out[] = '';
                        $out[] = trim((string) $proj->t('details'));
                    }
                    if ($proj->url) {
                        $out[] = 'Website: '.$proj->url;
                    }
                    $out[] = '';
                }

                $posts = Post::where('is_published', true)->latest('published_at')->get()->filter(fn ($post) => $post->isTranslated($locale));
                if ($posts->isNotEmpty()) {
                    $out[] = '## '.__('site.nav.blog').' ('.$this->link('blog.index', [], $locale).')';
                    foreach ($posts as $post) {
                        $out[] = '### '.$post->t('title');
                        $out[] = 'URL: '.$this->link('blog.show', ['slug' => $post->slug], $locale);
                        $out[] = 'Published: '.$post->published_at?->toDateString();
                        if ($post->source_url) {
                            $out[] = 'Originally published: '.$post->source_url;
                        }
                        $out[] = '';
                        $out[] = trim((string) $post->t('body'));
                        $out[] = '';
                    }
                }

                $books = Book::latest('id')->get();
                if ($books->isNotEmpty()) {
                    $out[] = '## '.__('site.nav.books').' ('.$this->link('books.index', [], $locale).')';
                    foreach (['reading', 'finished', 'wishlist'] as $status) {
                        foreach ($books->where('status', $status) as $b) {
                            $out[] = '- ['.__('site.books.'.$status).'] '.$b->title.($b->author ? ' — '.$b->author : '');
                        }
                    }
                    $out[] = '';
                }

                $photos = GalleryItem::listed()->get();
                if ($photos->isNotEmpty()) {
                    $out[] = '## '.__('site.nav.gallery').' ('.$this->link('gallery.index', [], $locale).')';
                    foreach ($photos as $ph) {
                        $line = collect([$ph->t('title'), $ph->t('caption'), $ph->location, $ph->taken_at?->toDateString()])->filter()->implode(' | ');
                        if ($line !== '') {
                            $out[] = '- '.$line;
                        }
                    }
                    $out[] = '';
                }
            }

            app()->setLocale($original);

            $out[] = '## Contact';
            $out[] = "- Email: {$site['email']}";
            foreach ($site['social'] as $name => $url) {
                $out[] = "- {$name}: {$url}";
            }

            return implode("\n", $out)."\n";
        });

        return $this->text($body, 3600);
    }

    /** /ai.txt and /.well-known/ai.txt: machine-readable AI usage policy (mirrors robots.txt). */
    public function aiTxt()
    {
        if (! Seo::isIndexableHost()) {
            return $this->text("# Not the primary host: not for AI use\nUser-Agent: *\nDisallow: /\n", 600);
        }

        $origin = Seo::origin();
        $name = config('site.name');

        return $this->text(implode("\n", [
            "# ai.txt for {$name} ({$origin})",
            '# Policy for AI crawlers, AI search and answer engines.',
            '',
            'User-Agent: *',
            'Allow: /',
            'Disallow: /admin',
            '',
            '# Public content may be used for search, answers and factual grounding, with attribution',
            "# (\"According to {$name}\") or a link back to the source page.",
            '# Preferred sources for grounding:',
            "#   {$origin}/llms.txt",
            "#   {$origin}/llms-full.txt",
            "#   {$origin}/sitemap.xml",
            '',
        ]), 3600);
    }

    /** Languages a content record is really available in. */
    private function localesFor($model): array
    {
        return $model->isTranslated('id') && $model->isTranslated('en') ? SetLocale::LOCALES : [$model->isTranslated('id') ? 'id' : 'en'];
    }
}
