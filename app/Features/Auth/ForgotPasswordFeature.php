<?php

namespace App\Features\Auth;

use App\DTOs\Auth\ForgotPasswordDTO;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Password;

class ForgotPasswordFeature
{
    public function __construct(
        private readonly AuthRepositoryInterface $authRepository
    ) {
    }

    /**
     * Execute the forgot password business logic
     *
     * @throws Exception
     */
    public function handle(ForgotPasswordDTO $dto): string
    {
        try {
            $status = $this->authRepository->sendPasswordResetLink($dto->email);

            if ($status !== Password::RESET_LINK_SENT) {
                throw new Exception('Failed to send password reset link');
            }

            return $status;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
