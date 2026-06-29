<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    /**
     * Get all users
     */
    public function getAllUsers(): Collection;

    /**
     * Get users by role: candidates
     */
    public function getCandidates(): Collection;

    /**
     * Get users by role: employers
     */
    public function getEmployers(): Collection;

    /**
     * Get users by role: admins
     */
    public function getAdmins(): Collection;

    /**
     * Find user by ID
     */
    public function findById(string $id): ?User;

    /**
     * Find user by email
     */
    public function findByEmail(string $email): ?User;

    /**
     * Create a new user
     */
    public function createUser(array $data): User;

    /**
     * Update user
     */
    public function updateUser(string $id, array $data): bool;

    /**
     * Delete user
     */
    public function deleteUser(string $id): bool;

    /**
     * Update user password
     */
    public function updatePassword(string $id, string $password): bool;

    /**
     * Update user role
     */
    public function updateRole(string $id, string $role): bool;

    /**
     * Filter users by role and search
     */
    public function filterUsers(?string $role = null, ?string $search = null, int $page = 1, int $perPage = 15): LengthAwarePaginator;
}
