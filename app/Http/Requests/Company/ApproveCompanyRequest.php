<?php

namespace App\Http\Requests\Company;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * ApproveCompanyRequest
 * Validates incoming request data for company approval
 */
class ApproveCompanyRequest extends FormRequest
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
            'company_id' => 'required|integer|exists:companies,id',
            'notes' => 'nullable|string',
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'company_id.required' => 'Company ID is required',
            'company_id.integer' => 'Company ID must be an integer',
            'company_id.exists' => 'Company does not exist',
        ];
    }

    /**
     * Custom attribute names for error messages
     */
    public function attributes(): array
    {
        return [
            'company_id' => 'Company ID',
            'notes' => 'Approval Notes',
        ];
    }
}
