<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RealName implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return preg_match('/^([^\\|`~*!@#$%<>;,_.:?+=\"\'\^\/\[\]\{\}\(\)]*)$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('validation.custom.preg');
    }
}
