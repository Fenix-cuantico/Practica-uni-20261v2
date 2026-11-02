<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    protected $fillable = [
        'student_id',
        'schedule_id',
        'session_date',
        'act_fis',
        'act_vir',
        'ult_responsable',
    ];

    protected $casts = [
        'act_fis' => 'boolean',
        'act_vir' => 'boolean',
        'session_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
