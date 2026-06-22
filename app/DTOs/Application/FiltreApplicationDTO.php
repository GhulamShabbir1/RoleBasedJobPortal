<?php

namespace App\DTOs\Application;

use Illuminate\Http\Request;

class ApplicationFilterDTO
{
    public function __construct(
        public readonly ?string $status = null,
        public readonly ?int $job_id = null,
        public readonly ?string $user_id = null,
        public readonly ?string $company_id = null,
    ) {
    }

    /**
     * Create DTO from validated request data
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            status: $request->validated('status'),
            job_id: $request->validated('job_id'),
            user_id: $request->validated('user_id'),
            company_id: $request->validated('company_id'),
        );
    }

    /**
     * Convert DTO to array for filtering
     */
    public function toArray(): array
    {
        return array_filter([
            'status' => $this->status,
            'job_id' => $this->job_id,
            'user_id' => $this->user_id,
            'company_id' => $this->company_id,
        ], fn($value) => $value !== null);
    }
}
