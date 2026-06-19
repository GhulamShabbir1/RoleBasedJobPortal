<?php

namespace App\DTOs\Company;

use Illuminate\Http\Request;

/**
 * ApproveCompanyDTO
 * Data Transfer Object for approving a company registration
 *
 * Encapsulates the data required for company approval by admin,
 * including company identification and optional approval notes.
 */
class ApproveCompanyDTO
{
    public function __construct(
        public readonly int $company_id,
        public readonly ?string $notes = null
    ) {
    }

    /**
     * Create DTO from validated request data
     *
     * @param Request $request The HTTP request containing validated approval data
     * @return self A new instance of ApproveCompanyDTO
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            company_id: (int) $request->validated('company_id'),
            notes: $request->validated('notes')
        );
    }

    /**
     * Convert DTO to array for database operations
     *
     * @return array Data ready for database operations
     */
    public function toArray(): array
    {
        return [
            'company_id' => $this->company_id,
            'notes' => $this->notes,
        ];
    }
}
