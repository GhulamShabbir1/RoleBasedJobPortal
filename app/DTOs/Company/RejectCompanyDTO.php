<?php

namespace App\DTOs\Company;

use Illuminate\Http\Request;

/**
 * RejectCompanyDTO
 * Data Transfer Object for rejecting a company registration
 *
 * Encapsulates the data required for company rejection by admin,
 * including company identification and rejection reason.
 */
class RejectCompanyDTO
{
    public function __construct(
        public readonly int $company_id,
        public readonly string $reason
    ) {
    }

    /**
     * Create DTO from validated request data
     *
     * @param Request $request The HTTP request containing validated rejection data
     * @return self A new instance of RejectCompanyDTO
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            company_id: (int) $request->validated('company_id'),
            reason: $request->validated('reason')
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
            'reason' => $this->reason,
        ];
    }
}
