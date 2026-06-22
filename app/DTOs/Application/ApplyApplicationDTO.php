<?php

namespace App\DTOs\Application;

use Illuminate\Http\Request;

class ApplyApplicationDTO
{
    public function __construct(
        public readonly int $job_id,
        public readonly string $user_id,
        public readonly string $company_id,
        public readonly ?string $cover_letter = null,
        public readonly ?string $resume = null,
    ) {
    }

    /**
     * Create DTO from validated request data
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            job_id: (int) $request->validated('job_id'),
            user_id: auth()->user()->id,
            company_id: auth()->user()->company_id ?? '',
            cover_letter: $request->validated('cover_letter'),
            resume: $request->validated('resume'),
        );
    }

    /**
     * Convert DTO to array
     */
    public function toArray(): array
    {
        return [
            'job_id' => $this->job_id,
            'user_id' => $this->user_id,
            'company_id' => $this->company_id,
            'cover_letter' => $this->cover_letter,
            'resume' => $this->resume,
        ];
    }
}
