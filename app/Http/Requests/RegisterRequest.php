<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'in:admin,employer,candidate'
        ];
    }
    public function messages()
{
    return [
        'name.required' => 'Name is required',
        'email.required' => 'Email is required',
        'email.unique' => 'Email already exists',
        'password.required' => 'Password is required',
        'role.in' => 'Role must be admin, employer, or candidate'
    ];
}

public function attributes()
{
    return [
        'name' => 'Name',
        'email' => 'Email',
        'password' => 'Password',
        'role' => 'Role'
    ];
}

public function withValidator($validator)
{
    $validator->after(function ($validator) {
        if ($this->input('role') === 'employer') {
            $validator->errors()->add(
                'role',
                'Employers cannot register directly. Contact admin for registration.'
            );
        }
    });
}
    
}