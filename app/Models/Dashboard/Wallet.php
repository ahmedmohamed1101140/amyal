<?php

namespace App\Models\Dashboard;

use App\Agent;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    //
    protected $table='wallet';
    protected $fillable = ['date','amount','receiver_name','payment_method','record_number','user_id','agent_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function agent(){
        return $this->belongsTo(Agent::class);
    }
}
