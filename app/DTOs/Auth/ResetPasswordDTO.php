<?php

namespace App\DTOs\Auth;

use Illuminate\Http\Request;

class ResetPasswordDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $passwordConfirmation,
        public readonly string $token
    ) {
    }

    /**
     * Create DTO from validated request data
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            email: $request->validated('email'),
            password: $request->validated('password'),
            passwordConfirmation: $request->validated('password_confirmation'),
            token: $request->validated('token')
        );
    }

    /**
     * Convert to array for password reset
     */
    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->passwordConfirmation,
            'token' => $this->token,
        ];
    }
}
