<?php

declare(strict_types=1);

namespace Src\Users\Application\Commands\GetUserType;

use Src\Users\Application\Commands\Command;
use Src\Users\Application\Commands\CommandHandler;
use Src\Users\Application\DTOs\GetUserType\GetUserTypeDto;
use Src\Users\Application\UseCases\User\GetUserTypeUseCase;

class GetUserTypeCommandHandler implements CommandHandler
{

    public function __construct(
        private readonly GetUserTypeUseCase $useCase
    )
    {
        
    }

    public function handle(Command $command)
    {
        $inputDTO = GetUserTypeDto::create($command->getId());
        return $this->useCase->execute($inputDTO);
    }
}