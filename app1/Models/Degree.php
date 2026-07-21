<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Degree extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_degree';
    protected $primaryKey = 'degree_id';

    protected $fillable = [
        'degree_level_id',
        'degree_name',
        'approve_status',
        'reject_reason'
    ];

    protected $casts = [
        'approve_status' => 'integer'
    ];

    public function degreeLevel()
    {
        return $this->belongsTo(DegreeLevel::class, 'degree_level_id', 'degree_level_id');
    }

    public function majors()
    {
        return $this->hasMany(Major::class, 'degree_id', 'degree_id');
    }
}
