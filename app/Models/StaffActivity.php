<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffActivity extends Model
{
    use HasFactory;

    protected $table = 'tbl_staff_activity';        // Custom table name
    protected $primaryKey = 'activity_id';        // Custom primary key

    protected $fillable = [
        'user_id',
        'msg',
        'current_path',
        'datetime'
    ];
}
