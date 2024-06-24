<?php

declare(strict_types=1);

namespace Src\Users\Domain;

use Src\Users\Enums\DocumentTypeEnum;
use Src\Users\Enums\UserTypeEnum;

class User 
{
    private function __construct(
        private readonly ?int $id,
        private readonly string $name,
        private readonly string $email,
        private readonly string $password,
        private readonly string $document,
        private readonly DocumentTypeEnum $document_type,
        private readonly UserTypeEnum $user_type,
    )
    {
        
    }

    public static function create(?int $id, string $name, string $email, string $password, string $document, UserTypeEnum $user_type): self
    {
        $document_type = self::validatedDocument($document);
        return new self(
            id: $id,
            name: $name,
            email: $email,
            password: $password,
            document: $document,
            document_type: $document_type,
            user_type: $user_type
        );
    }

    public function toArray(): array 
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'document' => $this->document,
            'document_type' => $this->document_type->value,
            'user_type' => $this->user_type->value,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            document: $data['document'],
            document_type: new DocumentTypeEnum($data['document_type']),
            user_type: new UserTypeEnum($data['user_type'])
        );
    }

    private static function validatedDocument(string $document): DocumentTypeEnum
    {
        if(strlen($document) === 11) {
            return DocumentTypeEnum::CPF;
        }
        return DocumentTypeEnum::CNPJ;
    }
}