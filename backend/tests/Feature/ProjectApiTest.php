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
        Project::factory()->count(3)->create();

        $response = $this->getJson('api/projects');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => ['id', 'name', 'description', 'status', 'tasks_count', 'created_at']
                    ]
                ]);
        
    }

    public function test_can_create_project_with_valid_data()
    {
        $payload = [
            'name' => 'Test Project',
            'description' => 'A valid description',
            'status' => 'active'
        ];

        $response = $this->postJson('/api/projects', $payload);

        $response->assertStatus(201)
                ->assertJsonFragment(['name' => 'Test Project']);

        $this->assertDatabaseHas('projects', ['name' => 'Test Project']);
    }

    public function test_cannot_create_project_with_invalid_data()
    {
        // Enviando payload vazio para forçar erro de validação
        $response = $this->postJson('/api/projects', []); 

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['name']);
    }

    public function test_can_filter_tasks_by_status()
    {
        $project = Project::factory()->create();


        Task::factory()->create(['project_id' => $project->id, 'status' => 'todo']);
        Task::factory()->create(['project_id' => $project->id, 'status' => 'done']);

        $response = $this->getJson("/api/projects/{$project->id}/tasks?status=done");

        $this->assertCount(1,$response->json('data'));
        $this->assertEquals('done', $response->json('data.0.status'));
    }

    public function test_can_soft_delete_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(204); 

        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
    }
}
