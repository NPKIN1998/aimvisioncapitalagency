<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Exceptions\ConcurrentModificationException;
use App\Exceptions\ConflictException;
use App\Exceptions\InsufficientBalanceException;
use App\Exceptions\TransactionFailedException;
use App\Models\Property;
use App\Models\Rent;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RentPropertyService
{
    public function  __construct(private ShortCodeService $shortcodeService) {}

    public function purchaseRental(User $user, int $propertyId): void
    {
        $property = Property::findOrFail($propertyId);

        // Validate purchase conditions
        if ($user->balance < $property->capital) {
            Log::info("User Balance Check", [
                'user_balance' => $user->balance,
                'property_capital' => $property->capital,
            ]);
            throw new InsufficientBalanceException(
                "Insufficient balance. Required: {$property->capital}, Available: {$user->balance}"
            );
        }

        if ($user->activeRentals()->where('property_id', $propertyId)->exists()) {
            throw new ConflictException('You already own this rental property.');
        }

        DB::beginTransaction();
        try {
            // Safely update balance with fresh check
            $updated = DB::table('users')
                ->where('id', $user->id)
                ->where('balance', '>=', $property->capital)
                ->update([
                    'balance' => DB::raw("balance - {$property->capital}"),
                    'updated_at' => now()
                ]);

            if ($updated !== 1) {
                Log::warning("User Balance Update Failed", [
                    'user_id' => $user->id,
                    'property_capital' => $property->capital,
                    'updated_rows' => $updated
                ]);
                throw new ConcurrentModificationException('Balance update failed. Please try again.');
            }

            // Refresh user model
            $user->refresh();

            // Create the rental record
            $rental = Rent::create([
                'user_id' => $user->id,
                'property_id' => $property->id,
                'date' => now(),
                'days_paid' => 0,
                'next_payment' => now()->addHours(24),
                'capital' => $property->capital,
                'end_date' => now()->addDays(30),
                'status' => 'active'
            ]);

            // Generate a unique shortcode for the transaction
            $shortcode = $this->shortcodeService->generateShortcode(TransactionType::RENTAL_PURCHASE);

            // Create a transaction record
            $tra =  Transaction::create([
                'shortcode' => $shortcode,
                'type' => TransactionType::RENTAL_PURCHASE->value,
                'amount' => $property->capital,
                'user_id' => $user->id,
                'status' => 'active',
            ]);

            DB::commit();

            // Dispatch events after successful transaction
            // RentalPurchased::dispatch($rental);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Rental purchase failed for user {$user->id}", [
                'error' => $e->getMessage(),
                'property' => $propertyId,
                'balance_attempt' => $property->capital
            ]);
            throw new TransactionFailedException('Failed to complete rental purchase. Please try again.');
        }
    }
}
