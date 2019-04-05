<?php

namespace App\Models\Dashboard;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ShippingFees extends Model
{
    //
    protected $table='shipping_fees';
    protected $fillable=['user_id','city_id','fees'];

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function client(){
        return $this->belongsTo(User::class);
    }
}
