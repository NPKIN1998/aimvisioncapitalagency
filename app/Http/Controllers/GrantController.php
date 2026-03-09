<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\User;
use App\Models\Grant;
use Illuminate\View\View;
use App\Models\Transaction;
use App\Models\ReferralBonus;
use App\Enums\TransactionType;
use App\Services\ShortCodeService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\GrantRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Notifications\UplineBonusNotification;


class GrantController extends Controller
{
    protected $shortcodeService;

    public function __construct(ShortCodeService $shortcodeService)
    {
        $this->shortcodeService = $shortcodeService;
    }
    public function index(): View
    {
        $user = Auth::user();

        $grants = Grant::where('user_id', $user->id)->orderBy('date', 'desc')->get();

        // dd($grants->toArray());
        return view('user.investmentmodel.grant', compact('grants'));
    }

    public function store(GrantRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $amount = $request->validated('amount');

        // Validate minimum amount

        if ($amount < 2500) {
            $message = <<<HTML
                    Grant Amount Too Low

                    • Minimum required: <strong>KES 2,500</strong>
                    • Your entered amount: <strong>KES {number_format($amount, 2)}</strong>

                    Please increase your amount to meet the minimum requirement.
                    HTML;

            return redirect()->route('grant')->with([
                'toast' => [
                    'type' => 'error', // use 'error' for invalid input
                    'title' => 'Application Failed',
                    'message' => $message,
                ],
            ])->withInput();
        }

        DB::beginTransaction();

        try {
            /** @var \App\Models\User $user */
            // Lock the user's record to prevent race conditions
            // User::where('id', $user->id)->lockForUpdate()->first();
            $user->lockForUpdate();

            // Check if user has enough balance
            if ($user->balance < $amount) {
                DB::rollBack();

                $message = sprintf(
                    "Insufficient balance.\n\n• Your available balance: KES %s\n• Required amount: KES %s",
                    number_format($user->balance, 2),
                    number_format($amount, 2)
                );

                return redirect()->route('grant')->with([
                    'toast' => [
                        'type' => 'error',
                        'title' => 'Application Failed',
                        'message' => $message,
                    ],
                ])->withInput();
            }


            // Deduct the amount from the user's balance
            $user->update(['balance' => $user->balance - $amount]);
            // $return = $amount * 0.04 * 30;

            $rate = 0.04; // 4% per day
            $days = 30;

            $return = $amount * pow(1 + $rate, $days); // future value including principal

            // Create the grant record
            Grant::create([
                'user_id' => $user->id,
                'status' => 'active',
                'capital' => $amount,
                'return' => $return,
                'days_paid' => 0,
                'next_payment' => now()->addHours(24),
                'date' => now(),
                'end_date' => now()->addDays($days),
            ]);


            // --- Process 10% referral bonus ---
            if ($user->upline && $user->upline !== 'system') {
                $upline = User::where('username', $user->upline)->first();

                if ($upline) {
                    $bonusAmount = $amount * 0.10; // 10% referral bonus
                    $upline->increment('balance', $bonusAmount);

                    // Log referral bonus
                    ReferralBonus::create([
                        'user_id' => $upline->id,
                        'downline' => $user->id,
                        'amount' => $bonusAmount,
                    ]);

                    // Create transaction
                    Transaction::create([
                        'shortcode' => $this->shortcodeService->generateShortcode(TransactionType::REFERRAL_BONUS),
                        'type' => TransactionType::REFERRAL_BONUS->value,
                        'amount' => $bonusAmount,
                        'user_id' => $upline->id,
                        'status' => 'completed',
                    ]);

                    // Optionally, notify upline
                    try {
                        $upline->notify(new UplineBonusNotification($bonusAmount, $user));
                    } catch (Exception $e) {
                        Log::error('Failed to notify upline', ['error' => $e->getMessage()]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('grant')->with([
                'toast' => [
                    'type' => 'success',
                    'title' => 'Application Successful',
                    'message' => 'Grant request submitted successfully.',
                ],
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('grant')->with([
                'toast' => [
                    'type' => 'error',
                    'title' => 'Application Failed',
                    'message' => 'An error occurred while processing your request.',
                ],
            ]);
        }
    }
}
