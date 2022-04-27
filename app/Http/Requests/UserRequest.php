<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            "profile" => ['required', 'string', 'max:50', Rule::in('admin', 'operator', 'user')],
            'name' => 'required|string|max:50',
            'email' => 'string|nullable|max:100|unique:users,email,'.request()->id,
            'cpf' => 'string|nullable|max:18|unique:users,cpf,'.request()->id,
            'email_verified_at' => ['nullable', 'date'],
            'active' => ['Boolean'],
            'inactive_date' => ['nullable', 'date'],
        ];
    }

    public function messages()
    {
        return [
            'profile.required' => 'O tipo de perfil do usuário é obrigatorio',
            'name.required' => 'O Nome do usuário é obrigatorio',
            'full_name.max' =>'O Nome não deve possuir acima de 50 caracteres',
            'cpf.unique' =>'Ja existe um usuário cadastrado com este CPF',
            'cpf.email' =>'Ja existe um usuário cadastrado com este E-Mail',
            'profile.in' =>'Tipo de Perfil selecionado não existe',
        ];
    }
}
