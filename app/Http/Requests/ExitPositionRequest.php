<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ExitPositionRequest extends FormRequest
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
            'position_id' => ['required', 'exists:positions,position_id'],
            'quantities' => ['required', 'numeric'],
            'exit_price' => ['required', 'numeric'],
            'status' => ['required'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = response()->json(['errors' => $validator->errors()], 422);

        throw new HttpResponseException($response);
    }
}
