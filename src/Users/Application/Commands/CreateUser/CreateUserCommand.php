<?php

declare(strict_types=1);

namespace Src\Users\Application\Commands\CreateUser;

use Src\Users\Application\Commands\Command;
use Src\Users\Enums\DocumentTypeEnum;
use Src\Users\Enums\UserTypeEnum;

class CreateUserCommand extends Command
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly string $document,
        public readonly string $user_type,
    ) {
    }
}