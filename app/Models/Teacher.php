<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'university_code',
        'academic_department',
        'dedication',
        'condition',
        'ape_pat',
        'ape_mat',
        'name',
        'dni',
        'phone',
        'gender',
        'birthdate',
        'ruc',
        'military_lib',
        'license_category',
        'vehicle_info',
        'marital_status',
        'marriage_date',
        'blood_type',
        'personal_email',
        'birthplace',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courses()
    {
        return $this->belongsToMany(StudyPlan::class, 'course_teacher');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class);
    }
}
