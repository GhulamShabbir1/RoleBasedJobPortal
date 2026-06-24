<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ApplyJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Candidate authorization is handled via route middleware (role:candidate)
        return true;
    }

    public function rules(): array
    {
        return [
            'job_id' => 'required|exists:jobs,id',
            // Spec: resume (PDF/DOCX) is required for every application
            'resume' => [
                'required',
                'file',
                'mimes:pdf,doc,docx',
                'max:5120', // 5MB
            ],
            'cover_letter' => 'nullable|string|max:5000',
        ];
    }

    public function messages(): array
    {
        return [
            'job_id.required' => 'Job ID is required',
            'job_id.exists' => 'The selected job does not exist',
            'resume.required' => 'Resume file is required',
            'resume.file' => 'Resume must be a file',
            'resume.mimes' => 'Resume must be PDF or DOCX format',
            'resume.max' => 'Resume must be less than 5MB',
        ];
    }
}

