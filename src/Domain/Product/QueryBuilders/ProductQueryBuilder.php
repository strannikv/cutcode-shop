<?php

namespace Domain\Product\QueryBuilders;

use Domain\Catalog\Facades\Sorter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

class ProductQueryBuilder extends Builder
{

    public function homePage()
    {
        return $this->where('on_home_page', 1)
            ->orderBy('sorting')
            ->limit(6);
    }


//    public function filtered()
//    {
////        return app(Pipeline::class)
////            ->send($this)
////            ->through(filters())
////            ->thenReturn();
//
//        foreach (filters() as $filter) {
//            $query = $filter->apply($this);
//        }
//    }


        public function sorted()
    {
        return Sorter::run($this);

//        return $this->when(request('sort'), function (Builder $q){
//            $column = request()->str('sort');
//
//            if ($column->contains(['price', 'title'])){
//                $direction = $column->contains('-') ? 'DESC' : 'ASC';
//
//                $q->orderBy((string) $column->remove('-'), $direction);
//            }
//        });

    }
}
