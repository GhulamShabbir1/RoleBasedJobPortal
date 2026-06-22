<?php

namespace App\DTOs\User;

use Illuminate\Http\Request;

class GetUserDTO
{
    public function __construct(
        public readonly string $id,
    ) {
    }

    /**
     * Create DTO from validated request data
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->route('id'),
        );
    }

    /**
     * Convert DTO to array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
        ];
    }
}
