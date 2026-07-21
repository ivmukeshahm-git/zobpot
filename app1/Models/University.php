<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class University extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_university';

    protected $fillable = [
        'university_name',
        'status',
        'reject_reason',
    ];

    public function colleges()
    {
        return $this->hasMany(College::class, 'university_id', 'id');
    }
}
