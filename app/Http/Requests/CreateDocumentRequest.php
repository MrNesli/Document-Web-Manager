<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDocumentRequest extends FormRequest
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
            'documents.*' => 'required|mimes:jpg,jpeg,png,pdf|min:1',
            'titles.*' => 'required|string|min:1',
            'categories.*' => 'required|integer|min:1',
            'current-category-id' => 'required|integer',
        ];
    }
}
