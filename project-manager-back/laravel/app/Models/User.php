<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($roleName){
        return $this->roles()->where('name', $roleName)->exists();
    }

    public function hasPrimission($premissionName){
        return $this->roles()->whereHas('permission', function($query) use ($premissionName){
            $query->where('name', $premissionName);
        })->exists();
    }

    public function assignRole($role){
        if(in_array($role, ['Админ', 'Руководитель проекта', 'Исполнитель'])){
            $this->role = $role;
            $this->save();
        }
    }




}
