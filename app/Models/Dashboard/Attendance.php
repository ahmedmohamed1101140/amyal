<?php

namespace App\Models\Dashboard;

use App\Agent;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    protected $table = 'attendances';
    protected $fillable = ['checkIn','checkOut','day','agent_id'];


    public function agent(){
        return $this->belongsTo(Agent::class);
    }
}
