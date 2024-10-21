<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('tasks')->get();
        return response()->json($projects);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function assignManager(Request $request, $projectId)
    {
        $validated= $request->validate([
            'user_id'=>'required|exists:user,id'
        ]);

        $project = Project::findOrFail($projectId);
        $project->manager_id=$validated['user_id'];
        $project->save();

        return response()->json($project);
    }

    // назначенире исполнителя
    public function assignExecutor(Request $request, $projectId)
    {
        $validated = $request->validate([
            'user_id'=>'required|exists:user,id'
        ]);

        $project = Project::findOrFail($projectId);
        $project->executors()->attach($validated['user_id']);

        return response()->json($project);
    }

 //Создание проекта
    public function createProject(Request $request)
    {
        $validateData = $request->validate([
            'title'=>'required|string',
            'content'=>'required|text',
            'date_start'=>'required|date',
            'date_end'=>'required|date|after:date_start',
            'user_id'=>'required',
            
        ]);

        $project = Project::create([
            'title'=>$validateData['name'],
            'content'=>$validateData['content'],
            'date_start'=>$validateData['date_start'],
            'date_end'=>$validateData['date_end'],
            'status'=> 'Создан'
        ]);

        $project->user()->attach($validateData['user_id']);
        return response()->json($project, 201);
    }

    //полуячние татуса проекта
    public function getProjectStatus()
    {
        $projects = Project::with('tasks')->get()->map(function($project){
            return [
                'id'=>$project->id,
                'title'=>$project->title,
                'content'=>$project->content,
                'date_start'=>$project->date_start,
                'date_end'=>$project->date_end,
                'status'=>$project->status,
                
            ];
        });

        return response()->json($projects, 200);
    }

    
}
