<?php

namespace App\Features\User;

use App\DTOs\User\UpdateUserStatusDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Exceptions\ResourceNotFoundException;

class UpdateUserStatusFeature
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * Update user active/inactive status using repository manage() method
     */
    public function handle(UpdateUserStatusDTO $dto): User
    {
        $user = $this->userRepository->findById($dto->id);

        if (!$user) {
            throw new ResourceNotFoundException('User not found');
        }

        // Use manage() method with ID for update
        return $this->userRepository->manage(['is_active' => $dto->isActive], (int)$dto->id);
    }
}
