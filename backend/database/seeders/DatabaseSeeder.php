<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $project1 = Project::create([
            'name' => 'Lançamento do Novo Website',
            'description' => 'Redesign completo da landing page corporativa BOKOrps',
            'status' => 'active',
        ]);

        Task::create([
            'project_id' => $project1->id,
            'title' => 'Criar wireframes no Figma',
            'status' => 'done',
            'priority' => 'high',
            'due_date' => Carbon::now()->subDays(2),
        ]);

        Task::create([
            'project_id' => $project1->id,
            'title' => 'Implementar frontend em Vue 3',
            'status' => 'in_progress',
            'priority' => 'high',
            'due_date' => Carbon::now()->addDays(5),
        ]);

        $project2 = Project::create([
            'name' => 'Auditoria de Segurança',
            'description' => 'Revisão de acessos e testes de penetração na API.',
            'status' => 'active',
        ]);

        Task::create([
            'project_id' => $project2->id,
            'title' => 'Atualizar dependências do Composer',
            'status' => 'todo',
            'priority' => 'medium',
            'due_date' => Carbon::now()->subDay(), 
        ]);
        
    }
}
