<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ChekIfValueSaleIsBiggestThanValueCost implements Rule
{
    private $cost_value;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($cost_value)
    {
        $this->cost_value = $cost_value;
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
        return ($value > $this->cost_value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O Valor de venda não pode ser menor que o valor de custo do produto';
    }
}
