<?php

namespace Src\Wallets\Application\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Src\Transactions\Application\Events\TransactionSuccessful;
use Src\Wallets\Application\Commands\UpdateBalanceWallet\UpdateBalanceWalletCommand;
use Src\Wallets\Application\Commands\UpdateBalanceWallet\UpdateBalanceWalletCommandHandler;

class UpdatedWalletPayer implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(private UpdateBalanceWalletCommandHandler $commandHandler)
    {
        
    }

    /**
     * Handle the event.
     */
    public function handle(TransactionSuccessful $event): void
    {
        $command = $this->setCommand($event->payer_id, $event->payer_newBalance);
        $this->commandHandler->handle($command);
    }

    private function setCommand(int $user_id, int $newBalance): UpdateBalanceWalletCommand
    {
        return new UpdateBalanceWalletCommand($user_id, $newBalance);
    }
}