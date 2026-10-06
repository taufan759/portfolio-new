<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Certificate;
use App\Models\NewsItem;
use App\Models\Post;
use App\Models\Project;
use App\Support\NewsFetcher;

class HomeController extends Controller
{
    public function index()
    {
        app()->terminating(fn () => app(NewsFetcher::class)->refreshIfStale());

        return view('home', [
            'projects' => Project::where('is_published', true)->orderBy('sort')->get(),
            'certificates' => Certificate::orderBy('sort')->get(),
            'posts' => Post::where('is_published', true)->latest('published_at')->limit(3)->get(),
            'books' => Book::orderByRaw("case status when 'reading' then 0 when 'finished' then 1 else 2 end")->latest('finished_at')->limit(4)->get(),
            'news' => NewsItem::latest('published_at')->limit(5)->get(),
            'counts' => ['projects' => Project::count(), 'certificates' => Certificate::count()],
        ]);
    }
}
