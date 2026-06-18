<?php

namespace App\DTOs\Auth;

use Illuminate\Http\Request;

class LoginUserDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {
    }

    /**
     * Create DTO from validated request data
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            email: $request->validated('email'),
            password: $request->validated('password')
        );
    }

    /**
     * Get credentials as array for authentication
     */
    public function toCredentials(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
