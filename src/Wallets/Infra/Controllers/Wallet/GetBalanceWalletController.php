<?php

declare(strict_types=1);

namespace Src\Wallets\Infra\Controllers\Wallet;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Src\Wallets\Application\Queries\GetBalanceWallet\GetBalanceWalletQuery;
use Src\Wallets\Application\Queries\GetBalanceWallet\GetBalanceWalletQueryHandler;
use Src\Wallets\Infra\Controllers\Controller;

class GetBalanceWalletController extends Controller
{
    public function __construct(private GetBalanceWalletQueryHandler $query)
    {
    }

    public function execute(Request $request): JsonResponse
    {
        $getBalanceCommand = new GetBalanceWalletQuery((int) $request->route('id'));

        $getBalance = $this->query->handle($getBalanceCommand);

        if(!$getBalance['success']){
            return response()->json([
                'message' => $getBalance['message']
            ], Response::HTTP_BAD_REQUEST);
        }
        

        return response()->json([
            'balance' => $getBalance['balance']
        ], Response::HTTP_OK);
    }
}