<?php

namespace App\Models\Dashboard;

use App\Agent;
use App\Models\Site\ClientRequest;
use Illuminate\Database\Eloquent\Model;

class ClientRequestStatus extends Model
{
    //
    protected $table = 'client_request_statuses';
    protected $fillable =['agent_id','status_from','status_to','action','client_request_id'];

    public function agent(){
        return $this->belongsTo(Agent::class);
    }

    public function client_request(){
        return $this->belongsTo(ClientRequest::class);
    }
}
