<?php

namespace App\Http\Controllers;

use App\Models\Certificate;

class AboutController extends Controller
{
    public function index()
    {
        return view('about', ['certificates' => Certificate::orderBy('sort')->get()]);
    }
}
