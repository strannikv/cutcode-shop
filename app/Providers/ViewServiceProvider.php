<?php

namespace App\Providers;

use App\Menu\Menu;
use App\Menu\MenuItem;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        Vite::macro('image', fn($asset) => $this->asset("resources/images/$asset"));

        View::composer('*', function ($view){
            $view->with(
                'menu',
                Menu::make()
                ->add(MenuItem::make(route('home'), 'Главная'))
                ->add(MenuItem::make(route('catalog'), 'Каталог'))
            );
        });
    }
}
