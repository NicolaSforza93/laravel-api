<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $request->all();

        if ($request->has('trashed')) {
            $query = Project::onlyTrashed()->get();
        } else {
            $query = Project::all()->sortBy('date_creation');
        }

        $projects = $query;
        $trashedElements = Project::onlyTrashed()->count();

        return view('admin.projects.index', compact('projects', 'trashedElements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::orderBy('name', 'ASC')->get();
        $technologies = Technology::orderBy('name', 'ASC')->get();

        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        // $data = $request->all();

        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            $img_path = Storage::put('images', $data['cover_image']);

            $data['cover_image'] = $img_path;
        }

        $new_project = Project::create($data);

        if ($request->has('technologies')) {
            $new_project->technologies()->attach($data['technologies']);
        }

        return redirect()->route('admin.projects.index', $new_project->id)->with('message_create', "$new_project->name_project aggiunto correttamente");
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::orderBy('name', 'ASC')->get();
        $technologies = Technology::orderBy('name', 'ASC')->get();

        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        // $data = $request->all();

        $request->validate([
            'name_project' => ['required', 'max:200', 'string', Rule::unique('projects')->ignore($project->id)],
            'date_creation' => 'required|date',
            'status' => [
                'required',
                Rule::in(['Completato', 'In corso', 'Non completato'])
            ],
            'description' => 'nullable|min:5|string',
            'type_id' => 'nullable|exists:types,id',
            'technologies' => 'exists:technologies,id',
            'cover_image' => 'nullable|file|max:2048|mimes:jpg,png'
        ]);

        $data = $request->all();

        if ($request->hasFile('cover_image')) {
            $img_path = Storage::put('images', $data['cover_image']);

            $data['cover_image'] = $img_path;

            // Elimino il file precedente se sto salvando una nuova immagine
            if ($project->cover_image) {
                Storage::delete($project->cover_image);
            }
        }

        $project->update($data);

        if ($request->has('technologies')) {
            $project->technologies()->sync($data['technologies']);
        } else {
            $project->technologies()->sync([]);
        }

        return redirect()->route('admin.projects.show', $project->id)->with('message_edit', "$project->name_project modificato correttamente");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($project_id)
    {
        $project = Project::withTrashed()->where('id', $project_id)->first();

        if (!isset($project)) {
            abort(404);
        }

        $project->technologies()->sync([]);

        if ($project->trashed()) {
            $project->forceDelete();
        } else {
            $project->delete();
        }

        return redirect()->route('admin.projects.index')->with('message_destroy', "$project->name_project eliminato correttamente");
    }

    public function restore($project_id)
    {
        $project = Project::withTrashed()->where('id', $project_id)->first();

        if (!isset($project)) {
            abort(404);
        }

        if ($project->trashed()) {
            $project->restore();
        }

        return redirect()->route('admin.projects.index')->with('message_restore', "$project->name_project ripristinato");
    }
}
