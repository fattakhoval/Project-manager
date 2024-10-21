<?php 
namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportExport implements FromCollection{
    protected $reportId;

    public function __construct($reportId){
        $this->reportId= $reportId;
    }

    public function collection(){
        $report = Report::findOrFail($this->reportId);
        $statistics = json_decode($report->statistics, true);

        return collect([
            ['Атрибут', 'Значение'],
            ['ID отчета', $report->id],
            ['Проект ID', $report->project_id],
            ['Дата создания', $report->created_at],
            ['Ответственный', $report->user_id],
            ['Статистика', json_encode($statistics)],
        ]);
    }
}