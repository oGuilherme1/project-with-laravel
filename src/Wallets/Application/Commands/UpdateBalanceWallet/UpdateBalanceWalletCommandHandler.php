<?php

declare(strict_types=1);

namespace Src\Wallets\Application\Commands\UpdateBalanceWallet;

use Src\Wallets\Application\Commands\Command;
use Src\Wallets\Application\Commands\CommandHandler;
use Src\Wallets\Application\DTOs\CreateWallet\UpdateBalanceWalletDto;
use Src\Wallets\Application\UseCases\Wallet\UpdateBalanceUseCase;

class UpdateBalanceWalletCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly UpdateBalanceUseCase $useCase
    ) 
    {
    }

    public function handle(Command $command)
    {
        $inputDTO = UpdateBalanceWalletDto::create([...$command->getProperties()]);
        return $this->useCase->execute($inputDTO);
    }
}