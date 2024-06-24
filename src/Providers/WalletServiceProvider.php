<?php

namespace Src\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Wallets\Application\UseCases\Wallet\CreateWalletUseCase;
use Src\Wallets\Application\UseCases\Wallet\GetBalanceWalletUseCase;
use Src\Wallets\Application\UseCases\Wallet\UpdateBalanceUseCase;
use Src\Wallets\Domain\WalletGateway;
use Src\Wallets\Infra\Repositories\WalletRepository;

class WalletServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CreateWalletUseCase::class, function ($app) {
            return CreateWalletUseCase::create($app->make(WalletGateway::class));
        });

        $this->app->singleton(WalletGateway::class, function ($app) {
            return new WalletRepository();
        });

        $this->app->singleton(GetBalanceWalletUseCase::class, function ($app) {
            return GetBalanceWalletUseCase::create($app->make(WalletGateway::class));
        });

        $this->app->singleton(UpdateBalanceUseCase::class, function ($app) {
            return UpdateBalanceUseCase::create($app->make(WalletGateway::class));
        });


    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
