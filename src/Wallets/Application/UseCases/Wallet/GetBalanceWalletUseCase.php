<?php

declare(strict_types=1);

namespace Src\Wallets\Application\UseCases\Wallet;

use Exception;
use Src\Wallets\Application\DTOs\CreateWallet\GetBalanceInputDto;
use Src\Wallets\Domain\WalletGateway;

class GetBalanceWalletUseCase
{
    private function __construct(private readonly WalletGateway $walletGateway)
    {
    }

    public static function create(WalletGateway $walletGateway): self
    {
        return new self($walletGateway);
    }

    public function execute(GetBalanceInputDto $inputDTO): array
    {
        try {

            $balance = $this->walletGateway->getBalance($inputDTO->getUserId());
            

            if($balance === null){
                throw new Exception("Wallet not found");
            };
            
            
            return [
                'balance' => $balance,
                'success' => true
            ];

        } catch (Exception $e) {

            return  [
                'message' => $e->getMessage(),
                'success' => false
            ];
        }
    }
}
