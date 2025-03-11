<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
      $query = Project::with(['technologies', 'type']);

      // Filtra per categoria (tipo di progetto)
      if ($request->has('filter') && $request->filter != '') {
        $filter = strtolower($request->filter);
        $query->whereHas('type', function($q) use ($filter) {
            $q->whereRaw('LOWER(name) = ?', [$filter]);
        });
      }

      // Filtra per tecnologia (es. Angular, HTML, ecc.)
      if ($request->has('technology') && $request->technology != '') {
        $technology = $request->technology;
        $query->whereHas('technologies', function($q) use ($technology) {
            $q->where('type', $technology);
        });
      }

      $projects = $query->paginate(12);

      return response()->json([
        "success" => true,
        "results" => $projects,
      ]);
    }

    public function show($slug)
    {
        $project = Project::with(['technologies', 'type'])->where('slug', '=', $slug)->first();

        if ($project) {
            return response()->json([
                "success" => true,
                "project" => $project
            ]);
        } else {
            return response()->json([
                "success" => false,
                "error" => "Project not found"

            ]);
        }
    }
}
