<?php

namespace App\DTOs\Job;

use Illuminate\Http\Request;

class ApplyJobDTO
{
    public function __construct(
        public readonly string $job_id,
        public readonly string $resume,
        public readonly ?string $cover_letter = null,
    ) {
    }

    /**
     * Create DTO from validated request data
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            job_id: $request->validated('job_id'),
            resume: $request->validated('resume'),
            cover_letter: $request->validated('cover_letter'),
        );
    }

    /**
     * Convert DTO to array
     */
    public function toArray(): array
    {
        return [
            'job_id' => $this->job_id,
            'resume' => $this->resume,
            'cover_letter' => $this->cover_letter,
        ];
    }
}
