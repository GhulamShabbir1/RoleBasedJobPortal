<?php

namespace App\DTOs\CandidateProfile;

use Illuminate\Http\Request;

class UpdateCandidateProfileDTO
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $bio = null,
        public readonly ?string $phone = null,
        public readonly ?string $city = null,
        public readonly ?string $skills = null,
        public readonly ?string $experience = null,
        public readonly ?string $education = null,
        public readonly ?string $resume_url = null,
        public readonly ?string $portfolio_url = null,
    ) {
    }

    /**
     * Create DTO from validated request data
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->route('id'),
            bio: $request->validated('bio'),
            phone: $request->validated('phone'),
            city: $request->validated('city'),
            skills: $request->validated('skills'),
            experience: $request->validated('experience'),
            education: $request->validated('education'),
            resume_url: $request->validated('resume_url'),
            portfolio_url: $request->validated('portfolio_url'),
        );
    }

    public static function fromArray(string $id, array $data): self
    {
        return new self(
            id: $id,
            bio: $data['bio'] ?? null,
            phone: $data['phone'] ?? null,
            city: $data['city'] ?? null,
            skills: $data['skills'] ?? null,
            experience: $data['experience'] ?? null,
            education: $data['education'] ?? null,
            resume_url: $data['resume_url'] ?? null,
            portfolio_url: $data['portfolio_url'] ?? null,
        );
    }

    /**
     * Convert DTO to array
     */
    public function toArray(): array
    {
        $data = [];
        if ($this->bio !== null) {
            $data['bio'] = $this->bio;
        }
        if ($this->phone !== null) {
            $data['phone'] = $this->phone;
        }
        if ($this->city !== null) {
            $data['city'] = $this->city;
        }
        if ($this->skills !== null) {
            $data['skills'] = $this->skills;
        }
        if ($this->experience !== null) {
            $data['experience'] = $this->experience;
        }
        if ($this->education !== null) {
            $data['education'] = $this->education;
        }
        if ($this->resume_url !== null) {
            $data['resume_url'] = $this->resume_url;
        }
        if ($this->portfolio_url !== null) {
            $data['portfolio_url'] = $this->portfolio_url;
        }
        return $data;
    }
}
