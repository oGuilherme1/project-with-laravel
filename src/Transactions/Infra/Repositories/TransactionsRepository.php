<?php

declare(strict_types=1);

namespace Src\Transactions\Infra\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Src\Transactions\Domain\TransactionGateway;
use Src\Transactions\Infra\Models\Transaction;

class TransactionsRepository implements TransactionGateway
{
    public function save(array $data): array
    {
        DB::beginTransaction();

        try {


            $data['status'] = 'successful';


            Transaction::create($data);

            DB::commit();

            return [
                'message' => 'Transaction saved successfully',
                'success' => true
            ];

        } catch (Exception $e) {

            DB::rollBack();

            return [
                'message' => 'Error saving transaction: ' . $e->getMessage(),
                'success' => false
            ];
        }
    }
}