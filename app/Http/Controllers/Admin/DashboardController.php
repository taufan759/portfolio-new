<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsItem;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [];
        foreach (config('admin') as $key => $def) {
            $stats[$key] = ['label' => $def['label'], 'count' => $def['model']::count()];
        }
        $stats['news'] = ['label' => 'News headlines', 'count' => NewsItem::count()];

        return view('admin.dashboard', ['stats' => $stats]);
    }

    public function fetchNews()
    {
        Artisan::call('news:fetch');

        return back()->with('status', trim(Artisan::output()));
    }
}
