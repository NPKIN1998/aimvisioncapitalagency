<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Models\ReferralBonus;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\UplineBonusNotification;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReferralService
{
    protected $shortcodeService;

    public function __construct(ShortCodeService $shortcodeService)
    {
        $this->shortcodeService = $shortcodeService;
    }

    /**
     * Process upline bonus for a user's investment
     */
    public function processUplineBonus(User $user, float $capital): void
    {
        if (!$this->hasValidUpline($user)) {
            return;
        }

        DB::transaction(function () use ($user, $capital) {
            $upline = User::where('username', $user->upline)->first();



            if (!$upline) {
                Log::warning('Upline not found for user', ['user_id' => $user->id]);
                return;
            }

            $bonusAmount = $this->calculateBonus($capital);

            $this->updateUplineBalance($upline, $bonusAmount);
            $this->logBonus($upline, $user, $bonusAmount);

            $referralBonus = $this->createReferralBonus($upline, $user, $bonusAmount);

            Log::info("Referral bonus record created", ['referral_bonus_id' => $referralBonus ? $referralBonus->id : null]);
            $this->createTransaction($upline, $bonusAmount); // Changed to use upline and bonus amount

            $this->notifyUpline($upline, $bonusAmount, $user);
        });
    }

    protected function hasValidUpline(User $user): bool
    {
        return $user->upline && $user->upline !== 'system';
    }

    protected function calculateBonus(float $capital): float
    {
        return $capital * 0.10;
    }

    protected function updateUplineBalance(User $upline, float $bonusAmount): void
    {
        $upline->increment('balance', $bonusAmount);
    }

    protected function logBonus(User $upline, User $downline, float $bonusAmount): void
    {
        Log::info('Upline bonus processed', [
            'upline_id' => $upline->id,
            'downline_id' => $downline->id,
            'amount' => $bonusAmount
        ]);
    }

    protected function createReferralBonus(User $upline, User $downline, float $bonusAmount): ?ReferralBonus
    {
        try {
            $referralBonus = ReferralBonus::create([
                'user_id' => $upline->id,
                'downline' => $downline->id,
                'amount' => $bonusAmount,
            ]);

            Log::info('Referral bonus created', ['id' => $referralBonus->id]);
            return $referralBonus;
        } catch (\Exception $e) {
            Log::error('Failed to create referral bonus', [
                'error' => $e->getMessage(),
                'upline_id' => $upline->id,
                'downline_id' => $downline->id
            ]);
            return null;
        }
    }

    protected function createTransaction(User $upline, float $bonusAmount): void
    {
        try {
            $transaction = Transaction::create([
                'shortcode' => $this->shortcodeService->generateShortcode(TransactionType::REFERRAL_BONUS),
                'type' => TransactionType::REFERRAL_BONUS->value,
                'amount' => $bonusAmount, // Use bonus amount instead of capital
                'user_id' => $upline->id, // Transaction belongs to upline
                'status' => 'completed',
            ]);
        } catch (Exception $e) {
            Log::error('Failed to create referral transaction', [
                'error' => $e->getMessage(),
                'upline_id' => $upline->id,
                'amount' => $bonusAmount
            ]);
        }
    }

    protected function notifyUpline(User $upline, float $bonusAmount, User $downline): void
    {
        try {
            $upline->notify(new UplineBonusNotification($bonusAmount, $downline));
        } catch (\Exception $e) {
            Log::error('Failed to notify upline', [
                'error' => $e->getMessage(),
                'upline_id' => $upline->id
            ]);
        }
    }
}
