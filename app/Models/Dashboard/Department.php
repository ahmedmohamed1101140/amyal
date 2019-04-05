<?php

namespace App\Models\Dashboard;

use App\Agent;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
    protected $table = 'departments';

    protected $fillable = ['name'];


    public function employees(){
        return $this->hasMany(Agent::class)->orderBy('created_at', 'desc');
    }

    public function delete()
    {
        foreach ($this->positions()->get() as $position){
            $position->delete();
        }
        return parent::delete();
    }

}
