<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'origin_country' => 'required|regex:/^[A-Z]{2}$/',
            'destination_country' => 'required|regex:/^[A-Z]{2}$/',
            'hs_code' => 'nullable|regex:/^\d{10}$/',
            'cargo_value' => 'nullable|numeric|min:0',
            'currency' => 'nullable|regex:/^[A-Z]{3}$/',
            'arrival_ts' => 'nullable|date_format:Y-m-d\TH:i:s\Z',
            'status' => 'nullable|in:pending,processing,completed,released,held,rejected',
            'priority' => 'nullable|in:low,normal,high,critical',
        ];
    }

    public function messages(): array
    {
        return [
            'origin_country.regex' => 'Origin country must be a valid ISO 2-letter code (e.g., LV, DE)',
            'destination_country.regex' => 'Destination country must be a valid ISO 2-letter code',
            'hs_code.regex' => 'HS code must be exactly 10 digits',
            'cargo_value.numeric' => 'Cargo value must be a valid number',
            'currency.regex' => 'Currency must be a valid ISO 4217 code (e.g., EUR, USD)',
            'arrival_ts.date_format' => 'Arrival timestamp must be in ISO8601 UTC format (Y-m-d\TH:i:s\Z)',
        ];
    }
}
