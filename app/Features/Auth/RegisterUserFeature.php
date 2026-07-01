<?php

namespace App\Features\Auth;

use App\DTOs\Auth\RegisterUserDTO;
use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;

class RegisterUserFeature
{
    public function __construct(
        private readonly AuthRepositoryInterface $authRepository
    ) {
    }

    /**
     * Execute the registration business logic using repository manage()
     */
    public function handle(RegisterUserDTO $dto): User
    {
        // Use manage() with null ID to create new user
        return $this->authRepository->manage($dto->toArray());
    }
}
