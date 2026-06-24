<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'category_id',
        'title',
        'description',
        'city',
        'job_type',
        'min_salary',
        'max_salary',
        'deadline',
        'vacancies',
        'status',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who created this job
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the category this job belongs to
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all applications for this job
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Get the company that posted this job
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
