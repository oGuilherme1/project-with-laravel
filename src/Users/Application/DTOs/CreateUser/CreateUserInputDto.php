<?php

declare(strict_types=1);

namespace Src\Users\Application\DTOs\CreateUser;

use Src\Users\Enums\DocumentTypeEnum;
use Src\Users\Enums\UserTypeEnum;

class CreateUserInputDto 
{
    private function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $password,
        private readonly string $document,
        private readonly UserTypeEnum $user_type,
    )
    {
        
    }

    public static function create(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            document: $data['document'],
            user_type: ($data['user_type'] === "COMMOM") ? UserTypeEnum::COMMOM : UserTypeEnum::SHOPKEEPER
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getDocument(): string
    {
        return $this->document;
    }

    public function getUserType(): UserTypeEnum
    {
        return $this->user_type;
    }

    public function getAll(): array
    {
        return get_object_vars($this);
    }
}