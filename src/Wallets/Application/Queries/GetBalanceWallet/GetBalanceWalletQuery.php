<?php

declare(strict_types=1);

namespace Src\Wallets\Application\Queries\GetBalanceWallet;

use Src\Users\Application\Queries\Query;

class GetBalanceWalletQuery implements Query
{
    public function __construct(
        public readonly int $userId
    )
    {
    }
}