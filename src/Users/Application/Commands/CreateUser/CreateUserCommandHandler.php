<?php

declare(strict_types=1);

namespace Src\Users\Application\Commands\CreateUser;

use Src\Users\Application\Commands\Command;
use Src\Users\Application\Commands\CommandHandler;
use Src\Users\Application\UseCases\User\CreateUserUseCase;
use Src\Users\Application\DTOs\CreateUser\CreateUserInputDto;


class CreateUserCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly CreateUserUseCase $useCase
    ) {
    }

    public function handle(Command $command)
    {
        $inputDTO = CreateUserInputDto::create([...$command->getProperties()]);
        return $this->useCase->execute($inputDTO);
    }
}