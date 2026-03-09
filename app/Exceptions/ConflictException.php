<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class ConflictException extends Exception
{
    protected $code = 409; // HTTP 409 Conflict
    protected $message = 'The request conflicts with the current state of the resource.';

    public function __construct(
        ?string $message = null,
        protected ?float $requiredAmount = null,
        protected ?float $currentBalance = null
    ) {
        parent::__construct($message ?? $this->message, $this->code);
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        Log::warning('Resource conflict detected: ' . $this->getMessage(), [
            'exception' => $this,
            'trace' => $this->getTraceAsString(),
            'required_amount' => $this->requiredAmount,
            'current_balance' => $this->currentBalance,
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
                'error' => $this->getMessage(),
                'code' => $this->code,
                'required_amount' => $this->requiredAmount,
                'current_balance' => $this->currentBalance,
            ], $this->code);
        }

        return redirect()->back()
            ->with('balance_error', true)
            ->with('error', $this->getMessage())
            ->with('required_amount', $this->requiredAmount)
            ->with('current_balance', $this->currentBalance)
            ->withInput();
    }

    /**
     * Create a conflict exception with custom message.
     */
    public static function withMessage(string $message): self
    {
        return new self($message);
    }

    /**
     * Create a conflict exception with balance details.
     */
    public static function withBalanceDetails(float $requiredAmount, float $currentBalance, ?string $message = null): self
    {
        return new self($message, $requiredAmount, $currentBalance);
    }
}