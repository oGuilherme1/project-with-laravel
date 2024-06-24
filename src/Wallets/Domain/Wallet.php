<?php

declare(strict_types=1);

namespace Src\Wallets\Domain;


class Wallet 
{
    private function __construct(
        private readonly ?int $id,
        private readonly int $user_id,
        private readonly int $balance
    )
    {
        
    }

    public static function create(?int $id, int $user_id, int $balance = 0): self
    {
        return new self(
            id: $id,
            user_id: $user_id,
            balance: $balance,
        );
    }

    public function toArray(): array 
    {
        return [
            'user_id' => $this->user_id,
            'balance' => $this->balance,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            user_id: $data['user_id'],
            balance: $data['balance']
        );
    }

    public function getBalance(): int
    {
        return $this->balance;
    }
}