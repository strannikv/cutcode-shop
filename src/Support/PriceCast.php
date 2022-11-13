<?php

namespace Support;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Support\ValueObjects\Price;

class PriceCast implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        return Price::make($value);
    }

    public function set($model, $key, $value, $attributes)
    {
        if(!$value instanceof Price){
            $value = Price::make($value);
        }

        return $value->raw();
    }
}
