<?php

namespace App\Features\Auth;

use App\Repositories\Interfaces\AuthRepositoryInterface;
use Exception;

class RefreshTokenFeature
{
    public function __construct(
        private readonly AuthRepositoryInterface $authRepository
    ) {
    }

    /**
     * Execute the token refresh business logic
     *
     * @throws Exception
     */
    public function handle(): string
    {
        try {
            return $this->authRepository->refreshToken();
        } catch (Exception $e) {
            throw new Exception('Token refresh failed: ' . $e->getMessage());
        }
    }
}
