<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
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
     * Get the candidate who applied
     */
    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    /**
     * Get the employer through the job
     */
    public function employer()
    {
        return $this->hasOneThrough(User::class, Job::class, 'id', 'id', 'job_id', 'created_by');
    }
}
