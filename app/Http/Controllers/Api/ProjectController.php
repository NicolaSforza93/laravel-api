<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('type', 'technologies')->get();
        foreach ($projects as $project) {
            if ($project->cover_image) {
                $project->cover_image = 'http://127.0.0.1:8000/storage/' . $project->cover_image;
            }
        }
        return response()->json([
            'success' => true,
            'results' => $projects
        ]);
    }

    public function show(Project $project)
    {
        $project->load('type', 'technologies');

        return response()->json([
            'success' => true,
            'results' => $project
        ]);
    }
}
