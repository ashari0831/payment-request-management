<?php

namespace App\Rules;

use App\Models\Bank;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckShebaNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $bankExists = Bank::where('sheba_prefix', substr($value, 0, 2))->exists();

        if (!$bankExists)
            $fail('It is not a valid :attribute.');
    }
}
