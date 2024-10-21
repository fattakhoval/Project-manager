<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Report;
use App\Models\Task;
use Barryvdh\DomPDF\Facade\PDF;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function generateFullReport(Request $request){
        $projects = Project::all();
        $tasks = Task::all();

        $statistics = [
            'total_projects' => $projects->count(),
            'total_tasks'=>$tasks->count(),
            'completed_tasks'=>$tasks->where('status', 'Завершена')->count(),
            'in_progress_tasks'=>$tasks->where('status', 'Выполняется')->count(),
            'assigned_tasks'=>$tasks->where('status', 'Назначена')->count()
        ];

        $report = Report::create([
            'project_id'=> null,
            'created_at'=>now(),
            'user_id'=>auth()->id(),
            'statistics'=>json_encode($statistics)
        ]);

        $report->tasks() = $tasks;

        return response()->json($report,201);
    }

    //отчет по проекту для мнеджера

    public function generateProjectReport(Request $request, $projectId){
        $project = Project::findOrFail($projectId);
        $tasks = $project->tasks;

        $statistics = [
            'total_tasks'=>$tasks->count(),
            'completed_tasks'=>$tasks->where('status', 'Завершена')->count(),
            'in_progress_tasks'=>$tasks->where('status', 'Выполняется')->count(),
            'assigned_tasks'=>$tasks->where('status', 'Назначена')->count()

        ];

        $report = Report::create([
            'project_id'=> null,
            'created_at'=>now(),
            'user_id'=>auth()->id(),
            'statistics'=>json_encode($statistics)

        ]);

        return response()->json($report, 201);
    }

    public function generateUserReport(Request $request, $userId){
        $tasks = Task::where('user_id', $userId)
        ->whereIn('status', ['Выполняется', 'Завершена'])->get();

        $statistics = [
            'total_tasks'=>$tasks->count(),
            'completed_tasks'=>$tasks->where('status', 'Завершена')->count(),
            'in_progress_tasks'=>$tasks->where('status', 'Выполняется')->count(),
            
        ];

        $report = Report::create([
            'project_id'=> null,
            'created_at'=>now(),
            'user_id'=>auth()->id(),
            'statistics'=>json_encode($statistics)
        ]);

        return response()->json($report, 201);
    }

    public function getUserStatistics(Request $request){
        $userId = auth()->id();

        $tasks = Task::where('user_id', $userId)->get();

        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('status', 'Завершена')->count();
        $inProgressTasks = $tasks->where('status', 'Выполняется')->count();
        $commentCount = Comment::where('user_id', $userId)->count();

        return response()->json([
            'totalTasks' => $totalTasks,
            'completedTasks'=> $completedTasks,
            'inProgressTasks'=> $inProgressTasks,
            'commentCount'=> $commentCount
        ]);
    }

    public function exportToPDF($reportId){
        $report = Report::findOrFail($reportId);

        $pdf = PDF::loadView('reports.pdf', ['report' => $report]);
        return $pdf->download('report_' . $report->id . '.pdf');


    }

    public function exportToExcel($reportId){
        return Excel::download(new ReportExport($reportId), 'report_' . $reportId . 'xlsx');
    }

}