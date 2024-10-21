<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\Comment;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function createTask(Request $request)
    {
        $validateData = $request->validate([
            'title'=>'required|string|max:255',
            'description'=>'required|string',
            'projects_id'=>'required|exists:projects,id',
            'user_id'=>'required|exists:users,id',
            'priority'=>'required|in:Низкий,Средний,Высокий',
            'date_start'=>'nullable|date',
            'date_end'=>'nullable|date|after:date_start',
            'status'=>'required|in:Неназначена,Выполняется,Завершена'

        ]);

        $task = Task::create($validateData);
        return response()->json($task, 201);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function assignUser(Request $request, $taskId)
    {
        $validateData = $request->validate([
            'user_id'=>'required|exists:users,id',
        ]);

        $task = Task::findOrFail($taskId);
        $task->user_id=$validateData['user_id'];
        $task->save();

        return response()->json($task,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updateStatus(Request $request, $taskId)
    {
        $validatedData = $request->validate([
            'status'=>'required|in:Назначена,Выполняется,Завершена'
        ]);


        $task = Task::findOrFail($taskId);
        $task->status = $validatedData['status'];
        $task->save();

        return response()->json($task, 200);
    }

    /**
     * Display the specified resource.
     */
    public function getTaskStatus($taskId)
    {
        $task = Task::with('project')->findOrFail($taskId);

        return response()->json([
            'id'=>$task->id,
            'title'=>$task->title,
            'description'=>$task->description,
            'project'=>[
                'id'=>$task->project->id,
                'title'=>$task->project->title,
                'status'=>$task->project->status,
            ],
            'user'=>[
                'id'=>$task->user_id,
                'name'=>$task->user->name,
            ],

            'priority'=>$task->priority,
            'date_start'=>$task->date_start,
            'date_end'=>$task->date_end,
            'status'=>$task->status
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function getTasksByProject(Request $request, $projectId)
    {
        $tasks = Task::with('project')->where('project_id', $projectId)->paginate(10);
        return response()->json($tasks, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function getAssignesTasks(Request $request)
    {
        $userId = auth()->id();
        $perPage = $request->input('per_page', 10);

        $tasks = Task::where('user_id', $userId)->paginate($perPage);
        
        return response()->json($tasks, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function complitedTask(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);

        $task->status = 'Завершена';
        $task->save();
        return response()->json(['message'=>'Успешно'], 200);
    }

    public function addComments(Request $request, $taskId){
        $request->validate([
            'comment'=>'required|string'
        ]);

        $task = Task::findOrFail($taskId);
        
        $comment = Comment::create([
            'comment'=> $request->comment,
            'user_id'=> auth()->id(),
            'task_id'=>$task->id,
        ]);

        return response()->json($comment, 201);
    }

    public function getComment($taskId){
        $task = Task::findOrFail($taskId);
        $comments = $task->comments;

        return response()->json($comments);
    }
}
