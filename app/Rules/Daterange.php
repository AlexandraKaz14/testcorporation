<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Daterange implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (count(explode(' - ', $value)) !== 2) {
            $fail('The :attribute must be daterange format (for example 2021-01-01 - 2022-02-03 ).');
        }
    }
}
