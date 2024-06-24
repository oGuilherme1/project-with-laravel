<?php

declare(strict_types=1);

namespace Src\Users\Application\Queries;

interface QueryHandler
{
    public function handle(Query $query);
}