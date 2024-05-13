<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['technologies', 'type'])->paginate(12);


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
