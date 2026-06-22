<?php

namespace App\Features\User;

use App\DTOs\User\GetUserDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;

class GetUserFeature
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * Get a single user by ID
     *
     * @param GetUserDTO $dto User ID
     * @return User
     * @throws Exception
     */
    public function handle(GetUserDTO $dto): User
    {
        try {
            $user = $this->userRepository->findById($dto->id);

            if (!$user) {
                throw new Exception('User not found', 404);
            }

            return $user;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
