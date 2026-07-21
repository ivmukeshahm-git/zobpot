<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'users';


    protected $fillable = [
        'name',
        'active_plan_id',
        'email',
        'password',
        'contact_no',
        'city_id',
        'state_id',
        'area_id',
        'zipcode_id',
        'otp',
        'address',
        'role',
        'experience',
        'expected_salary',
        'languages',
        'category_id',
        'sub_category_id',
        'skills_id', // ✅ make sure this exists
        'company_desc',
        'about',
        'university_id',
        'college_id',
        'degree_level_id',
        'degree_id',
        'major_id',
        'semester',
        'preference_type',
        'verify_status',
        'profile_type',
        'active_status',
        'personal_name',
        'contact_person_nm',
        'contact_person_phone_no',
        'average_salary',
        'company_size',
        'company_since',
        'personal_website',
        'profile_img',
        'cover_img',
        'company_signature',
        'certificate_logo',
        'gender',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp', // 🔒 Optionally hide OTP from API responses
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'verify_status'     => 'boolean',
        'active_status'     => 'boolean',
        'skills_id' => 'array',
    ];
    
    
        // Relationships
    public function degree()
    {
        return $this->belongsTo(Degree::class, 'degree_id', 'degree_id');
    }
    
    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id', 'major_id');
    }
    
    public function college()
    {
        return $this->belongsTo(College::class, 'college_id', 'id');
    }
}
