<?php

declare(strict_types=1);

namespace Src\Wallets\Application\DTOs\CreateWallet;

class UpdateBalanceWalletDto
{
    private function __construct(
        private readonly int $user_id,
        private readonly int $newBalance
    )
    {
        
    }

    public static function create(array $data): self
    {
        return new self(
            user_id: $data['user_id'],
            newBalance: $data['newBalance']
        );
    }


    public function getNewBalance(): int
    {
        return $this->newBalance;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }
}