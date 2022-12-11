<?php

namespace App\Providers;

use App\MoonShine\Resources\CategoryResource;
use App\MoonShine\Resources\OptionResource;
use App\MoonShine\Resources\ProductResource;
use App\MoonShine\Resources\PropertyResource;
use Leeto\MoonShine\Menu\MenuItem;
use App\MoonShine\Resources\BrandResource;
use Illuminate\Support\ServiceProvider;
use Leeto\MoonShine\Menu\MenuGroup;
use Leeto\MoonShine\MoonShine;

class MoonshineServiceProvider extends ServiceProvider
{

    public function boot()
    {
        app(MoonShine::class)->registerResources([
            MenuGroup::make('Products', [
                MenuItem::make('Brand', new BrandResource()),
                MenuItem::make('Category', new CategoryResource()),
                MenuItem::make('Option', new OptionResource()),
                MenuItem::make('Property', new PropertyResource()),
                MenuItem::make('Product', new ProductResource()),
            ])
        ]);
    }
}
