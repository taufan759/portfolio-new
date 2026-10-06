<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Post;
use App\Models\Project;
use App\Support\NewsFetcher;

class HomeController extends Controller
{
    public function index()
    {
        // Keep the tech news fresh without needing cron; runs after the response is sent.
        app()->terminating(fn () => app(NewsFetcher::class)->refreshIfStale());

        return view('home', [
            'projects' => Project::where('is_published', true)->orderBy('sort')->limit(3)->get(),
            'posts' => Post::where('is_published', true)->latest('published_at')->limit(3)->get(),
            'books' => Book::where('status', 'reading')->latest('id')->limit(3)->get(),
        ]);
    }
}
