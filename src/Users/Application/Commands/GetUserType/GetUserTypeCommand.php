<?php 

declare(strict_types=1);

namespace Src\Users\Application\Commands\GetUserType;

use Src\Users\Application\Commands\Command;

class GetUserTypeCommand extends Command
{
    public function __construct(
        protected readonly int $id
    )
    {
        
    }

    public function getId(): int
    {
        return $this->id;
    }
}