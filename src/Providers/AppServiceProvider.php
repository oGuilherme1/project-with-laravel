<?php

namespace Src\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Users\Application\UseCases\Auth\LoginGateway;
use Src\Users\Application\UseCases\Auth\LoginUseCase;
use Src\Users\Infra\Auth\Sanctum\AuthSanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LoginUseCase::class, function ($app) {
            return LoginUseCase::create($app->make(LoginGateway::class));
        });

        $this->app->singleton(LoginGateway::class, function () {
            return new AuthSanctum();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
