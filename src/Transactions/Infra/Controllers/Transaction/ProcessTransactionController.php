<?php

declare(strict_types=1);

namespace Src\Transactions\Infra\Controllers\Transaction;

use Illuminate\Http\Response;
use Src\Transactions\Application\Commands\ProcessTransaction\ProcessTransactionCommandHandler;
use Src\Transactions\Infra\Controllers\Controller;
use Src\Transactions\Infra\Requests\Transaction\ProcessTransactionRequest;

class ProcessTransactionController extends Controller
{

    public function __construct(private ProcessTransactionCommandHandler $command)
    {
    }

    public function execute(ProcessTransactionRequest $request)
    {
        $processTransaction = $this->command->handle($request->toCommand());

        if(!$processTransaction['success']){

            return response()->json([
                'message' => $processTransaction['message']
            ], Response::HTTP_BAD_REQUEST);
            
        }

        return response()->json([
            'message' => $processTransaction['message']
        ], Response::HTTP_OK);
    }
}