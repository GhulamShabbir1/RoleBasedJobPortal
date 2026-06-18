<?php

namespace App\Features\Auth;

use App\Repositories\Interfaces\AuthRepositoryInterface;
use Exception;

class LogoutUserFeature
{
    public function __construct(
        private readonly AuthRepositoryInterface $authRepository
    ) {
    }

    /**
     * Execute the logout business logic
     *
     * @throws Exception
     */
    public function handle(): bool
    {
        try {
            return $this->authRepository->invalidateToken();
        } catch (Exception $e) {
            throw new Exception('Logout failed: ' . $e->getMessage());
        }
    }
}
