<?php

declare(strict_types=1);

namespace Src\Transactions\Application\Commands\ProcessTransaction;

use Src\Transactions\Application\Commands\Command;

class ProcessTransactionCommand extends Command
{

    public function __construct(
        protected readonly int $amount,
        protected readonly int $payer,
        protected readonly int $payee
    )
    {
    }


}