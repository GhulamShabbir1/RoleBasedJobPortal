<?php

namespace App\DTOs\CandidateProfile;

use Illuminate\Http\Request;

class CreateCandidateProfileDTO
{
    public function __construct(
        public readonly string $user_id,
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
            user_id: auth()->id(),
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

    public static function fromArray(string $userId, array $data): self
    {
        return new self(
            user_id: $userId,
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
        return [
            'user_id' => $this->user_id,
            'bio' => $this->bio,
            'phone' => $this->phone,
            'city' => $this->city,
            'skills' => $this->skills,
            'experience' => $this->experience,
            'education' => $this->education,
            'resume_url' => $this->resume_url,
            'portfolio_url' => $this->portfolio_url,
        ];
    }
}
