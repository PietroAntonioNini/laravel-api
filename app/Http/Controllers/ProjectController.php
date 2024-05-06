<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// importo la libreria Str per la gestione delle stringhe
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all();

        $technologies = Technology::all();

        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $request->validated();

        $newProject = new Project();

        if ($request->hasFile('image')) {

            $img_path = Storage::disk('public')->put('imagePro', $request->image);
            $newProject['image'] = $img_path;

        }

        $newProject->fill($request->all());

        // salviamo lo slug
        $newProject->slug = Str::slug($request->name);

        $newProject->save();

        $newProject->technologies()->attach($request->technologies);

        return redirect()->route('admin.projects.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        // dd($project->technologies);

        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::all();

        $technologies = Technology::all();

        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProjectRequest $request, Project $project)
    {
        $project->fill($request->all());

        if ($request->hasFile('image')) {

            $img_path = Storage::disk('public')->put('imagePro', $request->image);
            $project['image'] = $img_path;

        }

        // aggiorno lo slug
        $project->slug = Str::slug($request->name);

        $project->save();

        $project->technologies()->sync($request->technologies);

        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index');
    }
}
