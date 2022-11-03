<?php

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

class AppRegistrar implements RouteRegistrar
{

    public function map(Registrar $registrar)
    {
        Route::middleware('web')->group(function(){

            Route::get('/', HomeController::class)->name('home');

        });
    }
}
