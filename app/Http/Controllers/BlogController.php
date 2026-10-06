<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        return view('blog.index', [
            'posts' => Post::where('is_published', true)->latest('published_at')->paginate(9),
        ]);
    }

    public function show(string $slug)
    {
        $post = Post::where('is_published', true)->where('slug', $slug)->firstOrFail();

        return view('blog.show', ['post' => $post]);
    }
}
