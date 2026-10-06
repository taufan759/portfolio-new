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

        $counts = Project::where('is_published', true)
            ->selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        $projects = Project::listed()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('projects.index', [
            'projects' => $projects,
            'category' => $category,
            'counts' => $counts,
            'total' => $counts->sum(),
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
