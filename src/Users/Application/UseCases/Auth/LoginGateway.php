<?php

declare(strict_types=1);

namespace Src\Users\Application\UseCases\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface LoginGateway 
{
    public function login(Request $request): JsonResponse;
}