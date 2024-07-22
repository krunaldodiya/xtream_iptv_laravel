<?php

namespace App\Http\Requests;

use App\Models\AvailableBroker;
use Illuminate\Foundation\Http\FormRequest;

class AddBrokerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function get_rules_by_broker($broker): array
    {
        $rules = [
            'fyers' => [
                'uid' => ["required"],
                'client_id' => ["required"],
                'totp_key' => ["required"],
                'pin' => ["required"],
                'api_key' => ["required"],
                'api_secret' => ["required"],
            ],

            'angel-one' => [
                'uid' => ["required"],
                'client_id' => ["required"],
                'totp_key' => ["required"],
                'pin' => ["required"],
                'api_key' => ["required"],
                'api_secret' => ["required"],
            ],

            'shoonya' => [
                'uid' => ["required"],
                'client_id' => ["required"],
                'totp_key' => ["required"],
                'pin' => ["required"],
                'api_key' => ["required"],
                'api_secret' => ["required"],
            ],
        ];

        return $rules[$broker];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $available_broker = AvailableBroker::find($this->route('broker_id'));

        return $this->get_rules_by_broker($available_broker->title);
    }
}
