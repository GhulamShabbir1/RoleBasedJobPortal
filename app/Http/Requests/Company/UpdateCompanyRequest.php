<?php

namespace App\Http\Requests\Company;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * UpdateCompanyRequest
 * Validates incoming request data for company updates
 * All fields are optional (sometimes) to allow partial updates
 */
class UpdateCompanyRequest extends FormRequest
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
        $companyId = $this->route('id') ?? $this->input('company_id');

        return [
            'name' => 'sometimes|string|max:255|unique:companies,name,' . $companyId,
            'email' => 'sometimes|email|unique:companies,email,' . $companyId,
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'name.unique' => 'Company name already exists',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Company email already exists',
            'website.url' => 'Website must be a valid URL',
            'phone.max' => 'Phone number cannot exceed 20 characters',
        ];
    }

    /**
     * Custom attribute names for error messages
     */
    public function attributes(): array
    {
        return [
            'name' => 'Company Name',
            'email' => 'Company Email',
            'description' => 'Description',
            'website' => 'Website',
            'phone' => 'Phone',
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
        ];
    }
}
