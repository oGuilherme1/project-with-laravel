<?php

namespace Src\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Src\Transactions\Application\Events\TransactionSuccessful;
use Src\Users\Application\Events\UserCreated;
use Src\Wallets\Application\Listeners\CreateWalletForNewUser;
use Src\Wallets\Application\Listeners\UpdatedWalletPayee;
use Src\Wallets\Application\Listeners\UpdatedWalletPayer;

class EventsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Event::listen(
            UserCreated::class,
            CreateWalletForNewUser::class,
        );

        Event::listen(
            TransactionSuccessful::class,
            UpdatedWalletPayer::class,
        );

        Event::listen(
            TransactionSuccessful::class,
            UpdatedWalletPayee::class,
        );
    }
}
