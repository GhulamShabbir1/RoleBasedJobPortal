<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'description',
        'logo',
        'website',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'certification',
        'status',
        'approved_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the employer who owns this company
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all jobs posted by this company
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    /**
     * Get the admin who approved this company
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get all applications for jobs posted by this company
     */
    public function applications()
    {
        return $this->hasManyThrough(Application::class, Job::class);
    }
}
