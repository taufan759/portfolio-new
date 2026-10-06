<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;

class NewsController extends Controller
{
    public function index()
    {
        return view('news.index', [
            'news' => NewsItem::latest('published_at')->paginate(20),
        ]);
    }
}
