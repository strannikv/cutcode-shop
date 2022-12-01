<?php

namespace App\Http\Controllers;

use App\ViewModels\CatalogViewModel;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CatalogController extends Controller
{
    public function __invoke(?Category $category)
    {

        return view('catalog.index', new CatalogViewModel($category));
    }
}
