<?php

namespace App\Http\Controllers;

use Domain\Product\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function __invoke(Product $product): Factory|View|Application
    {
        $product->load('optionValues.option');

        session()->put('also.'.$product->id, $product->id);

        $alsoProducts = Product::whereIn('id', array_values(session()->get('also')))
        ->where('id', '<>', $product->id)
        ->get();


        return view('product.show', [
            'product' => $product,
            'options' => $product->optionValues->keyValues(),
            'alsoProducts' => $alsoProducts,
        ]);
    }
}
