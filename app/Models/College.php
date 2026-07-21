<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class College extends Model implements AuthenticatableContract
{
    use SoftDeletes, Authenticatable;

    protected $table = 'tbl_college';

    protected $fillable = [
        'college_name',
        'college_code',
        'university_id',
        'degree_ids',
        'role',
        'email',
        'phone',
        'website',
        'established_year',
        'address',
        'city',
        'state',
        'pincode',
        'logo',
        'certificate_logo',
        'college_signature',
        'status',
        'reject_reason',
        'password',
    ];

    /**
     * Cast degree_ids JSON column to a PHP array automatically.
     * Eloquent will encode/decode JSON on read and write.
     */
    protected $casts = [
        'degree_ids' => 'array',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Accessor so $college->name returns college_name (used in layout).
     */
    public function getNameAttribute()
    {
        return $this->college_name ?? 'College';
    }

    // tbl_college may not have remember_token column
    public function getRememberToken() { return null; }
    public function setRememberToken($value) {}
    public function getRememberTokenName() { return ''; }

    public function university()
    {
        return $this->belongsTo(University::class, 'university_id', 'id');
    }
}
