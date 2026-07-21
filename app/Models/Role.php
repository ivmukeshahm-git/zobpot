<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';        // Custom table name
    protected $primaryKey = 'id';        // Custom primary key

    protected $fillable = [
        'name',
        'guard_name',
        'college_id'
    ];
}
