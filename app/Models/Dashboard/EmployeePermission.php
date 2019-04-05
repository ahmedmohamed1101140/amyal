<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;

class EmployeePermission extends Model
{
    //
    protected $table=['employee_permissions'];

    protected $fillable=['agent_id','permission_id'];

}
