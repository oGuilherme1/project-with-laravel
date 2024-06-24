<?php

namespace Src\Wallets\Application\DTOs\CreateWallet;

class GetBalanceInputDto
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