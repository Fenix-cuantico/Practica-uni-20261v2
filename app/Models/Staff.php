<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'user_id',
        'position',
        'area',
        'paternal_last_name',
        'maternal_last_name',
        'first_names',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
