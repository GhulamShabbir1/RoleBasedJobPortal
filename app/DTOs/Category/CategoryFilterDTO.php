<?php

namespace App\DTOs\Category;

use Illuminate\Http\Request;

class CategoryFilterDTO
{
    public function __construct(
        public readonly ?string $search = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
    ) {
    }

    /**
     * Create DTO from validated request data
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            search: $request->validated('search'),
            page: (int) $request->validated('page', 1),
            perPage: (int) $request->validated('per_page', 15),
        );
    }

    /**
     * Convert DTO to array
     */
    public function toArray(): array
    {
        return [
            'search' => $this->search,
            'page' => $this->page,
            'per_page' => $this->perPage,
        ];
    }
}
