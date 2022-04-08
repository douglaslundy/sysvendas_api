<?php

namespace App\Http\Requests;

use App\Rules\ChekIfValueSaleIsBiggestThanValueCost;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:50'],
            'bar_code' => ['required', 'string', 'max:50', 'unique:products, products'.request()->id],
            'id_unity' => ['required', 'integer'],
            'id_category' => ['required', 'integer'],
            'cost_value' => ['required', 'integer'],
            'sale_value' => [new ChekIfValueSaleIsBiggestThanValueCost(request()->input("cost_value")), 'required', 'integer'],
            'stock' => ['required', 'integer'],
            'active' => ['nullable', 'boolean'],
        ];
    }
}
