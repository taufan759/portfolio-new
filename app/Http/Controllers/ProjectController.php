<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    public const CATEGORIES = ['fullstack', 'uiux', 'ai'];
    public const PER_PAGE = 12;

    public function index()
    {
        $category = in_array(request('category'), self::CATEGORIES, true) ? request('category') : null;

        // A project can sit in several categories, so count each category over all published projects.
        $all = Project::where('is_published', true)->get(['id', 'category', 'categories']);
        $counts = collect(self::CATEGORIES)->mapWithKeys(fn ($c) => [$c => $all->filter(fn ($p) => in_array($c, $p->allCategories(), true))->count()]);

        $projects = Project::listed()
            ->when($category, fn ($q) => $q->where(fn ($w) => $w->where('category', $category)->orWhereJsonContains('categories', $category)))
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('projects.index', [
            'projects' => $projects,
            'category' => $category,
            'counts' => $counts,
            'total' => $all->count(),
        ]);
    }

    public function show(string $slug)
    {
        $project = Project::where('is_published', true)->where('slug', $slug)->firstOrFail();

        $related = Project::listed()
            ->where('id', '!=', $project->id)
            ->orderByRaw('category = ? desc', [$project->category])
            ->limit(3)
            ->get();

        return view('projects.show', ['project' => $project, 'related' => $related]);
    }
}
