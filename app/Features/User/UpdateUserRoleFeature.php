<?php

namespace App\Features\User;

use App\DTOs\User\UpdateUserRoleDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Exceptions\ResourceNotFoundException;

class UpdateUserRoleFeature
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * Update user role using repository manage() method
     */
    public function handle(UpdateUserRoleDTO $dto): User
    {
        $user = $this->userRepository->findById($dto->id);

        if (!$user) {
            throw new ResourceNotFoundException('User not found');
        }

        // Use manage() method with ID for update
        return $this->userRepository->manage(['role' => $dto->role], (int)$dto->id);
    }
}
