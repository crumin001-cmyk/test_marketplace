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
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use App\Http\Responses\LoginResponse;
use App\Http\Responses\RegisterResponse;
use Illuminate\Support\Facades\Validator;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            LoginResponseContract::class,
            LoginResponse::class
        );
        $this->app->singleton(
        RegisterResponseContract::class,
        RegisterResponse::class
    );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::registerView(function () {
            return view('register');
        });

        Fortify::loginView(function () {
            return view('login');
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email . $request->ip());
        });

        Fortify::authenticateUsing(function (Request $request) {
            Validator::make($request->all(), [
                'email' =>['required'],
                'password' =>['required'],
                ],[
                'email.required' => 'メールアドレスを入力してください',
                'password.required' => 'パスワードを入力してください',
                ])->validate();
                
                if (Auth::attempt([
                    'email' => $request->email,
                    'password' => $request->password,
                ])) {
                    return Auth::user();
                }
                
                throw ValidationException::withMessages([

                    'email' => ['ログイン情報が登録されていません'],

                ]);
        });

    }
}
