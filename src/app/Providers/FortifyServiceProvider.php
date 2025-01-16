<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Fortify;
use App\Http\Requests\LoginRequest; // カスタムのLoginRequestを使用するように変更

class FortifyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        // LoginRequestをカスタムクラスに変更
        Fortify::authenticateUsing(function (Request $request) {
            $loginRequest = new LoginRequest();
            $loginRequest->merge($request->all());

            $validated = $loginRequest->validate($loginRequest->rules());

            if (Auth::attempt([
                'email' => $validated['email'],
                'password' => $validated['password'],
            ])) {
                return Auth::user();
            }

            return null;
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            return Limit::perMinute(10)->by($email . $request->ip());
        });
    }
}
