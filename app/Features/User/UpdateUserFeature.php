<?php

namespace App\Features\User;

use App\DTOs\User\UpdateUserDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;

class UpdateUserFeature
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * Update user profile
     *
     * @param UpdateUserDTO $dto Updated user data
     * @return User
     * @throws Exception
     */
    public function handle(UpdateUserDTO $dto): User
    {
        try {
            $user = $this->userRepository->findById($dto->id);

            if (!$user) {
                throw new Exception('User not found', 404);
            }

            $data = $dto->toArray();

            if (!empty($data)) {
                $this->userRepository->updateUser($dto->id, $data);
            }

            return $this->userRepository->findById($dto->id);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
