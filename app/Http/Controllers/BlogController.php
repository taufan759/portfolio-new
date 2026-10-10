<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        return view('blog.index', [
            'posts' => Post::where('is_published', true)->forLocale()->latest('published_at')->paginate(9),
        ]);
    }

    public function show(string $slug)
    {
        $post = Post::where('is_published', true)->where('slug', $slug)->firstOrFail();

        // An article is shown only in the language it is written in; send the visitor to the language that has it.
        $locale = app()->getLocale();
        if (! $post->isTranslated($locale)) {
            $other = $locale === 'id' ? 'en' : 'id';
            abort_unless($post->isTranslated($other), 404);

            return redirect()->route('blog.show', ['locale' => $other, 'slug' => $slug], 301);
        }

        return view('blog.show', ['post' => $post]);
    }
}
