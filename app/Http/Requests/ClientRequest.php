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
            'debit_balance' => ['nullable', 'numeric'],
            'limit' => ['nullable', 'numeric'],
            'marked' => ['nullable', 'boolean'],
            'addresses.zip_code' => ['required','max:10'],
            'addresses.city' => ['required','max:30'],
            'addresses.street' => ['required','max:100'],
            'addresses.number' => ['required','max:6'],
            'addresses.district' => ['required','max:100'],
            'addresses.complement' => ['required','max:50'],
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

    public function messages()
    {
        return [
            'full_name.required' => 'O campo nome é obrigatório.',
            'full_name.min' => 'O nome deve ter no mínimo 5 caracteres.',
            'cpf_cnpj.required' => 'O campo CPF/CNPJ é obrigatório.',
            'cpf_cnpj.max' => 'O campo CPF/CNPJ não pode ter mais de 18 caracteres.',
            'cpf_cnpj.unique' => 'O CPF/CNPJ informado já foi utilizado.',
            'im.max' => 'O campo Inscrição Municipal não pode ter mais de 50 caracteres.',
            'ie.max' => 'O campo Inscrição Estadual não pode ter mais de 50 caracteres.',
            'addresses.zip_code.required' => 'O CEP é obrigatório.',
            'addresses.zip_code.max' => 'O CEP não pode ter mais de 10 caracteres.',
            'addresses.city.required' => 'A cidade é obrigatória.',
            'addresses.city.max' => 'A cidade não pode ter mais de 30 caracteres.',
            'addresses.street.required' => 'A rua é obrigatória.',
            'addresses.street.max' => 'A rua não pode ter mais de 100 caracteres.',
            'addresses.number.required' => 'O número é obrigatório.',
            'addresses.number.max' => 'O número não pode ter mais de 6 caracteres.',
            'addresses.district.required' => 'O bairro é obrigatório.',
            'addresses.district.max' => 'O bairro não pode ter mais de 100 caracteres.',
            'addresses.complement.required' => 'O complemento é obrigatório.',
            'addresses.complement.max' => 'O complemento não pode ter mais de 50 caracteres.',
        ];
    }
}