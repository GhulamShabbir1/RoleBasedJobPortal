<?php

namespace App\Features\Auth;

use App\Repositories\Interfaces\AuthRepositoryInterface;
use Exception;

class ChangePasswordFeature
{
    public function __construct(
        private readonly AuthRepositoryInterface $authRepository
    ) {
    }

    public function handle(string $currentPassword, string $newPassword): bool
    {
        $user = $this->authRepository->getCurrentUser();

        if (!$user) {
            throw new Exception('User not authenticated', 401);
        }

        if (!password_verify($currentPassword, $user->password)) {
            throw new Exception('Current password is incorrect', 400);
        }

        $updated = $this->authRepository->changePassword(
            (string) $user->id,
            $newPassword
        );

        if (!$updated) {
            throw new Exception('Failed to update password', 500);
        }

        return true;
    }
}
