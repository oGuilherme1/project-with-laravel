<?php

declare(strict_types=1);

namespace Src\Transactions\Domain;

interface TransactionGateway
{
    public function save(array $data): array;

}