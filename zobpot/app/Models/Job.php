<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_job';        // Custom table name
    protected $primaryKey = 'job_id';        // Custom primary key

    protected $fillable = [
        'user_id',
        'preference_type',
        'category_id',
        'sub_category_id',
        'job_title',
        'qualification_id',
        'job_level_id',
        'job_type_id',
        'work_type_id',
        'number_of_openings',
        'salary_budget',
        'job_description',
        'interviewer_address',
        'experience_req_id',
        'job_timing',
        'age',
        'gender',
        'contact_no',
        'company_website',
        'company_address',
        'state_id',
        'city_id',
        'area_id',
        'zipcode_id',
        'hr_email',
        'hr_contact_no',
        'skill_id',
        'datetime',
        'status',
        'total_apply',
        'remain_opening',
    ];

    protected $dates = ['deleted_at'];            // Required for soft deletes

    protected $casts = [
        'salary_budget' => 'string',
    ];

    public function company()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'category_id', 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(Jobsubcategory::class, 'sub_category_id', 'sub_category_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'state_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'area_id');
    }

    public function whatsappNotifications()
    {
        return $this->hasMany(WhatsappNotification::class, 'job_id', 'job_id');
    }

//     public function activeJobs()
// {
//     return $this->hasMany(Job::class, 'category_id', 'category_id')
//                 ->where('status', 1)        // only active jobs
//                 ->whereNull('deleted_at');  // job deleted na hoy
// }

}
