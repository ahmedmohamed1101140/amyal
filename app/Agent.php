<?php

namespace App;

use App\Models\Dashboard\City;
use App\Models\Dashboard\Collection;
use App\Models\Dashboard\Department;
use App\Models\Dashboard\Office;
use App\Models\Dashboard\Permission;
use App\Models\Dashboard\Position;
use App\Models\Site\Ticket;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\AgentResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Agent extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $guard = 'agent';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $authGuard = 'agent';



    protected $fillable = [
        'name', 'email', 'last_login','username', 'password', 'phone', 'address', 'age', 'ssn', 'office_id',
        'join_date', 'department_id', 'type' , 'position', 'shift_from', 'shift_to', 'city_id', 'image'
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
        $this->notify(new AgentResetPasswordNotification($token));
    }

    public function collection(){
        return $this->hasOne(Collection::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function myPermissions(){
        return DB::SELECT(
            "
                      SELECT permissions.id , permissions.description , permissions.page_name, permissions.route_name, employee_permissions.agent_id as agent_id
                      FROM `permissions` 
                      LEFT JOIN employee_permissions on permissions.id = employee_permissions.permission_id AND employee_permissions.agent_id = $this->id"
        );
    }

    public function clients(){
        return $this->hasMany(User::class)->orderBy('created_at', 'desc');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function delete()
    {
        return parent::delete();
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class,'employee_permissions');
    }

    public function hasRole($value){
        if($this->permissions->contains('route_name',$value)){
            return true;
        }
        return false;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }


}
