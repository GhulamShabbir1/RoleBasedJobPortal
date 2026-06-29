<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthRepository implements AuthRepositoryInterface
{
    /**
     * Create a new user in the database
     */
    public function createUser(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'] ?? 'candidate',
        ]);
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
        return $user->save();
    }
}
