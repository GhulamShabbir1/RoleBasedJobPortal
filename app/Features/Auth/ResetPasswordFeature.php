<?php

namespace App\Features\Auth;

use App\DTOs\Auth\ResetPasswordDTO;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Password;

class ResetPasswordFeature
{
    public function __construct(
        private readonly AuthRepositoryInterface $authRepository
    ) {
    }

    /**
     * Execute the reset password business logic
     *
     * @throws Exception
     */
    public function handle(ResetPasswordDTO $dto): string
    {
        try {
            $status = $this->authRepository->resetUserPassword($dto->toArray());

            if ($status !== Password::PASSWORD_RESET) {
                throw new Exception('Failed to reset password');
            }

            return $status;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
