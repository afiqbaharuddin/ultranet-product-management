<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkDeleteProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ids' => 'required|array|min:1',
            'ids.*' => 'required|integer|exists:products,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'ids.required' => 'No products selected for deletion',
            'ids.array' => 'Invalid data format',
            'ids.min' => 'At least one product must be selected',
            'ids.*.exists' => 'One or more selected products do not exist',
        ];
    }
}