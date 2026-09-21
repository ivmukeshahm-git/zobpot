<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InterviewTipPoint extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_interview_tip_points';
    protected $primaryKey = 'id';

    protected $fillable = [
        'interview_tip_id',
        'title',
        'description',
        'sort_order',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $dates = ['deleted_at'];

    public function interviewTip()
    {
        return $this->belongsTo(InterviewTip::class, 'interview_tip_id', 'id');
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
