<?php

declare(strict_types=1);

namespace Src\Transactions\Application\DTOs\ProcessTransaction;

class ProcessTransactionDto
{
    private function __construct(
        private readonly int $amount,
        private readonly int $payer,
        private readonly int $payee

    )
    {
        
    }

    public static function create(array $data): self
    {
        return new self(
            amount: $data['amount'],
            payer: $data['payer'],
            payee: $data['payee']

        );
    }

    public function getPayerId(): int
    {
        return $this->payer;
    }   

    public function getPayeeId(): int
    {
        return $this->payee;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getAll(): array
    {
        return get_object_vars($this);
    }

    
}