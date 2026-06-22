<?php

namespace App\DTOs\Job;

use Illuminate\Http\Request;

class CreateJobDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly int $category_id,
        public readonly string $job_type,
        public readonly string $city,
        public readonly ?int $min_salary = null,
        public readonly ?int $max_salary = null,
        public readonly int $vacancies = 1,
        public readonly ?string $status = 'open',
        public readonly ?string $deadline = null,
    ) {
    }

    /**
     * Create DTO from validated request data
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            title: $request->validated('title'),
            description: $request->validated('description'),
            category_id: $request->validated('category_id'),
            job_type: $request->validated('job_type'),
            city: $request->validated('city'),
            min_salary: $request->validated('min_salary'),
            max_salary: $request->validated('max_salary'),
            vacancies: $request->validated('vacancies', 1),
            status: $request->validated('status', 'open'),
            deadline: $request->validated('deadline'),
        );
    }

    /**
     * Convert DTO to array
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'job_type' => $this->job_type,
            'city' => $this->city,
            'min_salary' => $this->min_salary,
            'max_salary' => $this->max_salary,
            'vacancies' => $this->vacancies,
            'status' => $this->status,
            'deadline' => $this->deadline,
        ];
    }
}
