<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'study_plan_id',
        'classroom_id',
        'academic_semester_id',
        'section',
        'type',
        'time_range',
        'day',
    ];

    public function studyPlan()
    {
        return $this->belongsTo(StudyPlan::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function semester()
    {
        return $this->belongsTo(AcademicSemester::class, 'academic_semester_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
