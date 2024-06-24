<?php

declare(strict_types=1);

namespace Src\Users\Application\DTOs\GetUserType;

class GetUserTypeDto
{

    private function __construct(
        private readonly int $id
    )
    {
        
    }

    public static function create(int $id): self
    {
        return new self(
            id: $id
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAll(): array
    {
        return get_object_vars($this);
    }
}