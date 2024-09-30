<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Report;
use App\Models\Task;

class Project extends Model
{
    protected $fillable=['title', 'content', 'date_start', 'date_end', 'status'];


    public function report(){
        return $this->hasOne(Report::class);
    }

    public function task(){
        return $this->hasMany(Task::class);
    }


}
