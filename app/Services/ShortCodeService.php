<?php

namespace App\Services;

use App\Enums\TransactionType;
use Carbon\Carbon;
use InvalidArgumentException;

class ShortCodeService
{
    // Define the characters for random string generation
    private const RANDOM_CHARACTERS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    /**
     * Generate a shortcode for a transaction.
     *
     * @param TransactionType $type The type of transaction.
     * @return string The generated shortcode.
     */
    public function generateShortcode(TransactionType $type): string
    {
        // Get the prefix for the transaction type
        $prefix = $type->prefix();

        // Generate the timestamp portion (e.g., YYYYMMDDHHMMSS)
        $timestamp = now()->format('YmdHis');

        // Generate a random string
        $random = $this->generateRandomString(5);

        // Combine prefix, timestamp, and random characters
        return $prefix . $timestamp . $random;
    }

    /**
     * Decode a shortcode to extract its components.
     *
     * @param string $shortcode The shortcode to decode.
     * @return array An array containing the transaction type, timestamp, and random part.
     * @throws InvalidArgumentException If the shortcode is invalid.
     */
    public function decodeShortcode(string $shortcode): array
    {
        // Validate the shortcode length
        if (strlen($shortcode) < 20) {
            throw new InvalidArgumentException("Invalid shortcode: too short.");
        }

        // Extract the prefix (first character)
        $prefix = $shortcode[0];

        // Map prefix to transaction type
        $type = TransactionType::tryFromPrefix($prefix);
        if (!$type) {
            throw new InvalidArgumentException("Invalid shortcode prefix: {$prefix}");
        }

        // Extract the timestamp (next 14 characters)
        $timestamp = substr($shortcode, 1, 14);

        // Extract the random part (remaining characters)
        $random = substr($shortcode, 15);

        return [
            'type' => $type,
            'timestamp' => Carbon::createFromFormat('YmdHis', $timestamp),
            'random' => $random,
        ];
    }

    /**
     * Generate a random string of a specified length.
     *
     * @param int $length The length of the random string.
     * @return string The generated random string.
     */
    protected function generateRandomString(int $length): string
    {
        $randomString = '';
        $maxIndex = strlen(self::RANDOM_CHARACTERS) - 1;

        for ($i = 0; $i < $length; $i++) {
            $randomString .= self::RANDOM_CHARACTERS[rand(0, $maxIndex)];
        }

        return $randomString;
    }
}
