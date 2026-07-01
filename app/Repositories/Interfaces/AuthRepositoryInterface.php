<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface AuthRepositoryInterface
{
    /**
     * Create or update user using single manage method
     */
    public function manage(array $data, ?int $id = null): User;

    /**
     * Find user by email
     */
    public function findByEmail(string $email): ?User;

    /**
     * Attempt to authenticate user and return JWT token
     */
    public function attemptLogin(array $credentials): ?string;

    /**
     * Get currently authenticated user
     */
    public function getCurrentUser(): ?User;

    /**
     * Invalidate the current JWT token
     */
    public function invalidateToken(): bool;

    /**
     * Refresh the current JWT token
     */
    public function refreshToken(): string;

    /**
     * Send password reset link to user email
     */
    public function sendPasswordResetLink(string $email): string;

    /**
     * Reset user password
     */
    public function resetUserPassword(array $data): string;

    /**
     * Change authenticated user password
     */
    public function changePassword(string $userId, string $newPassword): bool;

    /**
     * Clear related cache
     */
    public function clearCache(): void;
}
