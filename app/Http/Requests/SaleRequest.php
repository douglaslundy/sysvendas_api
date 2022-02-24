<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckTotalSale;

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
            "id_user" => ['integer', 'required'],
            "id_client" => ['integer', 'required'],
            "sale_date" => ['date', 'required'],
            "paied" => ['string', 'required'],
            "type_sale" => ['string', 'required'],
            "due_date" => ['date', 'nullable'],
            "pay_date" => ['date', 'nullable'],
            "chek" => ['integer', 'nullable'],
            "cash" => ['integer', 'nullable'],
            "card" => ['integer', 'nullable'],
            "total_sale" => [new CheckTotalSale(request()->input("chek"), request()->input("cash"),request()->input("card"))],
        ];
    }
}
