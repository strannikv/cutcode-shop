<?php

namespace Domain\Catalog\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class CategoryQueryBuilder extends Builder
{

    public function homePage()
    {
        return $this->where('on_home_page', 1)
            ->orderBy('sorting')
            ->limit(6);
    }
}
