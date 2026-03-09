<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class CurrencyHelper
{
    /**
     * Display a currency amount for the user's country.
     * KES is always the base currency.
     */
    public static function display($amountInKes): string
    {
        $user = Auth::user();
        $country = $user?->country ?? 'KE';

        $rates = config('currency.rates');
        $rateData = $rates[$country] ?? ['rate' => 1, 'symbol' => 'KES'];

        $converted = $amountInKes * $rateData['rate'];

        return $rateData['symbol'] . ' ' . number_format($converted, 2);
    }

    /**
     * Return only the currency symbol for the user's country.
     */
    public static function symbol(): string
    {
        $user = Auth::user();
        $country = $user?->country ?? 'KE';

        $rates = config('currency.rates');

        return $rates[$country]['symbol'] ?? 'KES';
    }

    /**
     * Return the conversion rate for the user's country.
     */
    public static function rate(): float
    {
        $user = Auth::user();
        $country = $user?->country ?? 'KE';

        $rates = config('currency.rates');

        return $rates[$country]['rate'] ?? 1.0;
    }

    public static function format($amount)
    {
        return self::symbol() . number_format($amount * self::rate(), 2);
    }
}
