<?php

namespace App\DTOs\User;

use Illuminate\Http\Request;

class UpdateUserRoleDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $role,
    ) {
    }

    /**
     * Create DTO from validated request data
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->route('id'),
            role: $request->validated('role'),
        );
    }

    /**
     * Convert DTO to array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'role' => $this->role,
        ];
    }
}
