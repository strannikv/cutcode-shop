<?php

namespace Domain\Order\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneRule implements Rule
{
    public function __construct()
    {
    }

    public function passes($attribute, $value): bool
    {
        return is_numeric($value);
    }

    public function message(): string
    {
        return 'Плохой телефон.';
    }
}
