<?php

namespace App\Services;

use App\Data\TransactionData;
use App\Data\TruelineCallbackData;
use App\Enums\PaymentStatus;
use App\Enums\TransactionType;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class PaymentProcessor
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private ShortcodeService $shortcodeService,
    ) {}

    public function processPayment(TruelineCallbackData $callbackData): void
    {
        DB::transaction(function () use ($callbackData) {
            $this->recordDeposit($callbackData);
            $this->updateUserBalance($callbackData);
            $this->createTransactionRecord($callbackData);
        });
    }

    private function recordDeposit(TruelineCallbackData $data): void
    {
        DB::table('deposits')->insert([
            'method' => 'Mpesa',
            'transaction' => $data->transactionCode,
            'username' => $data->userId,
            'amount' => $data->amount,
            'status' => PaymentStatus::COMPLETED->value,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function updateUserBalance(TruelineCallbackData $data): void
    {
        DB::table('users')
            ->where('id', $data->userId)
            ->update([
                'balance' => DB::raw("balance + {$data->amount}"),
                'deposits' => DB::raw("deposits + {$data->amount}"),
                'updated_at' => now(),
            ]);
    }

    private function createTransactionRecord(TruelineCallbackData $data): void
    {
        $transactionData = new TransactionData(
            shortcode: $this->shortcodeService->generateShortcode(TransactionType::DEPOSIT),
            type: TransactionType::DEPOSIT,
            amount: $data->amount,
            userId: $data->userId,
            status: PaymentStatus::COMPLETED,
        );

        Transaction::create($transactionData->toArray());
    }
}
