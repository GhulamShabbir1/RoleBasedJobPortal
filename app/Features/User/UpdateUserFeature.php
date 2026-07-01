<?php

namespace App\Features\User;

use App\DTOs\User\UpdateUserDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Exceptions\ResourceNotFoundException;

class UpdateUserFeature
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * Update user profile using repository manage() method
     */
    public function handle(UpdateUserDTO $dto): User
    {
        // Verify user exists
        $user = $this->userRepository->findById($dto->id);
        if (!$user) {
            throw new ResourceNotFoundException('User not found');
        }

        $data = $dto->toArray();

        // Use manage() method with ID for update
        return $this->userRepository->manage($data, (int)$dto->id);
    }
}
