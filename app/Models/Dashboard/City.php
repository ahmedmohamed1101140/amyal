<?php

namespace App\Models\Dashboard;

use App\Agent;
use App\Models\Site\ClientRequest;
use App\Models\Site\Order;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    protected $table='cities';

    protected $fillable=['name'];

    public function areas(){
        return $this->hasMany(Area::class)->orderBy('created_at', 'desc');
    }

    public function employees(){
        return $this->hasMany(Agent::class)->orderBy('created_at', 'desc');
    }

    public function applications(){
        return $this->hasMany(ClientRequest::class)->orderBy('created_at', 'desc');
    }

    public function shipping_fees(){
        return $this->hasMany(ShippingFees::class);
    }

    public function orders(){
        return $this->hasMany(Order::class)->orderBy('created_at', 'desc');
    }

    public function delete(){
        foreach ($this->areas()->get() as $area){
            $area->delete();
        }
        return parent::delete();
    }

}
