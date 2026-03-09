<?php

namespace App\Data;

use Carbon\Carbon;

class InvestmentData
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly int $userId,
        public readonly int $packageId,
        public readonly float $capital,
        public readonly string $status,
        public readonly int $daysPaid,
        public readonly Carbon $nextPayment,
        public readonly string $date,
        public readonly string $endDate,
        public readonly float $return,
    ) {}

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'package_id' => $this->packageId,
            'status' => $this->status,
            'capital' => $this->capital,
            'days_paid' => $this->daysPaid,
            'next_payment' => $this->nextPayment,
            'date' => $this->date,
            'end_date' => $this->endDate,
            'return' => $this->return,
        ];
    }
}
