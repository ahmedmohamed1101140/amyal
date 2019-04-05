<?php

namespace App\Models\Site;

use App\Agent;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    protected $table = 'tickets';

    protected $fillable =['subject','status','reference_number','user_id','agent_id'];

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function agent(){
        return $this->belongsTo(Agent::class,'agent_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function check_auth()
    {
        return $this->user_id != auth()->user()->id;
    }

    public function checkAgentAuth()
    {
        return $this->agent_id != auth()->user()->id;
    }

}
