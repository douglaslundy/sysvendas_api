<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PhoneValidation;
use App\Rules\CheckIfFullName;

class ClientRequest extends FormRequest
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
             'full_name' => [new CheckIfFullName,'string', 'required','min:5','max:100'],
             'surname' => 'nullable|string|max:50',
             'cpf_cnpj' => 'string|nullable|unique:clients,cpf_cnpj,'.request()->id, 'max:18',
             'email' =>['string','nullable','email', 'max:100'],
             'phone' => [new PhoneValidation],
             'im' => 'string|max:50|nullable|unique:clients,im,'.request()->id,
             'ie' => 'string|max:50|nullable|unique:clients,ie,'.request()->id,
             'fantasy_name' => ['string','nullable', 'max:50'],
             'obs' => ['string','nullable', 'max:500'],
             'active' => ['Boolean'],
             'inactive_date' => ['nullable', 'date'],
             'debit_balance' => ['nullable', 'integer'],
             'limit' => ['nullable', 'integer'],
             'marked' => ['nullable','Boolean'],
             //  'im' => ['string','nullable', 'unique:clients', 'max:50'],
            //  'ie' => ['string','nullable', 'unique:clients', 'max:50'],
            //  'cpf_cnpj' => ['nullable','string','unique:clients', 'max:18'],
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'o Campo nome e obrigatorio',
            'full_name.min' =>'O Nome deve possuir no minimo 5 letras',
            'im.max' =>'O campo Inscrição Municipal não pode conter mais que 50 caracteres',
            'ie.max' =>'O campo Inscrição Estadual não pode conter mais que 50 caracteres',
        ];
    }
}
