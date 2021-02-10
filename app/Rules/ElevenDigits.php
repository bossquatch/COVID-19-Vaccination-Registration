<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ElevenDigits implements Rule
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
        if (isset($value)) {
            return strlen(preg_replace('/\D/', '', $value)) >= 10;      // THIS WAS CHANGED; first event they had and an NDC with 10 digits instead of eleven...
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute field must at least 10 digits long.';
    }
}
