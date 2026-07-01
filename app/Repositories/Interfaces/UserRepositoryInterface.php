<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    /**
     * Create or update user using single manage method
     */
    public function manage(array $data, ?int $id = null): User;

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
     * Delete user
     */
    public function delete(int $id): bool;

    /**
     * Delete user (legacy)
     */
    public function deleteUser(string $id): bool;

    /**
     * Filter users by role and search
     */
    public function filterUsers(?string $role = null, ?string $search = null, int $page = 1, int $perPage = 15): LengthAwarePaginator;

    /**
     * Clear related cache
     */
    public function clearCache(): void;
}

