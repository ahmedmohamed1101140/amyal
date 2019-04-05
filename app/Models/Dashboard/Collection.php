<?php

namespace App\Models\Dashboard;

use App\Agent;
use App\Models\Site\Order;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    //
    protected $table = 'collections';

    protected $fillable = ['agent_id','cod','status','order_id','status_agent','office_id'];

    public function agent(){
        return $this->belongsTo(Agent::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function office(){
        return $this->belongsTo(Office::class);
    }

    public function statusAgent(){
        return $this->belongsTo(Agent::class,'status_agent');
    }
}
