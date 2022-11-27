<?php

namespace Domain\Catalog\Facades;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Facade;

class Sorter extends Facade
{
    /**
     * @method static Builder run(Builder $query)
     * @see Domain\Catalog\Sorters\Sorter
     */
    protected static function getFacadeAccessor()
    {
        return \Domain\Catalog\Sorters\Sorter::class;
    }

}
