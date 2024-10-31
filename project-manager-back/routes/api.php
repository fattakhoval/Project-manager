<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('admin')->group(function () {
    Route::get('/users', [AuthController::class, 'index']);
    Route::post('/users', [AuthController::class, 'create'])->name('users.create');
    Route::post('/users/{id}', [AuthController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [AuthController::class, 'destroy'])->name('users.destroy');

    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/projects/{projectId}/assign-manager', [ProjectController::class, 'assignManager']);
    Route::post('projects/{projectId}/assign-executor', [ProjectController::class, 'assignExecutor']);

    Route::post('/reports/generate-full/', [ReportController::class, 'generateFullReport']);
    Route::get('/reports/export/pdf/{reportId}', [ReportController::class, 'exportToPDF']);
    Route::post('/reports/export/excel/{reportId}', [ReportController::class, 'exportToExcel']);
});

Route::prefix('manager')->group(function () {
    Route::post('/projects', [ProjectController::class, 'getAssignProjects']);
    Route::post('/projects/create', [ProjectController::class, 'createProject']);
    Route::get('/projects/{projectId}/tasks', [TaskController::class, 'getTasksByProject']);

    Route::get('/users/non-admin', [AuthController::class, 'getNonAdminUsers']);

    Route::post('/tasks/create', [TaskController::class, 'createTask']);
    Route::post('tasks/{taskId}/assign', [TaskController::class, 'assignUser']);
    Route::get('/tasks/{taskId}/status', [TaskController::class,'getTaskStatus']);
    Route::patch('/tasks/{taskId}/status', [TaskController::class, 'updateStatus']);
    Route::get('/tasks', [TaskController::class,'index']);

    Route::post('/reports/projects/{projectId}/generate', [ReportController::class, 'generateProjectReport']);
    Route::post('reports/users/{userId}/generate', [ReportController::class, 'generateUserReport']);
});

Route::prefix('user')->group(function () {
    Route::post('/tasks', [TaskController::class, 'getAssignedTasks']);
    Route::put('/tasks/{taskId}/complete', [TaskController::class, 'completedTask']);
    Route::post('/tasks/{taskId}/comments', [TaskController::class, 'addComment']);
    Route::get('/tasks/{taskId}/comments', [TaskController::class, 'getComments']);

    Route::get('/statistics', [ReportController::class, 'getUserStatistics']);
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class,'logout']);
});