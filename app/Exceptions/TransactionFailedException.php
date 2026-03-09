<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class TransactionFailedException extends Exception
{
    protected $code = 500; // HTTP 500 Internal Server Error
    protected ?array $context = null;

    /**
     * Create a new exception instance.
     *
     * @param string|null $message
     * @param array|null $context
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        ?string $message = null,
        ?array $context = null,
        int $code = 0,
        ?Throwable $previous = null
    ) {
        $this->context = $context;

        parent::__construct(
            $message ?? 'The transaction could not be completed.',
            $code ?: $this->code,
            $previous
        );
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        Log::error('Transaction failed: ' . $this->getMessage(), [
            'exception' => $this,
            'context' => $this->context,
            'trace' => $this->getTraceAsString()
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
                    'details' => config('app.debug') ? $this->getTrace() : null,
                ]
            ], $this->code);
        }

        return redirect()
            ->back()
            ->withInput()
            ->withErrors(['transaction_failed' => $this->getMessage()]);
    }

    /**
     * Create with additional context.
     */
    public static function withContext(
        array $context,
        ?string $message = null
    ): self {
        return new self($message, $context);
    }
}