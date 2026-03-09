<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Data\PayHeroSKTData;
use Illuminate\Http\Request;
use App\Enums\TransactionType;
use App\Services\ShortCodeService;
use Illuminate\Support\Facades\DB;
use App\Services\PayheroSTKService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DepositRequest;
use Illuminate\Http\RedirectResponse;

class DepositController extends Controller
{
    public function __construct(
        private PayheroSTKService $payheroService,
        private ShortCodeService $shortcodeService
    ) {}
    public function index(): View
    {
        return view('user.deposit');
    }

    public function store(DepositRequest $request): RedirectResponse
    {
        $user = Auth::user();

        $depositReference = "dep_{$user->id}_" . uniqid();
        $paymentData = new PayHeroSKTData(
            amount: $request->amount,
            phoneNumber: $request->phone,
            customerName: $user->name,
            externalReference: $depositReference,
            callbackUrl: config('payhero.callback_url')
        );

        try {
            $response = $this->payheroService->createPayment($paymentData);

            Log::info('Deposit initiated', [
                'user_id' => $user->id,
                'deposit_reference' => $depositReference,
                'response' => $response->json(),
            ]);
            return redirect()->back()->with(
                [
                    'toast' => [
                        'type' => 'success',
                        'title' => 'Deposit Initiated Successful',
                        'message' => 'STKPUSH has being initiated, check your phone to complete payment.',
                    ],
                ]
            );
        } catch (Exception $e) {
            Log::error('Deposit failed', [
                'user_id' => $user->id,
                'deposit_reference' => $depositReference,
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with([
                'toast' => [
                    'type' => 'error',
                    'title' => 'Payment Failed',
                    'message' => 'Payment failed. Please try again.',
                ],
            ]);
        }
    }

    public function handle(Request $request): \Illuminate\Http\JsonResponse
    {
        $payload = $request->all();
        Log::info('PayHero callback received', $payload);

        $response = $request->input('response', []);


        // Adjust these keys based on actual PayHero response format
        $amount            = (float) ($response['Amount'] ?? 0);
        $phone             = $response['Phone'] ?? null;
        $receiptNumber     = $response['MpesaReceiptNumber'] ?? null;
        $externalReference = $response['ExternalReference'] ?? null;

        // Reference format: dep_userId_uuid
        $refParts = explode('_', $externalReference);

        if (count($refParts) !== 3 || $refParts[0] !== 'dep') {
            Log::error('Invalid external reference format', [
                'reference' => $externalReference,
                'parts'     => $refParts
            ]);

            return response()->json(['ok' => false, 'message' => 'Invalid reference'], 400);
        }

        $userId = (int) $refParts[1];

        $user = User::find($userId);
        if (!$user) {
            Log::error("User with id {$userId} not found from reference {$externalReference}");
            return response()->json(['ok' => false, 'message' => 'User not found'], 404);
        }

        // Prevent duplicate deposits
        if (Deposit::where('transaction', $receiptNumber)->exists()) {
            Log::warning('Duplicate transaction detected', ['receipt' => $receiptNumber]);
            return response()->json(['ok' => true, 'message' => 'Duplicate ignored']);
        }

        try {
            DB::transaction(function () use ($user, $amount, $receiptNumber) {
                // Increment wallet balance
                $user->increment('balance', $amount);
                $user->increment('deposits', $amount);

                // Record deposit
                Deposit::create([
                    'method'      => 'mpesa',
                    'amount'      => $amount,
                    'username'    => $user->username,
                    'transaction' => $receiptNumber,
                    'status'      => 'healthy',
                ]);

                // Record transaction
                $shortcode = $this->shortcodeService->generateShortcode(TransactionType::DEPOSIT);

                Transaction::create([
                    'shortcode' => $shortcode,
                    'type'      => TransactionType::DEPOSIT->value,
                    'amount'    => $amount,
                    'user_id'   => $user->id,
                    'status'    => 'healthy',
                ]);
            });

            Log::info('Payment processed successfully', [
                'user_id' => $user->id,
                'amount'  => $amount,
                'receipt' => $receiptNumber,
            ]);

            return response()->json(['ok' => true, 'message' => 'Payment processed']);
        } catch (Exception $e) {
            Log::error('Payment processing failed', [
                'error'   => $e->getMessage(),
                'payload' => $payload,
            ]);

            return response()->json(['ok' => false, 'message' => 'Server error'], 500);
        }
    }
}
