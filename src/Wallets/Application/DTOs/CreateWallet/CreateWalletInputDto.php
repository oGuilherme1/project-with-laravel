<?php

declare(strict_types=1);

namespace Src\Wallets\Application\DTOs\CreateWallet;

class CreateWalletInputDto 
{
    private function __construct(
        private readonly int $user_id
    )
    {
        
    }

    public static function create(array $data): self
    {
        return new self(
            user_id: $data['user_id']
        );
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getAll(): array
    {
        return get_object_vars($this);
    }
}