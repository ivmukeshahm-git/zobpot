<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorySubcategoryRequest extends Model
{
    use HasFactory;

    protected $table = 'tbl_category_subcategory_requests';

    protected $fillable = [
        'request_type',
        'requested_name',
        'category_id',
        'parent_category_name',
        'user_id',
        'internship_id',
        'approved_id',
        'status',
    ];

    public const STATUS_PENDING = 0;
    public const STATUS_APPROVED = 1;
    public const STATUS_REJECTED = 2;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'category_id', 'category_id');
    }
}
