<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckTotalSale implements Rule
{
    private $chek;
    private $cash;
    private $card;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($chek, $cash, $card)
    {
        $this->chek = $chek;
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
        return ($value == ($this->chek + $this->cash + $this->card));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The sum of the values chek, cash, and card don´t equals at value total sale';
    }
}
