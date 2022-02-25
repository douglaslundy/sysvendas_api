<?php

namespace App\Http\Requests;

use App\Rules\IfInProducts;
use App\Rules\IfInUsers;
use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
            "id_product" => ['integer', 'required',new  IfInProducts],
            "name_product" => ['string', 'required'],
            "bar_code" => ['string', 'max:50', 'required'],
            "qdt" => ['integer', 'required'],
            "value" => ['integer', 'required'],
            "number_item" => ['string', 'max:5', 'required']
        ];
    }
}
