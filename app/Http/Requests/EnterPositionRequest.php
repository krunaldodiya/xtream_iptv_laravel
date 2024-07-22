<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EnterPositionRequest extends FormRequest
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
            'algo_session_id' => ['required'],
            'position_id' => ['required'],
            'broker_symbol_id' => ['required', 'exists:broker_symbols,id'],
            'position_type' => ['required'],
            'order_type' => ['required'],
            'product_type' => ['required'],
            'quantities' => ['required', 'numeric'],
            'enter_price' => ['required', 'numeric'],
            'exit_price' => ['nullable', 'numeric'],
            'status' => ['required'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = response()->json(['errors' => $validator->errors()], 422);

        throw new HttpResponseException($response);
    }
}
