<?php

namespace App\Rules;

use App\Models\ProductStock;
use Illuminate\Contracts\Validation\Rule;

class IfAlreadyProductStock implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return ProductStock::where('id_product', $value)->count();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Este produto não possui estoque';
    }
}
