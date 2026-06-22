<?php

namespace App\Http\Requests\CandidateProfile;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCandidateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'candidate';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bio' => 'nullable|string|max:1000',
            'skills' => 'nullable|string|max:500',
            'experience' => 'nullable|string|max:2000',
            'education' => 'nullable|string|max:1000',
            'resume_url' => 'nullable|url|max:255',
            'portfolio_url' => 'nullable|url|max:255',
        ];
    }

    /**
     * Get custom messages for validation errors
     */
    public function messages(): array
    {
        return [
            'bio.max' => 'Bio cannot exceed 1000 characters',
            'skills.max' => 'Skills cannot exceed 500 characters',
            'experience.max' => 'Experience cannot exceed 2000 characters',
            'education.max' => 'Education cannot exceed 1000 characters',
            'resume_url.url' => 'Resume URL must be a valid URL',
            'portfolio_url.url' => 'Portfolio URL must be a valid URL',
        ];
    }
}
