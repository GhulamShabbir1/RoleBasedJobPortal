<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Cache;

class AuthRepository implements AuthRepositoryInterface
{
    private const CACHE_KEY = 'auth:';
    private const CACHE_TTL = 3600;

    /**
     * Create or update user using single manage method
     * Note: Auth operations use manage() for consistency
     */
    public function manage(array $data, ?int $id = null): User
    {
        if ($id === null) {
            // Create new user (register)
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'] ?? 'candidate',
            ]);
        } else {
            // Update existing user
            $user = User::findOrFail($id);
            $updateData = $data;
            if (isset($updateData['password'])) {
                $updateData['password'] = Hash::make($updateData['password']);
            }
            $user->update($updateData);
        }

        $this->clearCache();
        return $user;
    }

    /**
     * Find user by email
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Attempt to authenticate user and return JWT token
     */
    public function attemptLogin(array $credentials): ?string
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !$user->is_active) {
            return null;
        }

        $token = auth()->attempt($credentials);

        return $token ?: null;
    }

    /**
     * Get currently authenticated user
     */
    public function getCurrentUser(): ?User
    {
        return auth()->user();
    }

    /**
     * Invalidate the current JWT token
     */
    public function invalidateToken(): bool
    {
        auth()->logout();

        return true;
    }

    /**
     * Refresh the current JWT token
     */
    public function refreshToken(): string
    {
        return auth()->refresh();
    }

    /**
     * Send password reset link to user email
     */
    public function sendPasswordResetLink(string $email): string
    {
        return Password::sendResetLink(['email' => $email]);
    }

    /**
     * Reset user password
     */
    public function resetUserPassword(array $data): string
    {
        return Password::reset(
            $data,
            function (User $user, string $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );
    }

    /**
     * Change authenticated user password
     */
    public function changePassword(string $userId, string $newPassword): bool
    {
        $user = User::findOrFail($userId);
        $user->password = Hash::make($newPassword);
        $this->clearCache();
        return $user->save();
    }

    /**
     * Clear related cache
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY . '*');
    }
}
