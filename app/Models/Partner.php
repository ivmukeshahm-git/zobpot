<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_partners'; // your table name

    protected $fillable = [
        'name',
        'image',
        'status'
    ];

    public $timestamps = true; // created_at & updated_at auto handle
}