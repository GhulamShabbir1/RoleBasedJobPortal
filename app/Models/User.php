<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | JWT Methods
    |--------------------------------------------------------------------------
    */

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Employer -> Company
    public function company()
    {
        return $this->hasOne(Company::class);
    }

    // Candidate -> Candidate Profile
    public function candidateProfile()
    {
        return $this->hasOne(CandidateProfile::class);
    }

    // Candidate -> Applications
    public function applications()
    {
        return $this->hasMany(Application::class, 'candidate_id');
    }

    // User(Admin/Employer) -> Jobs Created
    public function jobs()
    {
        return $this->hasMany(Job::class, 'created_by');
    }
}