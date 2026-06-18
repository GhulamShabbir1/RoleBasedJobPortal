<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateProfile extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'city',
        'education',
        'skills',
        'experience',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
