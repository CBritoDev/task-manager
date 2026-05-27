<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/projects/{id}/tasks
     */
    public function index(Request $request, Project $project)
    {
        $query = $project->tasks();

        $query->when($request->status, fn($q,$v) => $q->where('status', $v));
        $query->when($request->priority, fn($q,$v) => $q->where('priority',$v));

        return TaskResource::collection($query->paginate());
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/projects/{id}/tasks
     */
    public function store(StoreTaskRequest $request, Project $project)
    {
        $task = $project->tasks()->create($request->validated());
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     * PATCH /api/tasks/{id}
     */
    public function update(UpdateTaskRequest $request, string $id)
    {
        $task->update($request->validated());
        return new TaskResource($taks);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/tasks/{id}
     */
    public function destroy(string $id)
    {
        $task->delete();
        return response()->noContent();
    }
}
