<?php

namespace App\Http\Requests;

use App\Rules\ChekIfValueSaleIsBiggestThanValueCost;
use App\Rules\IfAlreadyProductStock;
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
            'bar_code' => 'required|string|max:50|unique:products,bar_code,'.request()->id,
            'id_unity' => ['required', 'integer'],
            'id_category' => ['required', 'integer'],
            'cost_value' => ['required', 'numeric'],
            'sale_value' => [new ChekIfValueSaleIsBiggestThanValueCost(request()->input("cost_value")), 'required', 'numeric'],
            'stock' => ['nullable', 'numeric'],
            'id_product_stock' => ['integer', 'nullable', new IfAlreadyProductStock],
            'reason' => ['numeric'],
            'active' => ['nullable', 'boolean'],
        ];
    }

public function messages()
    {
        return [
            'bar_code.unique' => 'o codigo deste produto ja foi cadastrado',
        ];
    }
}
