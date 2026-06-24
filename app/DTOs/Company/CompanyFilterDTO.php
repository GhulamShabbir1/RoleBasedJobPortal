<?php

namespace App\DTOs\Company;

use Illuminate\Http\Request;

class CompanyFilterDTO
{
    public function __construct(
        public ?string $search = null,
        public ?string $status = null,
        public ?string $city = null,
        public ?int $per_page = 15,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            search: $request->input('search'),
            status: $request->input('status'),
            city: $request->input('city'),
            per_page: $request->input('per_page', 15),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'search' => $this->search,
            'status' => $this->status,
            'city' => $this->city,
        ], fn($value) => $value !== null);
    }
}
