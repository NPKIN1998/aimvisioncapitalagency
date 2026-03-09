<?php

namespace App\Data;

class TruelineCallbackData
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $transactionCode,
        public readonly float $amount,
        public readonly int $userId,
    ) {}
}
