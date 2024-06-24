<?php 

declare(strict_types=1);

namespace Src\Users\Application\UseCases\User;

use Exception;
use Src\Users\Application\DTOs\CreateUser\CreateUserInputDto;
use Src\Users\Application\Events\UserCreated;
use Src\Users\Domain\User;
use Src\Users\Domain\UserGateway;

class CreateUserUseCase 
{
    private function __construct(private readonly UserGateway $userGateway)
    {
        
    }

    public static function create(UserGateway $userGateway): self
    {
        return new self($userGateway);
    }

    public function execute(CreateUserInputDto $inputDTO): array
    {
        try{

            $this->checkEmailExisting($inputDTO->getEmail());
            
            $this->checkDocumentExisting($inputDTO->getDocument());

            $aUser = User::create(null, ...$inputDTO->getAll());

            $this->userGateway->save($aUser->toArray());

            $this->dispatchEvent($aUser);

            return [
                'message' => 'User created successfully',
                'success' => true
            ];
        }
        catch (Exception $e) {
           
            return  [
                'message' => $e->getMessage(),
                'success' => false
            ];
        }
    }

    private function checkEmailExisting(string $email): void
    {
        if ($this->userGateway->findEmail($email)) {
            throw new Exception('This email already exists ' . $email, 409);
        }
    }

    private function checkDocumentExisting(string $document): void
    {
        if ($this->userGateway->findDocument($document)) {
            throw new Exception('This document already exists ', 409);
        }
    }

    private function dispatchEvent(User $user): void
    {
        $userId = $this->userGateway->get($user->toArray()['document']);

        event(new UserCreated($userId['id']));
    }
}