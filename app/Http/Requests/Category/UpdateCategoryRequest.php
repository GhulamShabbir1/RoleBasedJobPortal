<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255|unique:categories,name,' . $this->route('id'),
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50',
        ];
    }

    /**
     * Get custom messages for validation errors
     */
    public function messages(): array
    {
        return [
            'name.unique' => 'This category name already exists',
            'name.max' => 'Category name cannot exceed 255 characters',
            'description.max' => 'Description cannot exceed 500 characters',
            'icon.max' => 'Icon name cannot exceed 50 characters',
        ];
    }
}
