<?php

declare(strict_types=1);

namespace Src\Wallets\Application\Commands;

interface CommandHandler
{
    public function handle(Command $command);
}