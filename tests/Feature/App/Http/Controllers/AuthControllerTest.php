<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\AuthController;
use App\Http\Requests\ForgotPasswordFormRequest;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;
use Tests\RequestFactories\SignUpFormRequestFactory;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;


    public function test_it_login_page_success()
    {
        $this->get(action([AuthController::class, 'index']))
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.index');
    }


    public function test_it_sign_up_page_success()
    {
        $this->get(action([AuthController::class, 'signUp']))
            ->assertOk()
            ->assertSee('Регистрация')
            ->assertViewIs('auth.sign-up');
    }


    public function test_it_sign_in_success()
    {
        $password = '123456789';

        $user = User::factory()->create([
            'email' => '12345@gmail.com',
            'password' => bcrypt($password),
        ]);

        $request = SignInFormRequest::factory()->create([
            'email' => $user->email,
            'password' => $password,
        ]);

        $response = $this->post(action([AuthController::class, 'signIn'], $request));

        $response->assertValid()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }


    public function test_it_store_success()
    {
        Notification::fake();
        Event::fake();

        $request = SignUpFormRequest::factory()->create([
            'email' => '12345678@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $this->assertDatabaseMissing('users', ['email' => '12345678@gmail.com']);

        $response = $this->post(
            action([AuthController::class, 'store']),
            $request
        );

        $response->assertValid();

        $this->assertDatabaseHas('users', ['email' => '12345678@gmail.com']);

        $user = User::query()
            ->where('email', $request['email'])
            ->first();

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendEmailNewUserListener::class);

        $event = new Registered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);

        Notification::assertSentTo($user, NewUserNotification::class);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(route('home'));
    }


    public function test_forgot_success()
    {
        $response = $this->get(action([AuthController::class, 'forgot']));

        $response->assertViewIs('auth.forgot-password');
    }


    public function test_forgot_password_success()
    {
//        Notification::fake();
//        Event::fake();
//
//        $password = '123456789';
//        $email = '12345@gmail.com';
//
//        $user = User::factory()->create([
//            'email' => $email,
//            'password' => bcrypt($password),
//        ]);
//
//        $request = ForgotPasswordFormRequest::factory()->create([
//            'email' => $email,
//        ]);
//
//        $response = $this->post(
//            action([AuthController::class, 'forgotPassword']),
//            $request
//        );
//
//        $response->assertValid();


    }


    public function test_reset_success()
    {
//        $token = '123';
//
//        $data = [
//            'token' => $token
//        ];
//
//        $response = $this->get(action([AuthController::class, 'reset']), $data);
//
//        $response->assertViewIs('auth.reset-password');
    }


    public function test_reset_password_success()
    {
    }


    public function test_gitHub_success()
    {
    }


    public function test_gitHub_callback_success()
    {
    }


    public function test_it_logout_success()
    {
        $user = User::factory()->create([
            'email' => '12345@gmail.com',
        ]);

        $this->actingAs($user)->delete(action([AuthController::class, 'logOut']));

        $this->assertGuest();
    }


    //todo ДЗ) - дописать тесты на методы что ещё не сделаны.

    public function test_it_forgot_page_success()
    {
        $this->get(action([AuthController::class, 'forgot']))
            ->assertOk()
            ->assertSee('Забыли пароль?')
            ->assertViewIs('auth.forgot-password');
    }

}
