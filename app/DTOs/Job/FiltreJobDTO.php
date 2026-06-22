<?php

namespace App\DTOs\Job;

use Illuminate\Http\Request;

class FiltreJobDTO
{
    public function __construct(
        public readonly ?string $search = null,
        public readonly ?int $category_id = null,
        public readonly ?string $job_type = null,
        public readonly ?string $city = null,
        public readonly ?int $min_salary = null,
        public readonly ?int $max_salary = null,
        public readonly ?string $status = 'open',
        public readonly int $per_page = 15,
        public readonly int $page = 1,
    ) {
    }

    /**
     * Create DTO from validated request data
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            search: $request->input('search'),
            category_id: $request->input('category_id'),
            job_type: $request->input('job_type'),
            city: $request->input('city'),
            min_salary: $request->input('min_salary'),
            max_salary: $request->input('max_salary'),
            status: $request->input('status', 'open'),
            per_page: $request->input('per_page', 15),
            page: $request->input('page', 1),
        );
    }

    /**
     * Convert DTO to array
     */
    public function toArray(): array
    {
        return [
            'search' => $this->search,
            'category_id' => $this->category_id,
            'job_type' => $this->job_type,
            'city' => $this->city,
            'min_salary' => $this->min_salary,
            'max_salary' => $this->max_salary,
            'status' => $this->status,
            'per_page' => $this->per_page,
            'page' => $this->page,
        ];
    }
}
