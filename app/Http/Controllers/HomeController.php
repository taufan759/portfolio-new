<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\NewsItem;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Project;
use App\Support\NewsFetcher;

class HomeController extends Controller
{
    private const FEATURED = 4;

    public function index()
    {
        // Keep the tech news fresh without needing cron; runs after the response is sent.
        app()->terminating(fn () => app(NewsFetcher::class)->refreshIfStale());

        // Home only previews each section; the full lists live on their own pages.
        $featured = Project::listed()->where('is_featured', true)->limit(self::FEATURED)->get();

        if ($featured->count() < self::FEATURED) {
            $filler = Project::listed()->whereNotIn('id', $featured->pluck('id'))->limit(self::FEATURED - $featured->count())->get();
            $featured = $featured->concat($filler);
        }

        $posts = Post::where('is_published', true);

        return view('home', [
            'partners' => Partner::listed()->get(),
            'projectCount' => Project::where('is_published', true)->count(),
            'projects' => $featured,
            'postCount' => (clone $posts)->count(),
            'posts' => $posts->latest('published_at')->limit(4)->get(),
            'books' => Book::where('status', 'reading')->latest('id')->limit(2)->get(),
            'news' => NewsItem::latest('published_at')->limit(4)->get(),
        ]);
    }
}
