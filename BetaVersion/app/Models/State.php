<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_state';
    protected $primaryKey = 'state_id';

    protected $fillable = [
        'state_name',
        'country_id',
    ];

    protected $dates = ['deleted_at'];
}
