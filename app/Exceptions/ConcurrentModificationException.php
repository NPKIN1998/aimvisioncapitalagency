<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ConcurrentModificationException extends Exception
{
    protected $code = 423;
    protected $message = 'The resource was modified by another request. Please try again.';

    public function report(): void
    {
        Log::warning('Concurrent modification detected: ' . $this->getMessage(), [
            'exception' => $this,
            'trace' => $this->getTraceAsString()
        ]);
    }

    /**
     * Render the exception as an HTTP response.
     */
    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): Response|JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return new JsonResponse([
                'success' => false,
                'message' => $this->getMessage(),
                'code' => $this->code
            ], $this->code);
        }
        return redirect()
            ->back()
            ->withInput()
            ->withErrors(['concurrent_modification' => $this->getMessage()]);
    }
}
