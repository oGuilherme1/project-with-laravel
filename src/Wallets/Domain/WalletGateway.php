<?php

declare(strict_types=1);

namespace Src\Wallets\Domain;

interface WalletGateway 
{
    public function getWallet(int $user_id): array | null;
    public function getBalance(int $user_id): int | null;
    public function save(array $data): void;
    public function updateBalance(int $user_id, int $newBalance): void;
}