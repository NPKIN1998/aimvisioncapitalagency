<?php

namespace App\Data;

use App\Enums\PaymentStatus;
use App\Enums\TransactionType;

class TruelineTransactionData
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $shortcode,
        public readonly TransactionType $type,
        public readonly float $amount,
        public readonly int $userId,
        public readonly PaymentStatus $status,
    ) {}
}
