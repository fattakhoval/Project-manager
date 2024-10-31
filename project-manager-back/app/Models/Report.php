<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{

    public $timestamps = false;

    protected $fillable=['projects_id', 'date_create', 'users_id', 'statistic'];

    protected $casts = [
        'created_at' => 'date',
        'statistics' => 'array', // Преобразование JSON в массив
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }
}
