<?php

namespace App\Filters;

use Domain\Catalog\Filters\AbstractFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class BrandFilter extends AbstractFilter
{

    public function title(): string
    {
        return 'Бренды';
    }

    public function key(): string
    {
        return 'brands';
    }

    public function apply(Builder $query): Builder
    {
        return $query->when($this->requestValue(), function (Builder $q){
            $q->whereIn('brand_id', $this->requestValue());
        });
    }

    public function values(): array
    {
        return [
            'from' => 0,
            'to' => 10000,
        ];
    }

    public function view(): string
    {
       return 'catalog.filters.price';
    }
}
