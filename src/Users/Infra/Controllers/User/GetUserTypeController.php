<?php

declare(strict_types=1);

namespace Src\Users\Infra\Controllers\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Src\Users\Application\Commands\GetUserType\GetUserTypeCommand;
use Src\Users\Application\Commands\GetUserType\GetUserTypeCommandHandler;
use Src\Users\Infra\Controllers\Controller;

class GetUserTypeController extends Controller
{
    public function __construct(private GetUserTypeCommandHandler $command)
    {
    }

    public function execute(Request $request): JsonResponse
    {

        $getUserTypeCommand = new GetUserTypeCommand((int) $request->route('id'));

        $getUserType = $this->command->handle($getUserTypeCommand);

        if(!$getUserType['success']){
            return response()->json([
                'error' => $getUserType['message']
            ], Response::HTTP_BAD_REQUEST);
            
        }

        return response()->json([
            'user_type' => $getUserType['user_type']
        ], Response::HTTP_OK);
    }
}