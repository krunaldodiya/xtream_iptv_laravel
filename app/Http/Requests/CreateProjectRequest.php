<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
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
            'broker_id' => ['required', 'exists:brokers,id'],
            'data_broker_id' => ['required', 'exists:brokers,id'],
            'github_repository_id' => ['required', 'exists:brokers,id'],
            'title' => ['required', 'min:4', 'max:20'],
            'description' => ['required', 'min:10', 'max:512'],
        ];
    }
}
