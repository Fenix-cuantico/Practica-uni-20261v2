<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = [
        'room_code',
        'capacity',
        'chair_type',
        'entrance_type',
        'has_projector',
        'has_teacher_pc',
        'door_count',
    ];

    protected function casts(): array
    {
        return [
            'has_projector' => 'boolean',
            'has_teacher_pc' => 'boolean',
        ];
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
