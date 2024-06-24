<?php

declare(strict_types=1);

namespace Src\Wallets\Application\Commands\UpdateBalanceWallet;

use Src\Wallets\Application\Commands\Command;

class UpdateBalanceWalletCommand extends Command
{

    public function __construct(
        public readonly int $user_id,
        public readonly int $newBalance
    )
    {
        
    }
}