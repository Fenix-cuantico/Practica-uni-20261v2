<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyPlan extends Model
{
    protected $fillable = [
        'course_code',
        'name',
        'specialty',
        'evaluation_system',
        'theory_hours',
        'practice_hours',
        'lab_hours',
        'credits',
        'cycle',
    ];

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'course_teacher');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
