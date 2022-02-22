<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckIfFullName;

class CompanyRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100', new CheckIfFullName],
            'social' => ['required', 'string', 'max:100'],
            'cnpj_cpj' => ['string', 'max:18', 'unique:company', 'nullable'],
            'ie' => ['unique:company','string', 'max:18', 'nullable'],
            'im' => ['unique:company','string', 'max:18', 'nullable'],
            'balance' => ['integer', 'nullable'],
            'validate' => ['date', 'nullable'],
            'active' => ['boolean', 'nullable'],
        ];
    }
}
