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
        $validated = $request->validate([
            'user_id' => 'required|exists:user,id'
        ]);

        $project = Project::findOrFail($projectId);
        $project->users()->attach($validated['user_id']);


        return response()->json($project);
    }

    // назначенире исполнителя
    public function assignExecutor(Request $request, $projectId)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:user,id'
        ]);

        $project = Project::findOrFail($projectId);
        $project->users()->attach($validated['user_id']);
        

        return response()->json($project);
    }

    //Создание проекта
    public function createProject(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'user_id' => 'exists:users,id'
        ]);

        $project = Project::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'status' => 'Создан',
        ]);

        if ($validatedData['user_id']) {
            $project->users()->attach($validatedData['user_id']);
        }

        return response()->json($project, 201);
    }

    //полуячние татуса проекта
    public function getAssignProjects(Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $projects = Project::with('tasks')
            ->whereHas('users', function ($query) use ($validated) {
                $query->where('users.id', $validated['user_id']);
            })
            ->get()
            ->map(function ($project) {
                return [
                    'id' => $project->id,
                    'name' => $project->name,
                    'description' => $project->description,
                    'start_date' => $project->start_date,
                    'end_date' => $project->end_date,
                    'status' => $project->status,
                ];
            });

        return response()->json($projects, 200);
    }


}
