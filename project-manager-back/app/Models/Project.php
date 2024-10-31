<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    public $timestamps = false;

    protected $fillable=['name', 'description', 'start_date', 'end_date', 'status'];


    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    public function report(){
        return $this->hasOne(Report::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

}
