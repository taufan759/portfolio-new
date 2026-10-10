<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;
use App\Support\NewsFetcher;

class NewsController extends Controller
{
    public function index()
    {
        app()->terminating(fn () => app(NewsFetcher::class)->refreshIfStale());

        return view('news.index', [
            'news' => NewsItem::forLocale()->latest('published_at')->paginate(20),
        ]);
    }
}
