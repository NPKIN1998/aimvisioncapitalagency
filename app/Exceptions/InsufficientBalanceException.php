<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class InsufficientBalanceException extends Exception
{
    protected $code = 400; // HTTP 400 Bad Request
    protected $message = 'Insufficient balance to complete this operation.';
    protected ?float $requiredAmount;
    protected ?float $currentBalance;

    /**
     * Create a new exception instance.
     *
     * @param string|null $message
     * @param float|null $requiredAmount
     * @param float|null $currentBalance
     */
    public function __construct(
        ?string $message = null,
        ?float $requiredAmount = null,
        ?float $currentBalance = null
    ) {
        parent::__construct($message ?? $this->message);

        $this->requiredAmount = $requiredAmount;
        $this->currentBalance = $currentBalance;
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        Log::warning('Insufficient balance detected', [
            'exception' => $this,
            'required_amount' => $this->requiredAmount,
            'current_balance' => $this->currentBalance,
            'user_id' => optional(request()->user())->id
        ]);
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): Response|JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return new JsonResponse([
                'success' => false,
                'message' => $this->getMessage(),
                'error' => [
                    'code' => $this->code,
                    'required_amount' => $this->requiredAmount,
                    'current_balance' => $this->currentBalance,
                ]
            ], $this->code);
        }

        // Return redirect response with flashed data
        return redirect()->back()
            ->with('balance_error', true)
            ->with('error', $this->getMessage())
            ->with('required_amount', $this->requiredAmount)
            ->with('current_balance', $this->currentBalance)
            ->withInput();
    }

    /**
     * Create an instance with detailed balance information.
     */
    public static function withBalance(
        float $requiredAmount,
        float $currentBalance,
        ?string $message = null
    ): self {
        return new self(
            $message ?? sprintf(
                'Required: %s, Available: %s',
                number_format($requiredAmount, 2),
                number_format($currentBalance, 2)
            ),
            $requiredAmount,
            $currentBalance
        );
    }
}
