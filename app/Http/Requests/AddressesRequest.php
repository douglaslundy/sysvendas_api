<?php

namespace App\Http\Requests;

use App\Rules\IfInClients;
use Illuminate\Foundation\Http\FormRequest;

class AddressesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'city' => ['required', 'string', 'max:50'],
            'street' => ['required', 'string', 'max:100'],
            'number' => ['required', 'string', 'max:6'],
            'zip_code' => ['nullable', 'string', 'max:10'],
            'district' => ['required', 'string', 'max:100'],
            'complement' => ['nullable', 'string', 'max:50'],
            'id_client' => ['required', 'integer', new IfInClients],
            'active' => ['sometimes', 'boolean'],
        ];
    }
}
