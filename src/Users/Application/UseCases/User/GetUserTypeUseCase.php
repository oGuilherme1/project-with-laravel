<?php

declare(strict_types=1);

namespace Src\Users\Application\UseCases\User;

use Exception;
use Src\Users\Application\DTOs\GetUserType\GetUserTypeDto;
use Src\Users\Domain\UserGateway;

class GetUserTypeUseCase
{

    private function __construct(
        private readonly UserGateway $userGateway
    )
    {
        
    }

    public static function create(UserGateway $userGateway): self
    {
        return new self($userGateway);
    }   

    public function execute(GetUserTypeDto $inputDTO): array
    {   
        try{
            $userType = $this->userGateway->getUserType($inputDTO->getId());
            
            if($userType == null){
                throw new Exception('User not found');
            }

            return [
                'user_type' => $userType,
                'success' => true
            ];
            
        } catch(Exception $e){

            return  [
                'message' => $e->getMessage(),
                'success' => false
            ];
        }

    }
    
}