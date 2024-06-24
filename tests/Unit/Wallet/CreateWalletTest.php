<?php

declare(strict_types=1);

namespace Tests\Unit\Wallet;

use PHPUnit\Framework\TestCase;
use Src\Wallets\Application\DTOs\CreateWallet\CreateWalletInputDto;
use Src\Wallets\Application\UseCases\Wallet\CreateWalletUseCase;
use Src\Wallets\Domain\WalletGateway;

class CreateWalletTest extends TestCase
{
    private $walletGatewayMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->walletGatewayMock = $this->createMock(WalletGateway::class);
    }

    public function testExecuteSuccessfully(): void
    {
        $inputData = ['user_id' => 1];

        $createWalletInputDto = CreateWalletInputDto::create($inputData);

        $createWalletUseCase = CreateWalletUseCase::create($this->walletGatewayMock);

        $this->walletGatewayMock
            ->method('save')
            ->with($this->callback(function ($data) use ($inputData) {
                return $data['user_id'] === $inputData['user_id'] && $data['balance'] === 0;
            }));

        $result = $createWalletUseCase->execute($createWalletInputDto);

        $this->assertEquals(['message' => 'Wallet created successfully'], $result);
    }

    public function testExecuteWithException(): void
    {
        $inputData = ['user_id' => 1];

        $createWalletInputDto = CreateWalletInputDto::create($inputData);

        $createWalletUseCase = CreateWalletUseCase::create($this->walletGatewayMock);

        $this->walletGatewayMock
            ->method('save')
            ->will($this->throwException(new \Exception('Error saving wallet')));

        $result = $createWalletUseCase->execute($createWalletInputDto);

        $this->assertEquals(['message' => 'Error saving wallet'], $result);
    }
}
