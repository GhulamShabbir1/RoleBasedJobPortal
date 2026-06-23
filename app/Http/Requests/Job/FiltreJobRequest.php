<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FiltreJobRequest extends FormRequest
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
            'city' => 'nullable|string|max:100',
            'job_type' => 'nullable|in:full_time,part_time,contract,temporary,internship,other',
            'category_id' => 'nullable|exists:categories,id',
            'min_salary' => 'nullable|numeric|min:0',
            'max_salary' => 'nullable|numeric|min:0',
            'search' => 'nullable|string|max:255',
            'page' => 'nullable|integer|min:1|max:10000',
            'per_page' => 'nullable|integer|min:1|max:100',
        ];
    }
}
