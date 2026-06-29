<?php

namespace App\DTOs\Auth;

use Illuminate\Http\Request;

class ChangePasswordDTO
{
    public function __construct(
        public readonly string $currentPassword,
        public readonly string $newPassword
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            currentPassword: $request->validated('current_password'),
            newPassword: $request->validated('new_password')
        );
    }
}
