<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicCalendar extends Model
{
    protected $fillable = [
        'academic_semester_id',
        'period_code',
        'week_name',
        'start_date',
        'end_date',
        'activity_description',
        'is_lecture_week',
        'week_number',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_lecture_week' => 'boolean',
        ];
    }

    public function semester()
    {
        return $this->belongsTo(AcademicSemester::class, 'academic_semester_id');
    }
}
