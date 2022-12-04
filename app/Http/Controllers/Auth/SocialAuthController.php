<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Auth\Models\User;
use DomainException;
use Laravel\Socialite\Facades\Socialite;
use Support\SessionRegenerator;
use Throwable;


class SocialAuthController extends Controller
{

    public function redirect(string $driver)
    {
        if ($driver != 'github') {
            throw new DomainException('Произошла ошибка 2');
        }

        try {
            return Socialite::driver($driver)->redirect();
        }catch (Throwable $e){
            throw new DomainException('Произошла ошибка');
        }

    }


    public function callback(string $driver)
    {
        if ($driver != 'github') {
            throw new DomainException('Произошла ошибка 2');
        }


        $githubUser = Socialite::driver($driver)->user();

        $user = User::query()->updateOrCreate([
            $driver . '_id' => $githubUser->getId(),
        ],
            [
                'name' => $githubUser->getName(),
                'email' => $githubUser->getEmail(),
                'password' => bcrypt(str()->random(20)),
            ]);

        SessionRegenerator::run(fn() => auth()->login($user));

//        auth()->login($user);

        return redirect()->intended(route('home'));
    }


}
