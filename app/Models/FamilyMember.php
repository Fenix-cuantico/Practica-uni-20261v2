<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    protected $fillable = [
        'teacher_id',
        'name',
        'relationship',
        'birth_date',
        'civil_status',
        'education_level',
        'occupation',
        'is_dependent'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_dependent' => 'boolean',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
