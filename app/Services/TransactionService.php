<?php

namespace App\Services;

use App\Data\TransactionData;
use App\Models\Transaction;

class TransactionService
{
    public function createTransaction(TransactionData $transactionData): Transaction
    {
        // Use the DTO to create a transaction
        return Transaction::create($transactionData->toArray());
    }
}
