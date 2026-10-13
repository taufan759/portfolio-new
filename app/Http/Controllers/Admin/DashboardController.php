<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsItem;
use App\Models\PageView;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [];
        foreach (config('admin') as $key => $def) {
            $stats[$key] = ['label' => $def['label'], 'count' => $def['model']::count()];
        }
        $stats['news'] = ['label' => 'News headlines', 'count' => NewsItem::count()];

        return view('admin.dashboard', ['stats' => $stats, 'traffic' => $this->traffic()]);
    }

    /** Visit figures. "Visitors" are unique per day (a returning visitor counts once for each day). */
    private function traffic(): array
    {
        $since = fn (int $days) => now()->subDays($days - 1)->startOfDay();

        $count = function (int $days) use ($since) {
            $from = $since($days);

            return [
                'views' => PageView::where('created_at', '>=', $from)->count(),
                'visitors' => (int) DB::table(
                    PageView::where('created_at', '>=', $from)->selectRaw('distinct visitor, date(created_at) as d')
                )->count(),
            ];
        };

        $perDay = PageView::where('created_at', '>=', $since(14))
            ->selectRaw('date(created_at) as d, count(distinct visitor) as visitors')
            ->groupBy('d')->pluck('visitors', 'd');

        $days = [];
        for ($i = 13; $i >= 0; $i--) {
            $d = now()->subDays($i)->toDateString();
            $days[] = ['date' => $d, 'visitors' => (int) ($perDay[$d] ?? 0)];
        }

        $month = fn () => PageView::where('created_at', '>=', $since(30));

        return [
            'today' => $count(1), 'week' => $count(7), 'month' => $count(30),
            'total' => PageView::count(),
            'days' => $days,
            'pages' => $month()->selectRaw('path, count(*) as c')->groupBy('path')->orderByDesc('c')->limit(8)->get(),
            'referrers' => $month()->whereNotNull('referrer')->selectRaw('referrer, count(*) as c')->groupBy('referrer')->orderByDesc('c')->limit(6)->get(),
            'locales' => $month()->whereNotNull('locale')->selectRaw('locale, count(*) as c')->groupBy('locale')->pluck('c', 'locale'),
        ];
    }

    public function fetchNews()
    {
        Artisan::call('news:fetch');

        return back()->with('status', trim(Artisan::output()));
    }
}
