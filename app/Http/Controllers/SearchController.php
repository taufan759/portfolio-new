<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Post;
use App\Models\Project;

class SearchController extends Controller
{
    /** Search index for the current locale; the browser filters it, so nothing is queried per keystroke. */
    public function index()
    {
        $items = [];

        $pages = [
            ['home', 'home'], ['about', 'about'], ['projects.index', 'projects'],
            ['blog.index', 'blog'], ['books.index', 'books'], ['news.index', 'news'],
        ];
        foreach ($pages as [$route, $key]) {
            $items[] = $this->item(__('site.nav.'.$key), __('site.search.page_desc.'.$key), route($route), 'page');
        }

        foreach (Project::where('is_published', true)->orderBy('sort')->get() as $p) {
            $items[] = $this->item($p->title, (string) $p->t('description'), route('projects.show', ['slug' => $p->slug]), 'project', implode(' ', $p->tags ?? []).' '.$p->kind);
        }

        foreach (Post::where('is_published', true)->latest('published_at')->get() as $post) {
            $items[] = $this->item((string) $post->t('title'), (string) $post->t('excerpt'), route('blog.show', ['slug' => $post->slug]), 'blog');
        }

        foreach (Book::latest('id')->get() as $b) {
            $items[] = $this->item($b->title, (string) $b->author, route('books.index'), 'book');
        }

        foreach (__('site.about.faq_items') as [$q, $a]) {
            $items[] = $this->item($q, $a, route('about').'#faq', 'faq');
        }

        return response()->json($items)->header('Cache-Control', 'public, max-age=300');
    }

    private function item(string $title, string $desc, string $url, string $type, string $extra = ''): array
    {
        return ['t' => $title, 'd' => mb_strimwidth(strip_tags($desc), 0, 140, '…'), 'u' => $url, 'k' => $type, 'x' => $extra];
    }
}
