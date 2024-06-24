<?php

namespace Src\Wallets\Application\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Src\Users\Application\Events\UserCreated;
use Src\Wallets\Application\Commands\CreateWallet\CreateWalletCommand;
use Src\Wallets\Application\Commands\CreateWallet\CreateWalletCommandHandler;

class CreateWalletForNewUser implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(private CreateWalletCommandHandler $commandHandler)
    {
        
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        $command = $this->setCommand($event->user_id);
        $this->commandHandler->handle($command);
    }

    private function setCommand(int $user_id): CreateWalletCommand
    {
        return new CreateWalletCommand($user_id);
    }
}
