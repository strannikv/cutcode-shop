<?php

namespace Auth\Actions;

use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterNewUserAction extends TestCase
{
    use RefreshDatabase;

    public function test_it_success_user_created()
    {
        $action = app(RegisterNewUserContract::class);

        $this->assertDatabaseMissing('users', [
            'email' => 'test@gmail.com',
        ]);

        $action(NewUserDTO::make('test', 'test@gmail.com', '12345678'));

        $this->assertDatabaseHas('users', [
            'email' => 'test@gmail.com',
        ]);
    }

}
