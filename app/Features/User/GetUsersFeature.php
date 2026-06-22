<?php

namespace App\Features\User;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;

class GetUsersFeature
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * Get all users
     *
     * @return Collection
     * @throws Exception
     */
    public function handle(): Collection
    {
        try {
            return $this->userRepository->getAllUsers();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
