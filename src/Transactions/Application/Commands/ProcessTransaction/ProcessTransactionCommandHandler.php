<?php

declare (strict_types=1);

namespace Src\Transactions\Application\Commands\ProcessTransaction;

use Src\Transactions\Application\Commands\Command;
use Src\Transactions\Application\Commands\CommandHandler;
use Src\Transactions\Application\DTOs\ProcessTransaction\ProcessTransactionDto;
use Src\Transactions\Application\UseCases\Transaction\ProcessTransactionUseCase;

class ProcessTransactionCommandHandler implements CommandHandler
{

    public function __construct(
        private readonly ProcessTransactionUseCase $processTransactionUseCase
    )
    {
    }

    public function handle(Command $command)
    {
        $inputDTO = ProcessTransactionDto::create([...$command->getProperties()]);
        return $this->processTransactionUseCase->execute($inputDTO);
    }
}