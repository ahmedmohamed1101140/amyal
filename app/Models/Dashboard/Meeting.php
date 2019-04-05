<?php

namespace App\Models\Dashboard;

use App\Agent;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    //
    protected $table = 'meetings';
    protected $fillable = ['agent_id','time','date','client_name','person_name','person_number','address','result','reason'];

    public function agent(){
        return $this->belongsTo(Agent::class);
    }
}
