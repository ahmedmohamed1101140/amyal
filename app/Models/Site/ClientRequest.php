<?php

namespace App\Models\Site;

use App\Agent;
use App\Models\Dashboard\City;
use App\Models\Dashboard\ClientRequestStatus;
use Illuminate\Database\Eloquent\Model;

class ClientRequest extends Model
{
    //
    protected $table = 'client_requests';
    protected $fillable=['name','phone','city_id','status','action','agent_id'];

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function agent(){
        return $this->belongsTo(Agent::class);
    }

    public function statuses(){
        return $this->hasMany(ClientRequestStatus::class)->orderBy('created_at', 'desc');
    }
}
