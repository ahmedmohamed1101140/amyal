<?php

namespace App\Models\Dashboard;

use App\Agent;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    //
    protected $table = 'calls';
    protected $fillable = ['date','time','agent_id'];

    public function agent(){
        return $this->belongsTo(Agent::class);
    }
}
