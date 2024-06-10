<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'sometimes|string|regex:/^[a-zA-Z\s]+$/|max:255|min:3',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'image' => 'sometimes|image|mimes:jpg,png|max:2048',
            'stock' => 'sometimes|required|integer',
            'categories' => 'sometimes|array',
            'categories.*' => 'integer|exists:categories,id',
            'attributes' => 'array',
            'attributes.*.id' => 'required|integer|exists:attributes,id',
            'attributes.*.value' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:255|min:3',
        ];
    }
}
