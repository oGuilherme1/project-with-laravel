<?php

namespace Src\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Transactions\Application\UseCases\Transaction\ProcessTransactionUseCase;
use Src\Transactions\Domain\TransactionGateway;
use Src\Transactions\Infra\Repositories\TransactionsRepository;
use Src\Users\Application\UseCases\User\GetUserTypeUseCase;
use Src\Wallets\Application\UseCases\Wallet\GetBalanceWalletUseCase;

class TransactionServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ProcessTransactionUseCase::class, function ($app) {
            return ProcessTransactionUseCase::create($app->make(TransactionGateway::class), $app->make(GetBalanceWalletUseCase::class), $app->make(GetUserTypeUseCase::class));
        });

        $this->app->singleton(TransactionGateway::class, function ($app) {
            return new TransactionsRepository();
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