<?php

namespace App\DTOs\Job;

use App\Models\Job;

class JobDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public int $category_id,
        public string $job_type,
        public string $city,
        public ?float $min_salary,
        public ?float $max_salary,
        public int $vacancies,
        public string $status,
        public ?string $deadline,
        public ?string $company_name,
        public int $user_id,
        public ?string $created_at,
        public ?string $updated_at
    ) {}

    public static function fromModel(Job $job): self
    {
        return new self(
            id: $job->id,
            title: $job->title,
            description: $job->description,
            category_id: $job->category_id,
            job_type: $job->job_type,
            city: $job->city,
            min_salary: $job->min_salary,
            max_salary: $job->max_salary,
            vacancies: $job->vacancies,
            status: $job->status,
            deadline: $job->deadline,
            company_name: $job->company_name ?? $job->company?->name ?? null,
            user_id: $job->user_id,
            created_at: $job->created_at?->toIso8601String(),
            updated_at: $job->updated_at?->toIso8601String()
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
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
            'company_name' => $this->company_name,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
