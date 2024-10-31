<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Permission;

class Role extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function permission(){
        return $this->belongsToMany(Permission::class, 'permissopn_role');
    }

    public function givePermissionTo($premissions){
        if(!is_array($premissions)){
            $premissions= [$premissions];
        }

        foreach($premissions as $premission){
            $this->permissions()->syncWithoutDetaching($premission);
        }
    }
}
