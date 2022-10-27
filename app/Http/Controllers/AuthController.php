<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;
use Psy\Util\Str;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }


    public function signUp()
    {
        return view('auth.sign-up');
    }


    public function signIn(SignInFormRequest $request)
    {
        //todo 3 les Rate limit
        if (!auth()->attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }


    public function store(SignUpFormRequest $request)
    {
        $user = User::query()->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),

        ]);

        event(new Registered($user));

        auth()->login($user);

        return redirect()->intended(route('home'));
    }

    public function logOut(): RedirectResponse
    {
        auth()->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()->route('home');
    }


    public function forgot()
    {
        return view('auth.forgot-password');
    }


    public function forgotPassword(ForgotPasswordFormRequest $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        //todo 3 les Flash
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['message' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }


    public function reset(string $token)
    {
        return view('auth.reset-password', [
            'token' => $token
        ]);
    }


    public function resetPassword(ResetPasswordFormRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(str()->random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('message', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }


    public function gitHub()
    {
        return Socialite::driver('github')->redirect();
    }


    public function githubCallback()
    {
        $githubUser = Socialite::driver('github')->user();

        //todo 3 les move to custom table

        $user = User::query()->updateOrCreate([
            'github_id' => $githubUser->id,
        ],
        [
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'password' => bcrypt(str()->random(20)),
        ]);

//        $user = User::where('github_id', $githubUser->id)->first();
//
//        if ($user) {
//            $user->update([
//                'github_token' => $githubUser->token,
//                'github_refresh_token' => $githubUser->refreshToken,
//            ]);
//        } else {
//            $user = User::create([
//                'name' => $githubUser->name,
//                'email' => $githubUser->email,
//                'github_id' => $githubUser->id,
//                'github_token' => $githubUser->token,
//                'github_refresh_token' => $githubUser->refreshToken,
//            ]);
//        }

        auth()->login($user);

        return redirect()->intended(route('home'));
    }

}
