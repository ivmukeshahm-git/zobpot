<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyBranch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_company_branches';        // Custom table name
    protected $primaryKey = 'branch_id';        // Custom primary key

    protected $fillable = [
        'user_id',
        'company_nm',
        'company_address',
        'status'
    ];

    protected $dates = ['deleted_at'];            // Required for soft deletes
}
