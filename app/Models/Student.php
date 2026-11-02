<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'student_code',
        'specialty',
        'previous_specialty',
        'admission_year',
        'ape_pat',
        'ape_mat',
        'name',
        'dni',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
