<?php

namespace App\Http\Requests\Job;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:10000',
        'category_id' => 'nullable|exists:categories,id',
        'job_type' => 'nullable|in:full_time,part_time,remote,contract',
        'city' => 'nullable|string|max:100',
        'min_salary' => 'nullable|numeric|min:0',
        'max_salary' => 'nullable|numeric|min:0',
        'vacancies' => 'nullable|integer|min:1',
        'status' => 'nullable|in:open,closed,draft',
        'deadline' => 'nullable|date',
        ];
    }
}
