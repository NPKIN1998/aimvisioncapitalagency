<?php

namespace App\Data;

use App\Enums\PaymentStatus;
use App\Enums\TransactionType;

class TransactionData
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

    public function toArray(): array
    {
        return [
            'shortcode' => $this->shortcode,
            'type' => $this->type->value,
            'amount' => $this->amount,
            'user_id' => $this->userId,
            'status' => $this->status->value,
        ];
    }
}
