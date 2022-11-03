<?php

namespace Domain\Auth\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

class AuthRegistrar implements RouteRegistrar
{

    public function map(Registrar $registrar)
    {
        Route::middleware('web')->group(function() {

            Route::get('/login', [SignInController::class, 'page'])
                ->name('login');

            Route::post('/login', [SignInController::class, 'handle'])
                ->middleware('throttle:auth')->name('signIn');

            Route::get('/sign-up', [SignUpController::class, 'page'])
                ->name('signUp');

            Route::post('/sign-up', [SignUpController::class, 'handle'])->middleware('throttle:auth')
                ->name('store');

            Route::delete('/logout', [SignInController::class, 'logOut'])
                ->name('logOut');

            Route::get('/forgot-password', [ForgotPasswordController::class,'page'])
//                ->middleware('guest')
                ->name('password.request');

            Route::post('/forgot-password', [ForgotPasswordController::class,'handle'])
                ->middleware('guest')
                ->name('password.email');

            Route::get('/reset-password/{token}', [ResetPasswordController::class,'page'])
                ->middleware('guest')
                ->name('password.reset');

            Route::post('/reset-password', [ResetPasswordController::class,'handle'])
                ->middleware('guest')
                ->name('password.update');

            Route::get('/auth/socialite/{driver}', [SocialAuthController::class,'redirect'])
                ->name('socialite.github');

//            Route::get('/auth/callback/{driver}', function () {
//                $user = Socialite::driver('github')->user();
//
//                // $user->token
//            });

//            Route::get('/auth/socialite/github/callback', [SocialAuthController::class,'callback'])
//                ->name('socialite.github.callback');

        });
    }
}
