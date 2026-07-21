<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_registrations';

    protected $fillable = [
        'type',        // 1 = Hackathon, 2 = Internship
        'internship_id', // Foreign key to tbl_internship
        'name',
        'email',
        'phone_no',
        'city',
        'pincode',
        'university',
        'college',
        'degree',
        'gender',
        'status'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Relationship with Internship
    public function internship()
    {
        return $this->belongsTo(Internship::class, 'internship_id');
    }
}
