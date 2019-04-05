<?php

namespace App\Models\Site;

use App\Agent;
use App\Models\Dashboard\Area;
use App\Models\Dashboard\City;
use App\Models\Dashboard\Office;
use App\Models\Dashboard\OrderStatus;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class Order extends Model
{
    //
    protected $table = 'orders';
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['description', 'notes', 'cod', 'security_number', 'receiver_name', 'city_id'
        , 'area_id', 'address','office_id','pickup_date', 'agent_id', 'shipping_fees', 'mark_place','delivery_agent_id', 'mobile', 'user_id', 'status', 'tracking_number'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function agent(){
        return $this->belongsTo(Agent::class,'agent_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function office(){
        return $this->belongsTo(Office::class);
    }

    public function check_auth()
    {
        return $this->user_id != auth()->user()->id;
    }

    public function delivery_agent(){
        return $this->belongsTo(Agent::class,'delivery_agent_id','id');
    }

    public function order_statuses(){
        return $this->hasMany(OrderStatus::class)->latest();
    }

    public function delete(){
        return parent::delete();
    }
}
