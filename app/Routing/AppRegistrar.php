<?php

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ThumbnailController;
use App\Http\Middleware\CatalogViewMiddleware;
use Domain\Catalog\Collections\CategoryCollection;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

class AppRegistrar implements RouteRegistrar
{

    public function map(Registrar $registrar)
    {
        Route::middleware('web')->group(function(){

            Route::get('/', HomeController::class)->name('home');

            Route::get('/catalog/{category:slug?}', CatalogController::class)
                ->middleware(CatalogViewMiddleware::class)
                ->name('catalog');

            Route::get('/storage/images/{dir}/{method}/{size}/{file}', ThumbnailController::class)
            ->where('method', 'resize|crop|fit')
            ->where('size', '\d+x\d+')
            ->where('file', '.+\.(png|jpg|gif|bmp|jpeg)$')
            ->name('thumbnail');

        });
    }
}
