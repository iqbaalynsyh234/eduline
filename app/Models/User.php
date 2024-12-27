<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'phone_number',
        'email',
        'password',
        'brand_id',
        'program_id',
        'birth_city',
        'birth_date',
        'religion',
        'gender',
        'province',
        'city',
        'district',
        'subdistrict',
        'postal_code',
        'address',
        'father_name',
        'father_job',
        'father_email',
        'father_phone',
        'mother_name',
        'mother_job',
        'mother_email',
        'mother_phone',
        'onboarding_completed',
        'school_origin',
        'class',
        'instagram',
        'subject',
        'hobby',
        'photo',
        'is_active', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'address' => 'array',
        'onboarding_completed' => 'boolean',
    ];

    public function isActive()
    {
        return $this->is_active;
    }

    function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    function students()
    {
        return $this->hasMany(Student::class);
    }
    function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    function province()
    {
        return $this->belongsTo(Province::class, 'province', 'id_prov');
    }
    function city()
    {
        return $this->belongsTo(City::class, 'city', 'id_kab');
    }

    function district()
    {
        return $this->belongsTo(District::class, 'district', 'id_kec');
    }

    function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class, 'subdistrict', 'id_kel');
    }
    
    function targets()
    {
        return $this->hasMany(Target::class);
    }

    function assessments()
    {
        return $this->hasMany(Assessment::class, 'student_id');
    }

    function kbms()
    {
        return $this->hasMany(Kbm::class, 'student_id');
    }

    function coachings()
    {
        return $this->hasMany(Coaching::class, 'student_id');
    }

    function teachingKbms()
    {
        return $this->hasMany(Kbm::class, 'teacher_id');
    }
    function coachingSessions()
    {
        return $this->hasMany(Coaching::class, 'coach_id');
    }

}
