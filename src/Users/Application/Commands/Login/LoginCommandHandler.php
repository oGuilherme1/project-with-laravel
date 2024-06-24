<?php

declare(strict_types=1);

namespace Src\Users\Application\Commands\Login;

use Src\Users\Application\Commands\Command;
use Src\Users\Application\Commands\CommandHandler;
use Src\Users\Application\DTOs\Login\LoginInputDto;
use Src\Users\Application\UseCases\Auth\LoginUseCase;

class LoginCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly LoginUseCase $useCase
    ) {
    }

    public function handle(Command $command)
    {
        $inputDTO = LoginInputDto::create(...$command->getProperties());
        return $this->useCase->execute($inputDTO);
    }
}