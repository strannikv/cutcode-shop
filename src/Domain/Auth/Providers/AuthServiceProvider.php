<?php

namespace Domain\Auth\Providers;

// use Illuminate\Support\Facades\Gate;
use Domain\Auth\Actions\RegisterNewUserAction;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
   public array $bindings = [
        RegisterNewUserContract::class => RegisterNewUserAction::class
   ];


}
