<?php

namespace App\Features\Auth;

use App\DTOs\Auth\RegisterUserDTO;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Exception;

class RegisterUserFeature
{
    public function __construct(
        private readonly AuthRepositoryInterface $authRepository
    ) {
    }

    /**
     * Execute the registration business logic
     *
     * @throws Exception
     */
    public function handle(RegisterUserDTO $dto): array
    {
        try {
            // Create user via repository
            $user = $this->authRepository->createUser($dto->toArray());

            return [
                'user' => $user,
            ];
        } catch (Exception $e) {
            throw new Exception('User registration failed: ' . $e->getMessage());
        }
    }
}
