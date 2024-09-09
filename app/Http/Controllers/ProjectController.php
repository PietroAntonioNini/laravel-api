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
            // Carica l'immagine su Google Drive
            $filePath = $request->file('image')->getRealPath();
            $imageUrl = $this->uploadFileToDrive($filePath);  // Usa il metodo per caricare su Google Drive

            // Salva l'URL dell'immagine di Google Drive nel database
            $newProject['image'] = $imageUrl;
        }

        $newProject->fill($request->all());
        $newProject->slug = Str::slug($request->name); // Genera lo slug
        $newProject->save();

        $newProject->technologies()->attach($request->technologies); // Associa le tecnologie

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
            // Carica la nuova immagine su Google Drive
            $filePath = $request->file('image')->getRealPath();
            $imageUrl = $this->uploadFileToDrive($filePath);

            // Salva il nuovo URL dell'immagine di Google Drive
            $project['image'] = $imageUrl;
        }

        $project->slug = Str::slug($request->name); // Aggiorna lo slug
        $project->save();

        $project->technologies()->sync($request->technologies); // Aggiorna le tecnologie associate

        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();

        $project->delete();

        return redirect()->route('admin.projects.index');
    }

    private function uploadFileToDrive($filePath)
    {
        // Ottieni un access token valido
        $accessToken = app(GoogleController::class)->getAccessToken();

        if ($accessToken) {
            $client = new \Google_Client();
            $client->setAccessToken($accessToken);

            $driveService = new \Google_Service_Drive($client);
            $file = new \Google_Service_Drive_DriveFile();
            $file->setName(basename($filePath));

            $content = file_get_contents($filePath);
            $createdFile = $driveService->files->create($file, [
                'data' => $content,
                'mimeType' => mime_content_type($filePath),
                'uploadType' => 'multipart'
            ]);

            // Restituisci l'URL pubblico del file caricato
            return 'https://drive.google.com/uc?id=' . $createdFile->id;
        }

        return null; // Ritorna null se il caricamento fallisce
    }
}
