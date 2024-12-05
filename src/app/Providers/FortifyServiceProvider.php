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
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        //GETメソッドで/registerにアクセスしたときに表示するviewファイル
        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::redirects('register', '/register');

        Fortify::verifyEmailView(function () {
            return view('auth.verify-email'); // あなたのビューに合わせてパスを変更
        });

        //GETメソッドで/loginにアクセスしたときに表示するviewファイル
        Fortify::loginView(function () {
            return view('auth.login');
        });
        //login処理の実行回数を1分あたり10回までに制限
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email . $request->ip());
        });

    }
}
