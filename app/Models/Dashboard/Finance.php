<?php

namespace App\Models\Dashboard;

use App\Agent;
use App\Models\Site\Order;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    //
    protected $table='finances';

    protected $fillable = ['order_id','cod','shipping_fees','order_status','remains','user_id','agent_id','status'];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function agent(){
        return $this->belongsTo(Agent::class);
    }
}
