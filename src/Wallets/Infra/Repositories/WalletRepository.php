<?php

declare(strict_types=1);

namespace Src\Wallets\Infra\Repositories;

use Src\Wallets\Domain\WalletGateway;
use Src\Wallets\Infra\Models\Wallet;

class WalletRepository implements WalletGateway
{
    public function getBalance(int $id): int | null
    {
        $wallet = Wallet::where('user_id', $id)->first();

        if($wallet == null){
            return null;
        }

        return $wallet->balance;
    }

    public function save(array $data): void
    {
        Wallet::create($data);
    }

    public function updateBalance(int $user_id, int $newBalance): void
    {
        $wallet = Wallet::where('user_id', $user_id)->first();

        $wallet->update(['balance' => $newBalance]);
    }

    public function getWallet(int $user_id): array | null
    {
        return Wallet::where('user_id', $user_id)->first()->toArray(); 
         
    }
}
