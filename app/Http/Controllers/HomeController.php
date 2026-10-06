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

        // The home page only teases each menu section; the full lists live on their own pages.
        return view('home', [
            'projectCount' => Project::where('is_published', true)->count(),
            'post' => Post::where('is_published', true)->latest('published_at')->first(),
            'book' => Book::where('status', 'reading')->latest('id')->first(),
            'news' => NewsItem::latest('published_at')->first(),
        ]);
    }
}
