<?php

namespace Domain\Auth\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\HomeController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

class AuthRegistrar implements RouteRegistrar
{

    public function map(Registrar $registrar)
    {
        Route::middleware('web')->group(function() {

            Route::controller(SignInController::class)->group(function () {
                Route::get('/login', 'index')->name('login');
                Route::post('/login', 'signIn')
                    ->middleware('throttle:auth')
                    ->name('signIn');

                Route::get('/sign-up', 'signUp')->name('signUp');
                Route::post('/sign-up', 'store')
                    ->middleware('throttle:auth')
                    ->name('store');

                Route::delete('/logout', 'logOut')->name('logOut');

                Route::get('/forgot-password', 'forgot')
                    ->middleware('guest')
                    ->name('password.request');

                Route::post('/forgot-password', 'forgotPassword')
                    ->middleware('guest')
                    ->name('password.email');

                Route::get('/reset-password/{token}', 'reset')
                    ->middleware('guest')
                    ->name('password.reset');

                Route::post('/reset-password', 'resetPassword')
                    ->middleware('guest')
                    ->name('password.update');


                Route::get('/auth/socialite/github', 'gitHub')->name('socialite.github');

                Route::get('/auth/callback', function () {
                    $user = Socialite::driver('github')->user();

                    // $user->token
                });


                Route::get('/auth/socialite/github/callback', 'githubCallback')
                    ->name('socialite.github.callback');
            });
        });
    }
}
