<?php

namespace App\Features\Auth;

use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Exception;

class GetAuthenticatedUserFeature
{
    public function __construct(
        private readonly AuthRepositoryInterface $authRepository
    ) {
    }

    /**
     * Execute the get authenticated user business logic
     *
     * @throws Exception
     */
    public function handle(): User
    {
        try {
            $user = $this->authRepository->getCurrentUser();

            if (!$user) {
                throw new Exception('User not authenticated');
            }

            return $user;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
