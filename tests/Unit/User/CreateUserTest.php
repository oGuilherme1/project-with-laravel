<?php

declare(strict_types=1);

namespace Tests\Unit\User;

use PHPUnit\Framework\TestCase;
use Src\Users\Application\DTOs\CreateUser\CreateUserInputDto;
use Src\Users\Application\UseCases\User\CreateUserUseCase as UserCreateUserUseCase;
use Src\Users\Domain\UserGateway;
use Src\Users\Enums\DocumentTypeEnum;
use Src\Users\Enums\UserTypeEnum;

class CreateUserTest extends TestCase
{
    private $userGatewayMock;
    protected $createUserUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userGatewayMock = $this->createMock(UserGateway::class);
        $this->createUserUseCase = UserCreateUserUseCase::create($this->userGatewayMock);
    }

    public function testExecuteSuccessfullyCreatesUser(): void
    {
        // Arrange
        $this->userGatewayMock->method('findEmail')->willReturn(false);
        $this->userGatewayMock->method('findDocument')->willReturn(false);

        $inputDto = CreateUserInputDto::create([
            "name" => 'John Doe',
            "email" => 'john.doe@example.com',
            "password" => 'password123',
            "document" => '123456789',
            "document_type" => DocumentTypeEnum::CNPJ,
            "user_type" => UserTypeEnum::COMMOM
        ]);

        // Act
        $result = $this->createUserUseCase->execute($inputDto);

        // Assert
        $this->assertEquals(['message' => 'User created successfully', 'success' => true], $result);
    }

    public function testExecuteFailsDueToExistingEmail(): void
    {
        // Arrange
        $this->userGatewayMock->method('findEmail')->willReturn(true);

        $inputDto = CreateUserInputDto::create([
            "name" => 'John Doe',
            "email" => 'john.doe@example.com',
            "password" => 'password123',
            "document" => '123456789',
            "document_type" => DocumentTypeEnum::CNPJ,
            "user_type" => UserTypeEnum::COMMOM
        ]);

        // Act
        $result = $this->createUserUseCase->execute($inputDto);

        // Assert
        $this->assertEquals(['message' => 'This email already exists john.doe@example.com', 'success' => false], $result);
    }

    public function testExecuteFailsDueToExistingDocument(): void
    {
        // Arrange
        $this->userGatewayMock->method('findEmail')->willReturn(false);
        $this->userGatewayMock->method('findDocument')->willReturn(true);

        $inputDto = CreateUserInputDto::create([
            "name" => 'John Doe',
            "email" => 'john.doe@example.com',
            "password" => 'password123',
            "document" => '123456789',
            "document_type" => DocumentTypeEnum::CNPJ,
            "user_type" => UserTypeEnum::COMMOM
        ]);

        // Act
        $result = $this->createUserUseCase->execute($inputDto);

        // Assert
        $this->assertEquals(['message' => 'This document already exists ', 'success' => false], $result);
    }
}
