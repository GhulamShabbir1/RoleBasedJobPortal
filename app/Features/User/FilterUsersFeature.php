<?php

namespace App\Features\User;

use App\DTOs\User\UserFilterDTO;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Pagination\Paginator;

class FilterUsersFeature
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * Filter users by role, search, and pagination
     *
     * @param UserFilterDTO $dto Filter criteria
     * @return Paginator
     * @throws Exception
     */
    public function handle(UserFilterDTO $dto): Paginator
    {
        try {
            return $this->userRepository->filterUsers(
                role: $dto->role,
                search: $dto->search,
                page: $dto->page,
                perPage: $dto->perPage
            );
        } catch (Exception $e) {
            throw $e;
        }
    }
}
