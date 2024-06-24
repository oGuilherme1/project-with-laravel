<?php 

declare(strict_types=1);

namespace Src\Wallets\Application\UseCases\Wallet;

use Exception;
use Src\Wallets\Application\DTOs\CreateWallet\CreateWalletInputDto;
use Src\Wallets\Domain\Wallet;
use Src\Wallets\Domain\WalletGateway;

class CreateWalletUseCase 
{
    private function __construct(private readonly WalletGateway $walletGateway)
    {
        
    }

    public static function create(WalletGateway $walletGateway): self
    {
        return new self($walletGateway);
    }

    public function execute(CreateWalletInputDto $inputDTO): array
    {
        try{

            $aWallet = Wallet::create(null, ...$inputDTO->getAll());

            $this->walletGateway->save($aWallet->toArray());

            return ['message' => 'Wallet created successfully'];
        }
        catch (Exception $e) {
           
            return  ['message' => $e->getMessage()];
        }
    }
}