<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'user_id',
        'candidate_id',
        'status',
        'cover_letter',
        'resume_path',
        'applied_at',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the job this application is for
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * Get the candidate who applied (using candidate_id or user_id)
     */
    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    /**
     * Get the candidate via user_id relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the employer through the job
     */
    public function employer()
    {
        return $this->hasOneThrough(User::class, Job::class, 'id', 'id', 'job_id', 'user_id');
    }
}
