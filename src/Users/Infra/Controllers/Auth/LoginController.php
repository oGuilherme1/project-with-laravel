<?php

namespace Src\Users\Infra\Controllers\Auth;

use Illuminate\Http\JsonResponse;

use Src\Users\Application\Commands\Login\LoginCommandHandler;
use Symfony\Component\HttpFoundation\Response;
use Src\Users\Infra\Controllers\Controller;
use Src\Users\Infra\Requests\Auth\LoginRequest;


class LoginController extends Controller
{
    public function __construct(private LoginCommandHandler $command)
    {
    }

    public function execute(LoginRequest $request): JsonResponse
    {
        
        $token = $this->command->handle($request->toCommand());

        if(!$token['status']){
            return response()->json([
                'error' => $token['error']
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'token' => $token['token']
        ], Response::HTTP_OK);


    }
}
