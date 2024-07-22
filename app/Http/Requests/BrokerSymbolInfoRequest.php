<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BrokerSymbolInfoRequest extends FormRequest
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
        $commonRules = [
            'base_symbol_id' => ['required', 'exists:base_symbols,id'],
            'exchange' => ['required'],
            'market_type' => ['required'],
            'segment_type' => ['required'],
        ];

        $specificRules = match ($this->input('segment_type')) {
            'Equity' => [
                'expiry_date' => ['nullable'],
                'expiry_period' => ['nullable'],
                'strike_price' => ['nullable'],
                'option_type' => ['nullable'],
            ],
            'Future' => [
                'expiry_date' => ['required'],
                'expiry_period' => ['required'],
                'strike_price' => ['nullable'],
                'option_type' => ['nullable'],
            ],
            'Option' => [
                'expiry_date' => ['required'],
                'expiry_period' => ['required'],
                'strike_price' => ['required'],
                'option_type' => ['required'],
            ],
            default => [
                'expiry_date' => ['nullable'],
                'expiry_period' => ['nullable'],
                'strike_price' => ['nullable'],
                'option_type' => ['nullable'],
            ],
        };

        return array_merge($commonRules, $specificRules);
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    public function failedValidation(Validator $validator)
    {
        $response = response()->json(['errors' => $validator->errors()], 422);

        throw new HttpResponseException($response);
    }
}
