<?php

namespace App\Features\User;

use App\DTOs\User\UserFilterDTO;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

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
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function handle(UserFilterDTO $dto): LengthAwarePaginator
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
