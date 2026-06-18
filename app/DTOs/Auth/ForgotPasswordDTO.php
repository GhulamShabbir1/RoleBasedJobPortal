<?php

namespace App\DTOs\Auth;

use Illuminate\Http\Request;

class ForgotPasswordDTO
{
    public function __construct(
        public readonly string $email
    ) {
    }

    /**
     * Create DTO from validated request data
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            email: $request->validated('email')
        );
    }
}
