<?php

namespace App\Http\Requests;

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
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:10000',
        'category_id' => 'required|exists:categories,id',
        'job_type' => 'required|in:full_time,part_time,contract,temporary,internship,other',
        'city' => 'required|string|max:100',
        'min_salary' => 'nullable|numeric|min:0',
        'max_salary' => 'nullable|numeric|min:0',
        'vacancies' => 'required|integer|min:1',
        'status' => 'in:open,closed,draft',
        'deadline' => 'nullable|date',
        ];
    }
}
