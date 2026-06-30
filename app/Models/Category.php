<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all jobs in this category
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    /**
     * Get count of jobs in this category
     */
    public function getJobCountAttribute()
    {
        return $this->jobs()->count();
    }
}
