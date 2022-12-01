<?php

namespace Domain\Product\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class ProductQueryBuilder extends Builder
{

    public function homePage()
    {
        return $this->where('on_home_page', 1)
            ->orderBy('sorting')
            ->limit(6);
    }
}
