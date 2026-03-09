<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Rent;
use App\Models\User;
use Illuminate\View\View;
use App\Models\Investment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Enums\TransactionType;
use App\Services\ShortCodeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function __construct(private ShortCodeService $shortcodeService) {}

    public function index(): View
    {
        $user = Auth::user();
        $today = Carbon::now()->timezone(config('app.timezone'))->toDateString();


        // Fetch user's active investments with their packages
        $investments = Investment::where('user_id', $user->id)
            ->where('status', 'active') // Only consider active investments
            ->with('package')
            ->get();
        // dd($investments);



        $rents = Rent::where('user_id', $user->id)
            ->where('status', 'active') // Only consider active investments
            ->with('property')
            ->get();

        // dd($rents->toArray());
        return view('user.todo.task', compact([
            'investments',
            'rents',
        ]));
    }

    public function dailyTask(Request $request)
    {
        Log::info('Daily Task request received.', [
            'user_id' => $request->user()->id,
            'request_data' => $request->all()
        ]);

        $request->validate([
            'investment_id' => 'required|exists:investments,id',
        ]);

        $user = $request->user();
        $investment = Investment::find($request->investment_id);

        // Basic ownership and active status validation
        if (!$investment || $investment->user_id !== $user->id || $investment->status !== 'active') {

            Log::warning('Daily Task validation failed: invalid or inactive investment.', [
                'user_id' => $user->id,
                'investment_id' => $request->investment_id,
                'investment_status' => $investment->status ?? null
            ]);

            return back()->with([
                'toast' => [
                    'type' => 'error',
                    'title' => 'Invalid Investment',
                    'message' => 'The selected investment is invalid or not active.',
                ],
            ]);
        }

        $packageDays = $investment->package->days;         // e.g., 20 days
        $daysPaid = $investment->days_paid;                 // days the user has been paid so far
        $nextPayment = Carbon::parse($investment->next_payment);
        $now = Carbon::now();

        // RULE 1: User must not exceed the package days
        if ($daysPaid >= $packageDays) {

            Log::info('Investment already completed.', [
                'user_id' => $user->id,
                'investment_id' => $investment->id,
                'days_paid' => $daysPaid,
                'package_days' => $packageDays,
            ]);

            return back()->with([
                'toast' => [
                    'type' => 'info',
                    'title' => 'Investment Completed',
                    'message' => 'You have already completed all daily tasks for this investment.',
                ],
            ]);
        }

        // RULE 2: Check if next_payment is today or earlier
        // Allow if next_payment <= now
        if ($nextPayment->isFuture()) {

            Log::warning('Daily task attempted too early.', [
                'user_id' => $user->id,
                'investment_id' => $investment->id,
                'next_payment' => $investment->next_payment,
            ]);

            return back()->with([
                'toast' => [
                    'type' => 'error',
                    'title' => 'Task Not Available',
                    'message' => 'You cannot complete the daily task before the next available task date.',
                ],
            ]);
        }

        // RULE 3: User may have skipped days → Update daysPaid correctly
        // Count how many days passed from the last payment date up to today
        $daysDiff = $nextPayment->diffInDays($now) + 1; // +1 ensures today is counted

        // Cap so that user cannot exceed package days
        $payableDays = min($daysDiff, $packageDays - $daysPaid);

        Log::info('Days calculation for task:', [
            'user_id' => $user->id,
            'investment_id' => $investment->id,
            'days_diff' => $daysDiff,
            'payable_days' => $payableDays,
            'current_days_paid' => $daysPaid,
            'package_days' => $packageDays,
        ]);

        // RULE 4: Pay user for the calculated number of days
        for ($i = 0; $i < $payableDays; $i++) {
            $this->payMember($user, $investment);
            $investment->days_paid += 1;
        }

        // RULE 5: Update next_payment date properly
        $investment->next_payment = $now->addDay()->startOfDay();

        // RULE 6: Mark completed if days_paid == package days
        if ($investment->days_paid >= $packageDays) {
            $investment->status = 'completed';

            Log::info('Investment auto-completed.', [
                'user_id' => $user->id,
                'investment_id' => $investment->id
            ]);
        }

        $investment->save();

        Log::info('Daily Task completed successfully.', [
            'user_id' => $user->id,
            'investment_id' => $investment->id,
            'new_days_paid' => $investment->days_paid,
            'next_payment' => $investment->next_payment,
        ]);

        return back()->with([
            'toast' => [
                'type' => 'success',
                'title' => 'Task Completed',
                'message' => 'You have successfully completed your daily task.',
            ],
        ]);
    }


    protected function payMember(User $user, Investment $investment): void
    {
        $amount = $investment->package->daily_income_percentage;
        $shortcode = $this->shortcodeService->generateShortcode(TransactionType::TASK_REWARD);

        // Create transaction record
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'investment_id' => $investment->id,
            'amount' => $amount,
            'type' => TransactionType::TASK_REWARD->value,
            'status' => 'completed',
            'shortcode' => $shortcode,
        ]);

        // Update user balance
        $user->increment('balance', $amount);

        // Update investment next payment date
        $investment->update([
            'days_paid' => $investment->days_paid + 1,
            'next_payment' => now()->copy()->addDays(1),
            'updated_at' => now(),
            'status' => $investment->days_paid + 1 >= $investment->package->days ? 'completed' : $investment->status,
        ]);

        Log::info("Paid {$amount} to user {$user->id} for pa investment {$investment->id}", [
            'transaction_id' => $transaction->id,
            'new_balance' => $user->balance,
        ]);
    }
}
