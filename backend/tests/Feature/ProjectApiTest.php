<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Project;
use App\Models\Task;

class ProjectApiTest extends TestCase
{
    use RefreshDatabase; //garante que o banco zere a cada teste

    public function test_can_list_projects()
    {
        Project::create(['name' => 'Test Project', 'status' => 'active']);

        $response = $this->getJson('api/projects');

        $response->assertStatus(200)
                ->assertJsonStructure(['data' =>[['id','name','tasks_count']]]);
        
    }

    public function test_can_create_project()
    {
        $payload = [
            'name' => 'New API Project',
            'description' => 'Test description',
            'status' => 'active'
        ];

        $response = $this->postJson('/api/projects',$payload);

        $response->assertStatus(201)
                ->assertJsonFragment(['name' => 'New API Project']);

            $this->assertDatabaseHas('projects',['name'=>'New API Project']);
    }

    public function test_can_list_tasks_for_a_project()
    {
        $project = Project::create([
            'name' => 'Task Project', 
            'status' => 'active'
        ]);

        Task::create([
            'project_id' => $project->id, 
            'title' => 'Test Task', 
            'priority' => 'high', 
            'status' => 'todo'
        ]);

        $response = $this->getJson("/api/projects/{$project->id}/tasks");

        $response->assertStatus(200)
                ->assertJsonFragment(['title' => 'Test Task']);

    }
}
