<?php

namespace App;

use App\Models\Dashboard\City;
use App\Models\Dashboard\Office;
use App\Models\Dashboard\ShippingFees;
use App\Models\Site\Order;
use App\Models\Site\PickupRequest;
use App\Models\Site\Ticket;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $authGuard = 'client';


    protected $fillable = [
        'company_name', 'last_login','phone','address', 'email', 'password','pickup_address','cp_name',
        'cp_phone','account_number','status','action','city_id','office_id','agent_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function agent(){
        return $this->belongsTo(Agent::class);
    }

    public function office(){
        return $this->belongsTo(Office::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function shippingFees(){
        return DB::SELECT(
        "
                  SELECT cities.id as city_id , cities.name as city_name , shipping_fees.id as shipping_fees_id, shipping_fees.fees as shipping_fee
                  FROM `cities` 
                  LEFT JOIN shipping_fees on cities.id = shipping_fees.city_id AND shipping_fees.user_id = $this->id
              "
        );
    }

    public function shipping_fees(){
        return $this->hasMany(ShippingFees::class);
    }

    public function orders(){
        return $this->hasMany(Order::class)->orderBy('created_at', 'desc');
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    public function pickupRequests(){
        return $this->hasMany(PickupRequest::class);
    }

    public function find_city($key,$value){
        if($this->shipping_fees->contains($key,$value)){
            return true;
        }
        return false;
    }

    public function getCityShippingFees($value){
        if($this->shipping_fees->contains('city_id',$value)){
            return $this->shipping_fees()
                ->where('city_id','=',$value)
                ->select('fees')
                ->first()
                ->fees;
        }
    }
}
