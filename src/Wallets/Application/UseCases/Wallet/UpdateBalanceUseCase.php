<?php

declare(strict_types=1);

namespace Src\Wallets\Application\UseCases\Wallet;

use Exception;
use Src\Wallets\Application\DTOs\CreateWallet\UpdateBalanceWalletDto;
use Src\Wallets\Domain\WalletGateway;

class UpdateBalanceUseCase
{
    private function __construct(private readonly WalletGateway $walletGateway)
    {
        
    }
    
    public static function create(WalletGateway $walletGateway): self
    {
        return new self($walletGateway);
    }
    
    public function execute(UpdateBalanceWalletDto $inputDTO): array
    {
        try{

            $wallet = $this->walletGateway->getWallet($inputDTO->getUserId());

            if($wallet == null){
                throw new Exception('Wallet not found', 404);
            }

            $this->walletGateway->updateBalance($inputDTO->getUserId(), $inputDTO->getNewBalance());

            return ['message' => 'Balance updated successfully'];
        }
        catch (Exception $e) {
           
            return  ['message' => $e->getMessage()];
        }

    }
}