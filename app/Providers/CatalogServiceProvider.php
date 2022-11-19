<?php

namespace App\Providers;

use App\Filters\BrandFilter;
use App\Filters\PriceFilter;
use App\Menu\Menu;
use App\Menu\MenuItem;
use Domain\Catalog\Filters\FilterManager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(FilterManager::class);
    }

    public function boot()
    {
        app(FilterManager::class)->registerFilters([
            new PriceFilter(),
            new BrandFilter(),
        ]);
    }
}
