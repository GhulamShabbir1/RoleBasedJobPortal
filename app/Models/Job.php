<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'city',
        'job_type',
        'min_salary',
        'max_salary',
        'dead_line',
        'vacancies',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
