<?php

namespace App\Services;

use App\Data\InvestmentData;
use App\Enums\TransactionType;
use App\Models\Investment;
use App\Models\Package;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\InvestmentCreatedNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvestmentService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private ShortCodeService $shortcodeService) {}

    public function createInvestment(User $user, int $planId): void
    {

        $plan = Package::findOrFail($planId);
        $capital = $plan->initial_capital;

        // Check if the user has sufficient balance
        if ($user->balance < $capital) {
            throw new Exception('Insufficient balance to apply for this plan.');
        }

        DB::beginTransaction();

        try {
            // Deduct initial capital from user's balance and update investments
            User::where('id', $user->id)->decrement('balance', $capital);
            User::where('id', $user->id)->increment('investments', $capital);
            $user->update(['status' => 'active']);

            // Create investment
            $investmentData = new InvestmentData(
                userId: $user->id,
                packageId: $plan->id,
                capital: $capital,
                status: 'active',
                daysPaid: 0,
                nextPayment: Carbon::now()->addDays(1)->timezone(config('app.timezone')),
                date: Carbon::now()->timezone(config('app.timezone'))->toDateString(),
                endDate: Carbon::now()->addDays($plan->days)->timezone(config('app.timezone'))->toDateString(),
                return: $plan->daily_income_percentage,
            );

            // dd($investmentData->toArray());
            $investment = Investment::create($investmentData->toArray());

            // Generate a unique shortcode for the transaction
            $shortcode = $this->shortcodeService->generateShortcode(TransactionType::INVESTMENT);

            // Create a transaction record
            Transaction::create([
                'shortcode' => $shortcode,
                'type' => TransactionType::INVESTMENT->value,
                'amount' => $capital,
                'user_id' => $user->id,
                'status' => 'active',
            ]);

            // Log investment creation
            Log::info('Investment created successfully.', [
                'user_id' => $user->id,
                'investment_id' => $investment->id,
                'capital' => $capital,
            ]);

            // Notify user about the investment
            $user->notify(new InvestmentCreatedNotification($investment));

            // Commit the transaction
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Investment creation failed.', [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
            ]);

            throw $e;
        }
    }
}
