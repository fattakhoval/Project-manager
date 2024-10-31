<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




#Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
// Route::prefix('admin')->group(function(){
//     Route::post('/users', [AuthController::class, 'createUser'])->name('createUser');
//     Route::post('/users/{id}', [AuthController::class, 'update'])->name('users.update');
//     Route::delete('/users/{id}', [AuthController::class, 'destroy'])->name('users.destroy');

//     Route::get('/projects', [ProjectController::class, 'index']);
//     Route::post('/projects/{projectId}/assign-manager', [ProjectController::class, 'assignManager']);
//     Route::post('/projects/{projectId}/assign-executor', [ProjectController::class, 'assignExecutor']);

//     Route::post('/report/generate_full', [ReportController::class, 'generateFullReport']);
//     Route::get('/report/export/pdf/{reportId}', [ReportController::class, 'exportToPDF']);
//     Route::get('/report/export/excel/{reportId}', [ReportController::class, 'exportToExcel']);
// });

// Route::prefix('manager')->group(function(){
//     Route::get('/projects/status', [ProjectController::class, 'getProjectsStatus']);
//     Route::post('/projects/create', [ProjectController::class,'createProject']);
//     Route::get('/projects/{projectId}/tasks', [TaskController::class, 'getTasksByProject']);

//     Route::post('/tasks/create', [TaskController::class, 'createTask']);
//     Route::post('/tasks/{taskId}/assign', [TaskController::class, 'assignUser']);
//     Route::get('/tasks/{taskId}/status', [TaskController::class, 'getTaskStatus']);
//     Route::patch('/tasks/{taskId}/status', [TaskController::class, 'updateStatus']);


//     Route::post('/reports/projects/{projectId}/generate', [ReportController::class, 'generateProjectReport']);
//     Route::post('/reports/users/{userId}/generate', [ReportController::class, 'generateUserReport']);

// });

// Route::prefix('user')->group(function(){
//     Route::get('/tasks', [TaskController::class, 'getAssignTasks']);
//     Route::put('/tasks/{taskId}/complete', [TaskController::class, 'completedTask']);
//     Route::post('/tasks/{taskId}/comments', [TaskController::class, 'addComment']);
//     Route::get('/tasks/{taskId}/comments', [TaskController::class, 'getComments']);

//     Route::get('/statistics', [ReportController::class, 'getUserStatistics']);
// });

