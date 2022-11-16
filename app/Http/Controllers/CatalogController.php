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
            ->select('id', 'title')
            ->has('products')
            ->get();

        $categories = Category::query()
            ->select('id', 'title', 'slug')
            ->has('products')
            ->get();

        $products = Product::query()
            ->select('id', 'title', 'slug', 'price', 'thumbnail')
            ->paginate(6);

        return view('catalog.index', compact(
            'categories',
            'category',
            'products',
            'brands'
        ));
    }
}
