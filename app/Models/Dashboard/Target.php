<?php

namespace App\Models\Dashboard;

use App\Agent;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    //
    protected $table='targets';
    protected $fillable=['name','max','percent','agent_id'];

    public function agent(){
        return $this->belongsTo(Agent::class);
    }
}
