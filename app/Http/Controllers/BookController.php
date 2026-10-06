<?php

namespace App\Http\Controllers;

use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::latest('finished_at')->latest('id')->get()->groupBy('status');

        return view('books.index', ['books' => $books]);
    }
}
