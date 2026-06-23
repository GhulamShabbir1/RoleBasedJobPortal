<?php

namespace App\Http\Requests\Job;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ApplyJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only candidates (job seekers) can apply
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
            'job_id' => [
                'required',
                'integer',
                'exists:jobs,id'
            ],
            'resume' => [
                'required',
                'file',
                'mimes:pdf,doc,docx',
                'max:5120', // 5MB in kilobytes
                'mime_types:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ],
            'cover_letter' => [
                'nullable',
                'string',
                'max:5000'
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'job_id.required' => 'Job ID is required.',
            'job_id.integer' => 'Job ID must be a valid integer.',
            'job_id.exists' => 'The selected job does not exist.',
            'resume.required' => 'Resume file is required.',
            'resume.file' => 'Resume must be a valid file.',
            'resume.mimes' => 'Resume must be in PDF or DOCX format.',
            'resume.max' => 'Resume file must not exceed 5MB.',
            'resume.mime_types' => 'Resume file format is invalid. Please upload PDF or DOCX.',
            'cover_letter.string' => 'Cover letter must be text.',
            'cover_letter.max' => 'Cover letter must not exceed 5000 characters.',
        ];
    }
}
