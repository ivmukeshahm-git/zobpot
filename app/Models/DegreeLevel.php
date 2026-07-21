<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DegreeLevel extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_degree_level';
    protected $primaryKey = 'degree_level_id';

    protected $fillable = [
        'degree_level_name',
        'approve_status',
        'reject_reason'
    ];

    public function degrees()
    {
        return $this->hasMany(Degree::class, 'degree_level_id', 'degree_level_id');
    }
}
