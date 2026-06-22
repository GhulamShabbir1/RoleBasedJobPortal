<?php

namespace App\DTOs\Category;

use Illuminate\Http\Request;

class UpdateCategoryDTO
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $name = null,
        public readonly ?string $description = null,
        public readonly ?string $icon = null,
    ) {
    }

    /**
     * Create DTO from validated request data
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->route('id'),
            name: $request->validated('name'),
            description: $request->validated('description'),
            icon: $request->validated('icon'),
        );
    }

    /**
     * Convert DTO to array
     */
    public function toArray(): array
    {
        $data = [];
        if ($this->name !== null) {
            $data['name'] = $this->name;
        }
        if ($this->description !== null) {
            $data['description'] = $this->description;
        }
        if ($this->icon !== null) {
            $data['icon'] = $this->icon;
        }
        return $data;
    }
}
