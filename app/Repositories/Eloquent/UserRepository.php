<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class UserRepository implements UserRepositoryInterface
{
    protected $model;
    private const CACHE_KEY = 'users:';
    private const CACHE_TTL = 3600;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Create or update user using single manage method
     * If $id is null: creates new user
     * If $id is provided: finds and updates existing user
     */
    public function manage(array $data, ?int $id = null): User
    {
        if ($id === null) {
            // Create new user
            $user = $this->model->create($data);
        } else {
            // Update existing user
            $user = $this->model->findOrFail($id);
            $user->update($data);
        }

        // Clear cache
        $this->clearCache();

        return $user;
    }

    /**
     * Get all users
     */
    public function getAllUsers(): Collection
    {
        return $this->model->all();
    }

    /**
     * Get users by role: candidates
     */
    public function getCandidates(): Collection
    {
        return $this->model->where('role', 'candidate')->get();
    }

    /**
     * Get users by role: employers
     */
    public function getEmployers(): Collection
    {
        return $this->model->where('role', 'employer')->get();
    }

    /**
     * Get users by role: admins
     */
    public function getAdmins(): Collection
    {
        return $this->model->where('role', 'admin')->get();
    }

    /**
     * Find user by ID
     */
    public function findById(string $id): ?User
    {
        return $this->model->find($id);
    }

    /**
     * Find user by email
     */
    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * Delete user
     */
    public function delete(int $id): bool
    {
        $user = $this->model->find($id);

        if (!$user) {
            return false;
        }

        $this->clearCache();
        return $user->delete();
    }

    /**
     * Legacy method for backward compatibility
     */
    public function deleteUser(string $id): bool
    {
        return $this->delete((int)$id);
    }

    /**
     * Filter users by role and search
     */
    public function filterUsers(?string $role = null, ?string $search = null, int $page = 1, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->query();

        if ($role) {
            $query->where('role', $role);
        }

        if ($search) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Clear related cache
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY . '*');
    }
}
