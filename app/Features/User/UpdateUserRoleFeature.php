<?php

namespace App\Features\User;

use App\DTOs\User\UpdateUserRoleDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;

class UpdateUserRoleFeature
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * Update user role (admin only)
     *
     * @param UpdateUserRoleDTO $dto User ID and new role
     * @return User
     * @throws Exception
     */
    public function handle(UpdateUserRoleDTO $dto): User
    {
        try {
            $user = $this->userRepository->findById($dto->id);

            if (!$user) {
                throw new Exception('User not found', 404);
            }

            $this->userRepository->updateUser($dto->id, ['role' => $dto->role]);

            return $this->userRepository->findById($dto->id);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
