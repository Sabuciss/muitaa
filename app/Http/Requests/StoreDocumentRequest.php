<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'broker';
    }

    public function rules(): array
    {
        return [
            'case_id' => 'required|exists:cases,id',
            'filename' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'mime_type' => 'nullable|string|max:100',
            'pages' => 'nullable|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'case_id.exists' => 'The selected case does not exist',
            'filename.required' => 'Document filename is required',
        ];
    }
}
