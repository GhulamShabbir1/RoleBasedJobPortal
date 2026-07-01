<?php

namespace App\Features\User;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Exceptions\ResourceNotFoundException;

class DeleteUserFeature
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * Delete a user using repository delete() method
     */
    public function handle(string $userId): bool
    {
        $user = $this->userRepository->findById($userId);

        if (!$user) {
            throw new ResourceNotFoundException('User not found');
        }

        return $this->userRepository->delete((int)$userId);
    }
}
