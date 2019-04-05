<?php

namespace App\Models\Dashboard;

use App\Agent;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    protected $table='permissions';

    protected $fillable=['description','page_name','route_name'];

    public function employees(){
        return $this->belongsToMany(Agent::class,'employee_permissions');
    }

}
