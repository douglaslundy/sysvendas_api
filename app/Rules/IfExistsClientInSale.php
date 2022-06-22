<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IfExistsClientInSale implements Rule
{
    private $client;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($client)
    {
        $this->client = $client;
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
        return $value == 'on_term' ? $this->client !== null : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Sem cliente referenciado na venda!';
    }
}
