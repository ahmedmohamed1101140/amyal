<?php

namespace App\Models\Site;

use App\Agent;
use App\User;
use Illuminate\Database\Eloquent\Model;

class PickupRequest extends Model
{
    //
    protected $table = 'pickup_requests';
    protected $fillable = ['user_id','req_number','status','agent_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function agent(){
        return $this->belongsTo(Agent::class);
    }
}
