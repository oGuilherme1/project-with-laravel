<?php

declare(strict_types=1);

namespace Src\Transactions\Application\Commands;

abstract class Command
{
    public function getProperties(): array
    {
        return get_object_vars($this);
    }
}