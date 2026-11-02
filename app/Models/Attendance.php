<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'teacher_id',
        'schedule_id',
        'check_in',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'check_in' => 'datetime',
            'status' => 'boolean',
        ];
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
