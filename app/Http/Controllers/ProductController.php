<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function __invoke(Product $product): Factory|View|Application
    {
        $product->load('optionValues.option');

        $options = $product->optionValues->mapToGroups(function ($item){
            return [$item->option->title => $item];
        });

        session()->put('also.'.$product->id, $product->id);

        $alsoProducts = Product::whereIn('id', array_values(session()->get('also')))
        ->where('id', '<>', $product->id)
        ->get();


        return view('product.show', [
            'product' => $product,
            'options' => $options,
            'alsoProducts' => $alsoProducts,
        ]);
    }
}
