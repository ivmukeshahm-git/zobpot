<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class CollegeStaff extends Authenticatable
{
    use SoftDeletes, HasRoles;

    protected $table = 'tbl_college_staff';

    protected $guard_name = 'college_staff';

    protected $fillable = [
        'college_id',
        'name',
        'email',
        'phone',
        'password',
        'role_id',
        'active_status',
    ];

    protected $hidden = [
        'password',
    ];

    public function college()
    {
        return $this->belongsTo(College::class, 'college_id');
    }

    public function role()
    {
        return $this->belongsTo(\Spatie\Permission\Models\Role::class, 'role_id');
    }
}
