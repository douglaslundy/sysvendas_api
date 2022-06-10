<?php

namespace App\Http\Requests;

use App\Rules\CheckIfSaleIsBiggerThanZero;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\CheckTotalSale;
use App\Rules\IfExistsClientInSale;
use App\Rules\IfInClients;
use App\Rules\IfInUsers;

class SaleRequest extends FormRequest
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
            "id_user" => ['integer', 'required', new IfInUsers],
            "id_client" => ['integer','nullable', new IfInClients],
            // "sale_date" => ['date', 'required'],
            "paied" => ['string', 'required', Rule::in('yes','no')],
            "type_sale" => ['string', 'required',  Rule::in('in_cash', 'on_term'), new IfExistsClientInSale(request()->input('id_client'))],
            "due_date" => ['date', 'nullable'],
            "pay_date" => ['date', 'nullable'],
            "chek" => ['integer', 'nullable'],
            "cash" => ['integer', 'nullable'],
            "card" => ['integer', 'nullable'],
            "total_sale" => [new CheckTotalSale(request()->input("type_sale"), request()->input("check"), request()->input("cash"), request()->input("card")), new CheckIfSaleIsBiggerThanZero()],
        ];
    }


    public function messages()
    {
        return [
            'type_sale.required' => 'Metodo de pagamento é obrigatório!!!',
            'paied.required' => 'O status da venda é obrigatório!!!',
        ];
    }
}
