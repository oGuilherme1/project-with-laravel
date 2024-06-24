<?php

declare(strict_types=1);

namespace Src\Users\Application\Commands;

interface CommandHandler
{
    public function handle(Command $command);
}