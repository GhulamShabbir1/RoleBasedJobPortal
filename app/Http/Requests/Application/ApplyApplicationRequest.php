<?php

namespace App\Http\Requests\Application;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ApplyApplicationRequest extends FormRequest
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
            'job_id' => 'required|exists:jobs,id',
            'cover_letter' => 'nullable|string|max:5000',
            'resume' => 'nullable|string|max:5000',
        ];
    }

    public function messages(): array
    {
        return [
            'job_id.required' => 'Job ID is required',
            'job_id.exists' => 'The selected job does not exist',
        ];
    }
}
