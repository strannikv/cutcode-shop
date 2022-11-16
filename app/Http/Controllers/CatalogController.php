<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Catalog\ViewModels\CategoryViewModel;

class CatalogController extends Controller
{
    public function __invoke(?Category $category)
    {
        $brands = Brand::query()
            ->has('products')
            ->get();

        $categories = Category::query()
            ->has('products')
            ->get();

        $products = Product::query()
            ->paginate(6);

        return view('index', compact(
            'categories',
            'category',
            'products',
            'brands'
        ));
    }
}
