<?php

declare(strict_types=1);

namespace Tests\Unit\Wallet;

use PHPUnit\Framework\TestCase;
use Src\Wallets\Application\DTOs\CreateWallet\UpdateBalanceWalletDto;
use Src\Wallets\Application\UseCases\Wallet\UpdateBalanceUseCase;
use Src\Wallets\Domain\WalletGateway;

class UpdateBalanceWalletTest extends TestCase
{
    public function testUpdatedBalanceUseCase(): void
    {
        // Mock the dependencies
        $walletGatewayMock = $this->createMock(WalletGateway::class);
        
        // Create an instance of the UpdatedBalanceUseCase
        $updatedBalanceUseCase = UpdateBalanceUseCase::create($walletGatewayMock);

        $walletData = [
            'id' => 1,
            'user_id' => 1,
            'balance' => 50
        ];
        
        $walletGatewayMock->method('getWallet')
        ->with(1)
        ->willReturn($walletData);
        
        
        // Define the input data
        $inputDto = UpdateBalanceWalletDto::create([
            "user_id" => 1,
            "newBalance" => 100
        ]);
            
        
        // Set up the mock expectations
        $walletGatewayMock->expects($this->once())
            ->method('updateBalance')
            ->with($inputDto->getUserId(), $inputDto->getNewBalance());

        // Call the use case method
        $result = $updatedBalanceUseCase->execute($inputDto);

        // Assert the result
        $this->assertEquals(['message' => 'Balance updated successfully'], $result);
    }

    public function testUpdatedBalanceUseCaseWithError(): void
    {
        // Mock the dependencies
        $walletGatewayMock = $this->createMock(WalletGateway::class);
        
        // Create an instance of the UpdatedBalanceUseCase
        $updatedBalanceUseCase = UpdateBalanceUseCase::create($walletGatewayMock);
        
        // Define the input data
        $inputDto = UpdateBalanceWalletDto::create([
            "user_id" => 6,
            "newBalance" => 100
        ]);
        
        // Call the use case method
        $result = $updatedBalanceUseCase->execute($inputDto);

        // Assert the result
        $this->assertEquals(['message' => 'Wallet not found'], $result);
    }
}
