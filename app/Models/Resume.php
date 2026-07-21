<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Resume extends Model
{
    use HasFactory;

    protected $table = 'tbl_resume';
    protected $primaryKey = 'resume_id';

    protected $fillable = [
        'user_id',
        'file_nm',
        'resume_type',
    ];
}
