<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $this->route('id'),
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'nullable|in:admin,employer,candidate',
            'status' => 'nullable|in:active,inactive',
        ];
    }

    /**
     * Get custom messages for validation errors
     */
    public function messages(): array
    {
        return [
            'name.string' => 'Name must be a string',
            'name.max' => 'Name cannot exceed 255 characters',
            'email.email' => 'Please provide a valid email address',
            'email.unique' => 'This email is already in use',
            'password.min' => 'Password must be at least 6 characters',
            'password.confirmed' => 'Password confirmation does not match',
            'role.in' => 'Role must be admin, employer, or candidate',
            'status.in' => 'Status must be active or inactive',
        ];
    }
}
