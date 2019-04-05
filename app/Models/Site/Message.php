<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $table ='messages';

    protected $fillable=['ticket_id','sender_id','sender_type','message','attachment'];

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }

}
