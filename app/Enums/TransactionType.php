<?php

namespace App\Enums;

enum TransactionType: string
{
    case DEPOSIT = 'deposit';
    case WITHDRAWAL = 'withdrawal';
    case REFERRAL_BONUS = 'referral_bonus';
    case INVESTMENT = 'investment';
    case RENTAL_PURCHASE = 'rental_purchase';
    case TASK_REWARD = 'task_reward';

    /**
     * Get all values of the enum.
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get the prefix for the transaction type.
     *
     * @return string
     */
    public function prefix(): string
    {
        return match ($this) {
            self::DEPOSIT => 'D',
            self::WITHDRAWAL => 'W',
            self::REFERRAL_BONUS => 'R',
            self::INVESTMENT => 'I',
            self::RENTAL_PURCHASE => 'RP',
            self::TASK_REWARD => 'TR',
        };
    }

    /**
     * Try to get a TransactionType from its prefix.
     *
     * @param string $prefix The prefix to map.
     * @return TransactionType|null
     */
    public static function tryFromPrefix(string $prefix): ?TransactionType
    {
        return match ($prefix) {
            'D' => self::DEPOSIT,
            'W' => self::WITHDRAWAL,
            'R' => self::REFERRAL_BONUS,
            'I' => self::INVESTMENT,
            'RP' => self::RENTAL_PURCHASE,
            'TR' => self::TASK_REWARD,
            default => null,
        };
    }
}
