<?php

namespace App\Models\Dashboard;

use App\Agent;
use App\Models\Site\Order;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    //
    protected $table = 'orders_statuses';
    protected $fillable = ['order_id','status_from','status_to','agent_id'
        ,'agent_additional_info'
        ,'client_additional_info'];

    public function agent(){
        return $this->belongsTo(Agent::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }


}
