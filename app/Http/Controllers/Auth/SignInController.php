<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignInFormRequest;
use Illuminate\Http\RedirectResponse;
use Support\SessionRegenerator;


class SignInController extends Controller
{
    public function page()
    {
        return view('auth.login', ['driver' => 'github']);
    }


    public function handle(SignInFormRequest $request)
    {
        if (!auth()->attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        SessionRegenerator::run();


        return redirect()->intended(route('home'));
    }


    public function logOut(): RedirectResponse
    {
        SessionRegenerator::run(fn() => auth()->logout());


        return redirect()->route('home');
    }

}
