<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controller\Api\ProjectController;
use App\Http\Controller\Api\TaskController;

//Limite de requisições de 60 por minuto
Route::middleware('throttle:60,1')->group(function (){
    
    //Rota de projetos
    Route::apiResource('projects', ProjectController::class)->only(['index','store']);

    //Rota de tarefas atreladas à Projetos
    Route::get('projects/{project}/tasks',[TaskController::class,'index']);

    Route::post('projects/{project}/tasks',[TaskController::class,'store']);

    //Rotas de tarefas independentes
    Route::patch('tasks/{task}',[TaskController::class,'update']);
    Route::delete('tasks/{taks}',[TaskController::class,'destroy']);
});
