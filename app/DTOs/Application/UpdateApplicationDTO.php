<?php

namespace App\DTOs\Application;

use Illuminate\Http\Request;

class UpdateApplicationStatusDTO
{
    public function __construct(
        public readonly string $status
    ) {
    }

    /**
     * Create DTO from validated request data
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            status: $request->validated('status'),
        );
    }

    /**
     * Convert DTO to array
     */
    public function toArray(): array
    {
        return [
            'status' => $this->status,
        ];
    }
}
