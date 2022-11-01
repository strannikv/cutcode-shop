<?php

namespace Tests\RequestFactories;

use Worksome\RequestFactories\RequestFactory;

class ResetPasswordFormRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
           'token' => str()->random(60),
           'name' => $this->faker->name,
           'password' => $this->faker->password(8),
        ];
    }
}
