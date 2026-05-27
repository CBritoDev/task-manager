<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Resources\ProjectResource;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::withCount('tasks')->paginate();
        return ProjectResource::collection($projects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->validated());
        return new ProjectResource($project);
    }

    
}
