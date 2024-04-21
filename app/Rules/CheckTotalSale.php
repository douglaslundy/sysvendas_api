<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckTotalSale implements Rule
{
    private $type_sale;
    private $check;
    private $cash;
    private $card;
    private $discount;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($type_sale, $check, $cash, $card, $discount)
    {
        $this->type_sale = $type_sale;
        $this->check = $check;
        $this->cash = $cash;
        $this->card = $card;
        $this ->discount = $discount;
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
        // return $this->type_sale == 'in_cash' ? (($value - $this->discount) <= ($this->check + $this->cash + $this->card)) : true;
        // a função de arredondamento ceil evita erros de arredondamento
        return $this->type_sale == 'in_cash' ? (ceil(($value - $this->discount)) <= ceil(($this->check + $this->cash + $this->card))) : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O valor pago não pode ser menor que o valor da venda';
    }
}
