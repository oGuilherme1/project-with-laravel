<?php 

declare(strict_types=1);

namespace Src\Transactions\Domain;

class Transaction
{

    private function __construct(
        private readonly ?int $id,
        private readonly int $payer_id,
        private readonly int $payee_id,
        private readonly int $amount,
        private readonly string $status
    )
    {

    }

    public static function create(?int $id, int $payer, int $payee, int $amount, string $status = 'failed'): self
    {
        return new self(
            id: $id,
            payer_id: $payer,
            payee_id: $payee,
            amount: $amount,
            status: $status
        );
    }

    public function toArray(): array
    {
        return [
            'payer_id' => $this->payer_id,
            'payee_id' => $this->payee_id,
            'amount' => $this->amount,
            'status' => $this->status
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            payer_id: $data['payer_id'],
            payee_id: $data['payee_id'],
            amount: $data['amount'],
            status: $data['status']
        );
    }
    
}