<?php

namespace App\Models\Dashboard;

use App\Agent;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    //
    protected $table = 'offices';

    protected $fillable = ['name'];

    public function employees(){
        return $this->hasMany(Agent::class);
    }

    public function clients(){
        return $this->hasMany(User::class);
    }

    public function delete(){
        return parent::delete();
    }
}
