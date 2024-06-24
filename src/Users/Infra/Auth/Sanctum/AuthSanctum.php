<?php 

declare(strict_types=1);

namespace Src\Users\Infra\Auth\Sanctum;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Src\Users\Application\UseCases\Auth\LoginGateway;


class AuthSanctum implements LoginGateway
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $token = $request->user()->createToken('auth-user')->plainTextToken;
            return response()->json(['token' => $token], 200);
        }
    
        return response()->json(['error' => 'Credenciais inválidas'], 401);
    }

}