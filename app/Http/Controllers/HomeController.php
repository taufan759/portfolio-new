<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\NewsItem;
use App\Models\Post;
use App\Models\Project;
use App\Support\NewsFetcher;

class HomeController extends Controller
{
    public function index()
    {
        // Keep the tech news fresh without needing cron; runs after the response is sent.
        app()->terminating(fn () => app(NewsFetcher::class)->refreshIfStale());

        // Only a few items per section; each has an "All" link to its own page.
        $projects = Project::where('is_published', true);
        $posts = Post::where('is_published', true);

        return view('home', [
            'projectCount' => (clone $projects)->count(),
            'projects' => $projects->orderBy('sort')->limit(4)->get(),
            'postCount' => (clone $posts)->count(),
            'posts' => $posts->latest('published_at')->limit(4)->get(),
            'books' => Book::where('status', 'reading')->latest('id')->limit(2)->get(),
            'news' => NewsItem::latest('published_at')->limit(4)->get(),
        ]);
    }
}
