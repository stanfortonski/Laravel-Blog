<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Title implements Rule
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
        return preg_match('/^([^\\`\"\'\^\/\[\]\{\}\(\)]*)$/', $value);
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
