<?php

namespace App\Services;

use App\Data\TruelineSTKData;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TrueLineGateService
{
    protected $apiKey;
    protected $channel;
    protected $callbackUrl;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->apiKey = config('services.truelinegate.api_key');
        $this->channel = config('services.truelinegate.channel');
        $this->callbackUrl = config('services.truelinegate.callback_url');
    }


    public function initiateSTKPush(TruelineSTKData $requestData): array
    {
        $payload = array_merge($requestData->toArray(), [
            'api_key' => $this->apiKey,
            'payment_id' => $this->channel,
            'callback_url' => $this->callbackUrl,
        ]);

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
                ->timeout(30)
                ->retry(3, 100)
                ->post('https://trustline.co.ke/api/v1/mpesa/express', $payload);

            return $this->handleResponse($response);
        } catch (Exception $e) {
            Log::error('MPesa Service Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return ['error' => 'Payment service unavailable. Please try again later.'];
        }
    }

    private function handleResponse($response): array
    {
        if ($response->successful()) {
            return $response->json();
        }

        Log::error('MPesa API Error', [
            'status' => $response->status(),
            'response' => $response->json(),
        ]);

        return [
            'error' => $response->json()['message'] ?? 'Payment failed. Please try again.'
        ];
    }
}
