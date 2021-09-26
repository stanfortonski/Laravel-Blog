<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsLang implements Rule
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
        foreach (config('blog.available_locales') as $locale){
            if ($locale == $value)
                return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return _('This value is not language.');
    }
}
