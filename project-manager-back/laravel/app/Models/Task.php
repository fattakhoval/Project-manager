<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'projects_id',
        'user_id',
        'priority',
        'date_start',
        'date_end',
        'status'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
