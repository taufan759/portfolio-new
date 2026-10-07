<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Partner;

class AboutController extends Controller
{
    public function index()
    {
        return view('about', [
            'certificates' => Certificate::orderBy('sort')->get(),
            'partners' => Partner::listed()->get(),
        ]);
    }
}
