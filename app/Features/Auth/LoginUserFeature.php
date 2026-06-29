<?php

namespace App\Features\Auth;

use App\DTOs\Auth\LoginUserDTO;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Exception;

class LoginUserFeature
{
    public function __construct(
        private readonly AuthRepositoryInterface $authRepository
    ) {
    }

    /**
     * Execute the login business logic
     *
     * @throws Exception
     */
    public function handle(LoginUserDTO $dto): array
    {
        try {
            // Attempt login via repository
            $token = $this->authRepository->attemptLogin($dto->toCredentials());

            if (!$token) {
                throw new Exception('Invalid credentials provided');
            }

            // Get authenticated user
            $user = $this->authRepository->getCurrentUser();

            // If employer, include company status in response for UI routing
            $companyStatus = null;
            if ($user->role === 'employer') {
                $company = \App\Models\Company::where('user_id', $user->id)->first();
                $companyStatus = [
                    'has_company' => $company !== null,
                    'status' => $company?->status ?? 'no_company',
                ];
            }

            return [
                'user' => $user,
                'token' => $token,
                'company_status' => $companyStatus,
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }
}
