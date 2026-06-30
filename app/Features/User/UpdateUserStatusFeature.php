<?php

namespace App\Features\User;

use App\DTOs\User\UpdateUserStatusDTO;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;

class UpdateUserStatusFeature
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * Update user active/inactive status
     */
    public function handle(UpdateUserStatusDTO $dto): array
    {
        $user = $this->userRepository->findById($dto->id);

        if (!$user) {
            throw new Exception('User not found', 404);
        }

        $updated = $this->userRepository->updateStatus($dto->id, $dto->isActive);

        if (!$updated) {
            throw new Exception('Failed to update user status', 500);
        }

        $updatedUser = $this->userRepository->findById($dto->id);

        return [
            'id' => $updatedUser->id,
            'name' => $updatedUser->name,
            'email' => $updatedUser->email,
            'role' => $updatedUser->role,
            'is_active' => $updatedUser->is_active,
            'created_at' => $updatedUser->created_at,
        ];
    }
}
