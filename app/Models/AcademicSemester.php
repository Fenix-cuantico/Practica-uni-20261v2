<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicSemester extends Model
{
    protected $fillable = [
        'semester_name',
        'start_date',
        'end_date',
        'is_active',
        'curriculum_version',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function calendars()
    {
        return $this->hasMany(AcademicCalendar::class);
    }
}
