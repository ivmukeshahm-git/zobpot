<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_major';
    protected $primaryKey = 'major_id';

    protected $fillable = [
        'degree_id',
        'major_name',
        'approve_status',
        'reject_reason'
    ];

    // allow approve_status and reject_reason
    protected $casts = [
        'approve_status' => 'integer'
    ];

    public function degree()
    {
        return $this->belongsTo(Degree::class, 'degree_id', 'degree_id');
    }
}
