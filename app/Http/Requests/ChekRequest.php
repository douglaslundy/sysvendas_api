<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChekRequest extends FormRequest
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
            "cpf_cnpj_chek" => ['string', 'required','min:11', 'max:18'],
            "check_number" => ['integer', 'required'],
            "id_client" => ['integer', 'required'],
            "date_chek" => ['date'],
            "date_pay" => ['date', 'nullable'],
            "date_pay_out" => ['date', 'nullable'],
            "situation" => ['required']
        ];
    }
}
