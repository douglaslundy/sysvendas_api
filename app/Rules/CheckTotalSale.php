<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckTotalSale implements Rule
{
    private $check;
    private $cash;
    private $card;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($check, $cash, $card)
    {
        $this->check = $check;
        $this->cash = $cash;
        $this->card = $card;
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
        return ($value <= ($this->check + $this->cash + $this->card));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A soma dos valores pagos são inferiores que o valore da venda';
    }
}
