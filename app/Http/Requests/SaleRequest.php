<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckTotalSale;
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
            "id_client" => ['integer', 'required', new IfInClients],
            "sale_date" => ['date', 'required'],
            "paied" => ['string', 'required', 'in:yes,no'],
            "type_sale" => ['string', 'required', 'in:in_cash,on_term'],
            "due_date" => ['date', 'nullable'],
            "pay_date" => ['date', 'nullable'],
            "chek" => ['integer', 'nullable'],
            "cash" => ['integer', 'nullable'],
            "card" => ['integer', 'nullable'],
            "total_sale" => [new CheckTotalSale(request()->input("chek"), request()->input("cash"),request()->input("card"))],
        ];
    }
}