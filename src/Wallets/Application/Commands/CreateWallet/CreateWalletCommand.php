<?php

declare(strict_types=1);

namespace Src\Wallets\Application\Commands\CreateWallet;

use Src\Wallets\Application\Commands\Command;

class CreateWalletCommand extends Command
{
    public function __construct(
        public readonly int $user_id
    ) {
    }
}