<?php

namespace App\Models\Dashboard;

use App\Models\Site\Order;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //
    protected $table = 'areas';

    protected $fillable = ['name','city_id'];

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function delete(){
        return parent::delete();
    }
}
