<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ProductController extends Controller
{
    public function __invoke(Product $product)
    {



        return view('product.show', [
            'product' => $product
        ]);
    }
}
