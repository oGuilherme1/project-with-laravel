<?php

namespace Src\Users\Infra\Controllers\User;

use Illuminate\Http\JsonResponse;

use Src\Users\Application\Commands\CreateUser\CreateUserCommandHandler;
use Symfony\Component\HttpFoundation\Response;
use Src\Users\Infra\Controllers\Controller;
use Src\Users\Infra\Requests\User\CreateUserRequest;

class CreateUserController extends Controller
{
    public function __construct(private CreateUserCommandHandler $command)
    {
    }

    public function execute(CreateUserRequest $request): JsonResponse
    {
        $createUser = $this->command->handle($request->toCommand());

        if(!$createUser['success']){
            return response()->json([
                'message' => $createUser['message']
            ], Response::HTTP_BAD_REQUEST);
            
        }

        return response()->json([
            'message' => $createUser['message']
        ], Response::HTTP_OK);
    }
}
