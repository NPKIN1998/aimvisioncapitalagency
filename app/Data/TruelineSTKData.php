<?php

namespace App\Data;

class TruelineSTKData
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly float $amount,
        public readonly string $phoneNumber,
        public readonly int $userId,
        public readonly string $orderNo,
    ) {}

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'phone_number' => $this->phoneNumber,
            'user_reference' => $this->userId,
            'orderNo' => $this->orderNo,
        ];
    }
}
