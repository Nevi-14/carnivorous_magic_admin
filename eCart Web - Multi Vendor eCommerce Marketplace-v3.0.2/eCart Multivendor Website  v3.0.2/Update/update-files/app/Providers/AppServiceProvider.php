<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Firebase\JWT\JWT;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /* */
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $token = jwt::encode(config('ekart.jwt_payload'), config('ekart.jwt_secret_key'), config('ekart.jwt_alg'));
        view()->share('token', $token);

    }
}
