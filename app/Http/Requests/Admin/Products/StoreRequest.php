<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'category_id' => 'required|numeric|exists:categories,id',
            'price' => 'required|numeric',
            'thumbnail_url' => 'required|image|mimes:jpeg,png,jpg,gif',
            'demo_url' => 'required|image|mimes:jpeg,png,jpg,gif',
            'source_url' => 'required|image|mimes:jpeg,png,jpg,gif',
            'description' => 'required|string',
        ];
    }
}
