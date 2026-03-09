<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cashout;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\CashoutRequest;

class CashoutController extends Controller
{
    protected string $baseUrl;
    protected string $username;
    protected string $password;
    protected int $channelId;

    public function __construct()
    {
        $this->baseUrl = config('payhero.cashout_api_url');
        $this->username = config('payhero.cashout_api_username');
        $this->password = config('payhero.cashout_api_password');
        $this->channelId = config('payhero.cashout_channel_id');
    }
    public function index(): View
    {
        return view('user/cashout');
    }

    public function store(CashoutRequest $request)
    {
        $user = $request->user();

        Log::info("Cashout request initiated by {$user->username}.", $request->validated());

        $requestedAmount  = (float) $request->input('amount');
        $availableBalance = (float) $user->balance;

        /*
    |--------------------------------------------------------------------------
    | 1. Eligibility Rule: Active Plan OR Active Downline Activity
    |--------------------------------------------------------------------------
    */

        $hasActivePlan = $user->status === 'active';

        $hasQualifiedDownline = $user->downlines()
            ->whereHas('investments', fn($q) => $q->where('status', 'active'))
            ->orWhereHas('rentals', fn($q) => $q->where('status', 'active'))
            ->orWhereHas('grants', fn($q) => $q->where('status', 'active'))
            ->exists();

        if (!$hasActivePlan && !$hasQualifiedDownline) {
            return redirect()->route('cashout')->with([
                'toast' => [
                    'type' => 'error',
                    'title' => 'Withdrawal Not Allowed',
                    'message' => "You are not eligible for cashout. You must either have an active plan or have referred at least one person with an active investment, rental, or grant.",
                ],
            ]);
        }

        /*
    |--------------------------------------------------------------------------
    | 2. Cooldown Rule: One Cashout Every 24 Hours
    |--------------------------------------------------------------------------
    */

        $lastCashout = Cashout::where('username', $user->username)
            ->latest()
            ->first();

        if ($lastCashout && $lastCashout->created_at->gt(now()->subHours(24))) {

            $nextAllowedTime = $lastCashout->created_at->clone()->addHours(24);

            $hoursLeft   = now()->diffInHours($nextAllowedTime);
            $minutesLeft = now()->diffInMinutes($nextAllowedTime) % 60;

            $message = sprintf(
                "You can only make one cashout every 24 hours.\n\n" .
                    "• Last Cashout: %s\n" .
                    "• Next Allowed Time: %s\n\n" .
                    "Please try again in %d hour(s) %d minute(s).",
                $lastCashout->created_at->format('d M Y, h:i A'),
                $nextAllowedTime->format('d M Y, h:i A'),
                $hoursLeft,
                $minutesLeft
            );

            return redirect()->route('cashout')->with([
                'toast' => [
                    'type' => 'info',
                    'title' => 'Cooldown Active',
                    'message' => $message,
                ],
            ]);
        }

        /*
    |--------------------------------------------------------------------------
    | 3. Balance Check
    |--------------------------------------------------------------------------
    */

        if ($availableBalance < $requestedAmount) {

            $message = "Your balance is insufficient for this cashout request.\n\n" .
                "• Available Balance: KES " . number_format($availableBalance, 2) . "\n" .
                "• Requested Amount: KES " . number_format($requestedAmount, 2);

            return redirect()->route('cashout')->with([
                'toast' => [
                    'type' => 'error',
                    'title' => 'Insufficient Balance',
                    'message' => $message,
                ],
            ]);
        }

        /*
    |--------------------------------------------------------------------------
    | 4. Compute Deductions & Prepare Cashout Payload
    |--------------------------------------------------------------------------
    */

        $charge        = $requestedAmount * 0.10;
        $netAmount     = $requestedAmount - $charge;

        $cashoutData              = $request->validated();
        $cashoutData['username']  = $user->username;
        $cashoutData['Charge']    = $charge;

        /*
    |--------------------------------------------------------------------------
    | 5. Update User Balance (Atomic)
    |--------------------------------------------------------------------------
    */

        $newBalance = $availableBalance - $requestedAmount;
        $user->update(['balance' => $newBalance]);

        Log::info("Balance updated for {$user->username}. New balance: {$newBalance}");

        /*
    |--------------------------------------------------------------------------
    | 6. Create Cashout Record
    |--------------------------------------------------------------------------
    */

        $cashout = $user->cashouts()->create($cashoutData);

        Log::info("Cashout record {$cashout->id} created for {$user->username}.");

        /*
    |--------------------------------------------------------------------------
    | 7. External API Request
    |--------------------------------------------------------------------------
    */

        $reference = "cashout_{$user->id}_" . uniqid();

        $payload = [
            "external_reference" => $reference,
            "amount"            => (float) $netAmount,
            "phone_number"      => $request->phone,
            "network_code"      => $request->method === 'mpesa' ? "63902" : "63903",
            "callback_url"      => config('payhero.cashout_callback_url'),
            "channel"           => "mobile",
            "channel_id"        => $this->channelId,
            "payment_service"   => "b2c",
        ];

        $response = Http::withBasicAuth($this->username, $this->password)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($this->baseUrl, $payload);

        Log::info("Cashout API Response for {$user->username}:", $response->json());

        // Handle API failure professionally
        if (!$response->successful()) {
            // Log full context for internal visibility
            Log::error("Cashout API request failed for {$user->username}.", [
                'payload'   => $payload,
                'response'  => $response->json(),
                'status'    => $response->status()
            ]);
            // User-facing message with no HTML tags
            return redirect()->route('cashout')->with([
                'toast' => [
                    'type'    => 'info',
                    'title'   => 'Cashout Pending Review',
                    'message' => 'Your cashout request could not be processed automatically. Our team will review and update it shortly.',
                ],
            ]);
        }

        return redirect()->route('cashout')->with([
            'toast' => [
                'type'    => 'success',
                'title'   => 'Cashout Submitted',
                'message' => 'Your cashout request has been submitted successfully.',
            ],
        ]);
    }


    public function handle(Request $request)
    {
        // Handle the callback from Payhero for cashouts
        $payload = $request->all();
        Log::info('Received cashout callback from Payhero:', $payload);
    }
}
