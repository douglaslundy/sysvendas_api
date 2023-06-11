<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckIfFullName;
use Illuminate\Validation\Rule;

class CompaniesRequest extends FormRequest
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
            'fantasy_name' => ['required', 'string', 'max:100', new CheckIfFullName],
            'corporate_name' => ['required', 'string', 'max:100'],
            'cnpj' => ['string', 'max:18'],
            'ie' => ['unique:companies','string', 'max:18', 'nullable'],
            'im' => ['unique:companies','string', 'max:18', 'nullable'],
            'balance' => ['integer', 'nullable'],
            'validity_date' => ['date', 'nullable'],
            'active' => ['boolean', 'nullable'],
            'city' => ['string', 'max:50'],
            'street' => ['string', 'max:100'],
            'number' => ['max:10'],
            'zip_code' => ['nullable', 'string', 'max:10'],
            'district' => ['string', 'max:100'],
            'complement' => ['nullable', 'string', 'max:50'],
        ];

        if ($this->method() === 'PUT') {
            $rules['cnpj'][] = Rule::unique('companies', 'cnpj')->ignore($this->id)->where(function ($query) {
                return $query->where(function ($q) {
                    $q->where('active', 1);
                })->orWhereNull('active');
            });
        } else {
            $rules['cnpj'] = ['string', 'max:18', Rule::unique('companies', 'cnpj')->ignore(request()->id)->where(function ($query) {
                return $query->where(function ($q) {
                    $q->where('active', 1);
                })->orWhereNull('active');
            })];
        }

        return $rules;
    }
}






















// <?php

// namespace App\Http\Requests;

// use Illuminate\Foundation\Http\FormRequest;
// use App\Rules\CheckIfFullName;

// class CompaniesRequest extends FormRequest
// {
//     /**
//      * Determine if the user is authorized to make this request.
//      *
//      * @return bool
//      */
//     public function authorize()
//     {
//         return true;
//     }

//     /**
//      * Get the validation rules that apply to the request.
//      *
//      * @return array
//      */
//     public function rules()
//     {
//         return [
//             'fantasy_name' => ['required', 'string', 'max:100', new CheckIfFullName],
//             'corporate_name' => ['required', 'string', 'max:100'],
//             'cnpj' => ['string', 'max:18', 'unique:companies'],
//             'ie' => ['unique:companies','string', 'max:18', 'nullable'],
//             'im' => ['unique:companies','string', 'max:18', 'nullable'],
//             'balance' => ['integer', 'nullable'],
//             'validity_date' => ['date', 'nullable'],
//             'active' => ['boolean', 'nullable'],
//         ];
//     }
// }
