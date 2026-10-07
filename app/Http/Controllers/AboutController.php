<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Event;
use App\Models\Partner;
use App\Support\GitHub;

class AboutController extends Controller
{
    public function index()
    {
        // Refresh the GitHub activity after the response is sent, so a slow API never delays the page.
        app()->terminating(fn () => GitHub::refreshIfStale());

        return view('about', [
            'certificates' => Certificate::orderBy('sort')->get(),
            'partners' => Partner::listed()->get(),
            'events' => Event::listed()->get(),
            'github' => GitHub::cached(),
        ]);
    }
}
