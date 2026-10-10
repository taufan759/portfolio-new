<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Event;
use App\Models\Partner;
use App\Models\Project;
use App\Support\GitHub;

class AboutController extends Controller
{
    public function index()
    {
        // Refresh the GitHub activity after the response is sent, so a slow API never delays the page.
        app()->terminating(fn () => GitHub::refreshIfStale());

        // Related project slugs for each "area of focus" (same order as lang about.focus_items).
        $focusSlugs = [
            ['baleide', 'ray-academy', 'adaptable-consulting', 'miemiebrownie', 'raylife', 'custom-photo-booth'],
            ['dbrandainalize', 'cantik-ai-wellness-analyzer', 'ai-product-concept-simulator', 'baleide'],
            ['kang-wendra', 'cantik-ai-wellness-analyzer'],
            ['dian-indah-abadi'],
            ['senada'],
        ];
        $bySlug = Project::where('is_published', true)->whereIn('slug', collect($focusSlugs)->flatten()->unique())->get()->keyBy('slug');
        $focusProjects = collect($focusSlugs)->map(fn ($slugs) => collect($slugs)->map(fn ($s) => $bySlug->get($s))->filter()->values());

        $certificates = Certificate::orderBy('sort')->get();

        // Figures come from the real data, so they stay true as content grows.
        $stats = [
            Project::where('is_published', true)->count(),
            $certificates->count(),
            max(1, now()->year - 2023),
            count(config('site.skills')),
        ];

        return view('about', [
            'focusProjects' => $focusProjects,
            'stats' => $stats,
            'certificates' => $certificates,
            'partners' => Partner::listed()->get(),
            'events' => Event::listed()->get(),
            'github' => GitHub::cached(),
        ]);
    }
}
