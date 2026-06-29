<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
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
     * Create a new user
     */
    public function createUser(array $data): User
    {
        return $this->model->create($data);
    }

    /**
     * Update user
     */
    public function updateUser(string $id, array $data): bool
    {
        $user = $this->findById($id);

        if (!$user) {
            return false;
        }

        return $user->update($data);
    }

    /**
     * Delete user
     */
    public function deleteUser(string $id): bool
    {
        $user = $this->findById($id);

        if (!$user) {
            return false;
        }

        return $user->delete();
    }

    /**
     * Update user password
     */
    public function updatePassword(string $id, string $password): bool
    {
        return $this->updateUser($id, ['password' => bcrypt($password)]);
    }

    /**
     * Update user role
     */
    public function updateRole(string $id, string $role): bool
    {
        return $this->updateUser($id, ['role' => $role]);
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
}
