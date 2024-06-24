<?php

declare(strict_types=1);

namespace Src\Wallets\Application\Commands\CreateWallet;

use Src\Wallets\Application\Commands\Command;
use Src\Wallets\Application\Commands\CommandHandler;
use Src\Wallets\Application\DTOs\CreateWallet\CreateWalletInputDto;
use Src\Wallets\Application\UseCases\Wallet\CreateWalletUseCase;

class CreateWalletCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly CreateWalletUseCase $useCase
    ) 
    {
    }

    public function handle(Command $command)
    {
        $inputDTO = CreateWalletInputDto::create([...$command->getProperties()]);
        return $this->useCase->execute($inputDTO);
    }
}