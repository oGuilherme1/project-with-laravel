<?php

declare(strict_types=1);

namespace Src\Wallets\Application\Queries\GetBalanceWallet;

use Src\Users\Application\Queries\Query;
use Src\Users\Application\Queries\QueryHandler;
use Src\Wallets\Application\DTOs\CreateWallet\GetBalanceInputDto;
use Src\Wallets\Application\UseCases\Wallet\GetBalanceWalletUseCase;

class GetBalanceWalletQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly GetBalanceWalletUseCase $useCase
    )
    {
    }

    public function handle(Query $command)
    {
        $inputDTO = GetBalanceInputDto::create(['user_id' => $command->userId]);
        return $this->useCase->execute($inputDTO);
    }
}