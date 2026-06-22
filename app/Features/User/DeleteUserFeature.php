<?php

namespace App\Features\User;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;

class DeleteUserFeature
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * Delete a user (admin only)
     *
     * @param string $userId User ID to delete
     * @return bool
     * @throws Exception
     */
    public function handle(string $userId): bool
    {
        try {
            $user = $this->userRepository->findById($userId);

            if (!$user) {
                throw new Exception('User not found', 404);
            }

            return $this->userRepository->deleteUser($userId);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
