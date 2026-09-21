<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InterviewTip extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_interview_tips';
    protected $primaryKey = 'id';

    protected $fillable = [
        'main_header',
        'short_line',
        'footer_title',
        'footer_description',
        'status',
        'datetime',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $dates = ['deleted_at'];

    public function points()
    {
        return $this->hasMany(InterviewTipPoint::class, 'interview_tip_id', 'id')
            ->orderBy('sort_order', 'asc');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }
}
