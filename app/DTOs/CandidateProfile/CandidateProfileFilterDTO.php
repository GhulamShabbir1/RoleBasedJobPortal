<?php

namespace App\DTOs\CandidateProfile;

use Illuminate\Http\Request;

class CandidateProfileFilterDTO
{
    public function __construct(
        public readonly ?string $search = null,
        public readonly ?string $skills = null,
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
            skills: $request->validated('skills'),
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
            'skills' => $this->skills,
            'page' => $this->page,
            'per_page' => $this->perPage,
        ];
    }
}
