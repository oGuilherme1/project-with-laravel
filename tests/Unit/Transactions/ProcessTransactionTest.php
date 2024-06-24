<?php

declare(strict_types=1);



namespace Tests\Unit\Transactions;


use PHPUnit\Framework\TestCase;

use Src\Transactions\Application\DTOs\ProcessTransaction\ProcessTransactionDto;
use Src\Transactions\Domain\TransactionGateway;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Transactions\Application\UseCases\Transaction\ProcessTransactionUseCase;
use Src\Users\Application\DTOs\GetUserType\GetUserTypeDto;
use Src\Users\Application\UseCases\User\GetUserTypeUseCase;
use Src\Wallets\Application\DTOs\CreateWallet\GetBalanceInputDto;
use Src\Wallets\Application\UseCases\Wallet\GetBalanceWalletUseCase;

class ProcessTransactionTest extends TestCase
{
    use RefreshDatabase; // Utilize se precisar de um banco de dados limpo para testes

    public function testSuccessfulTransaction()
    {
        // Configuração dos mocks e classes necessárias
        $transactionGatewayMock = $this->createMock(TransactionGateway::class);
        $walletBalanceUseCaseMock = $this->createMock(GetBalanceWalletUseCase::class);
        $userTypeUseCaseMock = $this->createMock(GetUserTypeUseCase::class);

        // Configuração dos dados de entrada para a transação
        $inputDTO = ProcessTransactionDto::create([
            'amount' => 100,
            'payer' => 1,
            'payee' => 2

            // Outros campos do DTO conforme necessário
        ]);

        // Configuração dos mocks para retornar valores esperados
        $walletBalanceUseCaseMock->expects($this->any())
            ->method('execute')
            ->willReturnMap([
                [GetBalanceInputDto::create(['user_id' => 1]), ['balance' => 500]], // Simula saldo do pagador
                [GetBalanceInputDto::create(['user_id' => 2]), ['balance' => 200]], // Simula saldo do recebedor
            ]);

        $userTypeUseCaseMock->expects($this->any())
            ->method('execute')
            ->willReturnMap([
                [GetUserTypeDto::create(1), ['user_type' => 'common']], // Simula tipo de usuário do pagador
                [GetUserTypeDto::create(2), ['user_type' => 'shopkeeper']], // Simula tipo de usuário do recebedor
            ]);

        $transactionGatewayMock->expects($this->once())
            ->method('save')
            ->willReturn(['success' => true]);

        // Instância do caso de uso
        $useCase = ProcessTransactionUseCase::create($transactionGatewayMock, $walletBalanceUseCaseMock, $userTypeUseCaseMock);

        // Executa o caso de uso
        $result = $useCase->execute($inputDTO);

        // Verificações de resultado esperado
        $this->assertTrue($result['success']);
        $this->assertEquals('Transaction completed successfully', $result['message']);
    }
}

