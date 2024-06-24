<?php 

declare(strict_types=1);

namespace Src\Users\Application\UseCases\Auth;

use Exception;
use Src\Users\Application\DTOs\Login\LoginInputDto;

class LoginUseCase
{
    private function __construct(private readonly LoginGateway $loginGateway)
    {
        
    }

    public static function create(LoginGateway $loginGateway): self
    {
        return new self($loginGateway);
    }

    public function execute(LoginInputDto $inputDTO): array
    {
        try{
            $token = $this->loginGateway->login($inputDTO->getRequest());
            return [
                'token' => $token->original["token"],
                'status' => true
            ];
        }
        catch (Exception $e) {
           
            return  [
                'error' => $e->getMessage(),
                'status' => false
            ];
        }
    }
}