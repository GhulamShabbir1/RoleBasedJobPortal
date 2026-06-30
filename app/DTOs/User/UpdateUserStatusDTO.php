<?php

namespace App\DTOs\User;

use Illuminate\Http\Request;

class UpdateUserStatusDTO
{
    public function __construct(
        public string $id,
        public bool $isActive,
    ) {
    }

    public static function fromRequest(Request $request, string $id): self
    {
        return new self(
            id: $id,
            isActive: $request->boolean('is_active', true),
        );
    }
}
