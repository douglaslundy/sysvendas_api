<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PhoneValidation;
use App\Rules\CheckIfFullName;
use Illuminate\Validation\Rule;

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
        $rules = [
            'full_name' => [new CheckIfFullName, 'string', 'required', 'min:5', 'max:100'],
            'surname' => 'nullable|string|max:50',
            'cpf_cnpj' => ['required', 'string', 'max:18'],
            'email' => ['nullable', 'string', 'email', 'max:100'],
            'phone' => [new PhoneValidation],
            'im' => 'nullable|string|max:50',
            'ie' => 'nullable|string|max:50',
            'fantasy_name' => ['nullable', 'string', 'max:50'],
            'obs' => ['nullable', 'string', 'max:500'],
            'active' => ['boolean'],
            'inactive_date' => ['nullable', 'date'],
            'debit_balance' => ['nullable', 'integer'],
            'limit' => ['nullable', 'integer'],
            'marked' => ['nullable', 'boolean'],
        ];

        if ($this->method() === 'PUT') {
            $rules['cpf_cnpj'][] = Rule::unique('clients', 'cpf_cnpj')->ignore($this->id)->where(function ($query) {
                return $query->where(function ($q) {
                    $q->where('active', 1);
                })->orWhereNull('active');
            });
        } else {
            $rules['cpf_cnpj'] = ['required', 'string', 'max:18', Rule::unique('clients', 'cpf_cnpj')->ignore(request()->id)->where(function ($query) {
                return $query->where(function ($q) {
                    $q->where('active', 1);
                })->orWhereNull('active');
            })];
        }

        return $rules;
    }



    // public function rules()
    // {
    //     return [
    //          'full_name' => [new CheckIfFullName,'string', 'required','min:5','max:100'],
    //          'surname' => 'nullable|string|max:50',
    //          'cpf_cnpj' => 'required|string|max:18|unique:clients,cpf_cnpj,'.request()->id,
    //          'email' =>['string','nullable','email', 'max:100'],
    //          'phone' => [new PhoneValidation],
    //          'im' => 'string|max:50|nullable|unique:clients,im,'.request()->id,
    //          'ie' => 'string|max:50|nullable|unique:clients,ie,'.request()->id,
    //          'fantasy_name' => ['string','nullable', 'max:50'],
    //          'obs' => ['string','nullable', 'max:500'],
    //          'active' => ['Boolean'],
    //          'inactive_date' => ['nullable', 'date'],
    //          'debit_balance' => ['nullable', 'integer'],
    //          'limit' => ['nullable', 'integer'],
    //          'marked' => ['nullable','Boolean'],
    //     ];
    // }

    public function messages()
    {
        return [
            'full_name.required' => 'o Campo nome e obrigatorio',
            'full_name.min' => 'O Nome deve possuir no minimo 5 letras',
            'cpf_cnpj.required' => 'O campo CPF / CNPJ é obrigatório',
            'cpf_cnpj.unique' => 'O CPF/CNPJ informado ja foi utilizado',
            'im.max' => 'O campo Inscrição Municipal não pode conter mais que 50 caracteres',
            'ie.max' => 'O campo Inscrição Estadual não pode conter mais que 50 caracteres',
        ];
    }
}
