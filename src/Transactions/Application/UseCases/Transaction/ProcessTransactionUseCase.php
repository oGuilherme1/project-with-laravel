<?php

declare(strict_types=1);

namespace Src\Transactions\Application\UseCases\Transaction;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp;
use GuzzleHttp\Promise\Utils;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Src\Transactions\Application\DTOs\ProcessTransaction\ProcessTransactionDto;
use Src\Transactions\Application\Events\TransactionSuccessful;
use Src\Transactions\Application\Jobs\SendNotificationJob;
use Src\Transactions\Domain\Transaction;
use Src\Transactions\Domain\TransactionGateway;
use Src\Users\Application\DTOs\GetUserType\GetUserTypeDto;
use Src\Users\Application\UseCases\User\GetUserTypeUseCase;
use Src\Users\Domain\UserGateway;
use Src\Wallets\Application\DTOs\CreateWallet\GetBalanceInputDto;
use Src\Wallets\Application\UseCases\Wallet\GetBalanceWalletUseCase;
use Src\Wallets\Domain\WalletGateway;

class ProcessTransactionUseCase
{
    private function __construct(
        private readonly TransactionGateway $transactionGateway,
        private readonly GetBalanceWalletUseCase $walletBalanceUseCase,
        private readonly GetUserTypeUseCase $userTypeUseCase
        )
    {
    }

    public static function create(TransactionGateway $transactionGateway, GetBalanceWalletUseCase $walletBalanceUseCase, GetUserTypeUseCase $userTypeUseCase ): self
    {
        return new self($transactionGateway, $walletBalanceUseCase, $userTypeUseCase);
    }

    public function execute(ProcessTransactionDto $inputDTO): array
    {
        try {

            Log::info('Transaction process started', [$inputDTO->getAll(), 'timestamp' => now()]);

            if($inputDTO->getPayerId() === $inputDTO->getPayeeId()){
                throw new Exception('Payer and Payee cannot be the same user');
            }

            $payeeType = $this->getUserType($inputDTO->getPayeeId());
            $payerType = $this->getUserType($inputDTO->getPayerId());

            $payeeBalance = $this->getWalletBalance($inputDTO->getPayeeId());
            $payerBalance = $this->getWalletBalance($inputDTO->getPayerId());

            $this->validateUserTypes($payerType, $payeeType);
            $this->validateWalletBalances($payerBalance, $payeeBalance, $inputDTO->getAmount());

            $payerNewBalance = $payerBalance - $inputDTO->getAmount();
            $payeeNewBalance = $payeeBalance + $inputDTO->getAmount();



            $transaction = Transaction::create(null, ...$inputDTO->getAll());

            $this->authorizationTransfer();

            $saveTransaction = $this->transactionGateway->save($transaction->toArray());

            if($saveTransaction['success']){

                Log::info('Transaction process completed successfully', ['timestamp' => now()]);

                $this->dispatchEvent($inputDTO->getPayerId(), $payerNewBalance, $inputDTO->getPayeeId(), $payeeNewBalance);

                SendNotificationJob::dispatch();

            } else {
                throw new Exception($saveTransaction['message']);
            }


            // Retorna sucesso
            return [
                'success' => true,
                'message' => 'Transaction completed successfully'
            ];

        } catch (\Exception $e) {

            Log::error('Transaction process failed', [
                'input' => $inputDTO->getAll(),
                'error_message' => $e->getMessage(),
                'timestamp' => now()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private function getUserType(int $userId): string
    {
        try {
            $inputDTO = GetUserTypeDto::create($userId);
            $userType = $this->userTypeUseCase->execute($inputDTO);
            return $userType['user_type'];
        } catch (Exception $e) {
            Log::error('User not found');
            throw new Exception('User not found');
        }

    }
    
    private function getWalletBalance(int $userId): int
    {
        try {
            $inputDTO = GetBalanceInputDto::create(['user_id' => $userId]);
            $balanceWallet = $this->walletBalanceUseCase->execute($inputDTO);
            return $balanceWallet['balance'];
        } catch (Exception $e) {
            Log::error('Wallet not found');
            throw new Exception('Wallet not found');
        }

    }

    private function validateUserTypes(string $payerType, string $payeeType): void
    {
        $messageErrorRequest = 'User not found';

        if ($payerType === $messageErrorRequest || $payeeType === $messageErrorRequest) {
            Log::error('Payee or Payer not found');
            throw new Exception('Payee or Payer not found');
        }

        if($payerType === 'shopkeeper' && $payeeType === 'shopkeeper') {
            Log::error('Shopkeeper cannot transfer to shopkeeper');
            throw new Exception('Shopkeeper cannot transfer to shopkeeper');
        }

        if($payerType === 'shopkeeper' && $payeeType === 'commom') {
            Log::error('Shopkeeper cannot transfer to commom');
            throw new Exception('Shopkeeper cannot transfer to commom');
        }

    }

    private function validateWalletBalances(int $payerBalance, int $payeeBalance, float $amount): void
    {
        $messageErrorRequest = 'Wallet not found';

        if ($payerBalance === $messageErrorRequest || $payeeBalance === $messageErrorRequest) {
            Log::error('Wallet payee or wallet payer not found');
            throw new Exception('Payee or Payer not found');
        }

        if ($payerBalance < $amount) {
            Log::warning('Insufficient wallet balance', [
                'payer_balance' => $payerBalance,
                'amount' => $amount
            ]);
            throw new Exception('Insufficient wallet balance');
        }
    }

    private function authorizationTransfer(): bool
    {
        $client = new Client();
        $url = 'https://util.devi.tools/api/v2/authorize';

        try {
            $response = $client->request('GET', $url);
            $statusCode = $response->getStatusCode();
            $body = json_decode((string) $response->getBody(), true);

            if ($statusCode == 200 && isset($body['status']) && $body['status'] === 'success' && isset($body['data']['authorization']) && $body['data']['authorization'] === true) {
                return true;
            }

            return false;
        } catch (Exception $e) {
            Log::error('Erro ao consultar o serviço autorizador', [
                'error_message' => $e->getMessage()
            ]);
            return throw new Exception('Error on authorization transfer');
        }
    }

    private function dispatchEvent( int $payer_id, int $payer_newBalance, int $payee_id, int $payee_newBalance): void
    {

        event(new TransactionSuccessful($payer_id, $payer_newBalance, $payee_id, $payee_newBalance));
    }
}
