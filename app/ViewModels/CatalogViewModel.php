<?php

namespace App\ViewModels;

use Domain\Catalog\Collections\CategoryCollection;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Spatie\ViewModels\ViewModel;

class CatalogViewModel extends ViewModel
{
    public function __construct(
        public Category $category
    )
    {
        //
    }


    public function categories(): Collection|array|CategoryCollection
    {
        return Category::query()
            ->select('id', 'title', 'slug')
            ->has('products')
            ->get();
    }


    public function products()
    {
        return Product::query()
            ->select('id', 'title', 'slug', 'price', 'thumbnail', 'json_properties')
            ->search()
            ->withCategory($this->category)
            ->filtered()
            ->sorted()
            ->paginate(6);
    }
}
