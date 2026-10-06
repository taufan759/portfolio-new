<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        return view('projects.index', [
            'projects' => Project::where('is_published', true)->orderBy('sort')->get(),
        ]);
    }

    public function show(string $slug)
    {
        $project = Project::where('is_published', true)->where('slug', $slug)->firstOrFail();

        $related = Project::where('is_published', true)
            ->where('id', '!=', $project->id)
            ->orderByRaw('category = ? desc', [$project->category])
            ->orderBy('sort')
            ->limit(2)
            ->get();

        return view('projects.show', ['project' => $project, 'related' => $related]);
    }
}
