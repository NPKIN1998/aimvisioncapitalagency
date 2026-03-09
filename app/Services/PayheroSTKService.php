<?php

namespace App\Services;

use App\Data\PayHeroSKTData;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class PayheroSTKService
{
    protected string $baseUrl;
    protected string $username;
    protected string $password;
    protected int $channelId;

    public function __construct()
    {
        $this->baseUrl = config('payhero.api_url');
        $this->username = config('payhero.api_username');
        $this->password = config('payhero.api_password');
        $this->channelId = config('payhero.channel_id');
    }

    /**
     * Initiate a PayHero STK payment
     */
    public function createPayment(PayHeroSKTData $paymentData): Response
    {
        try {
            $response = Http::withBasicAuth($this->username, $this->password)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->timeout(15)
                ->retry(3, 100) // retry 3 times with 100ms delay
                ->post($this->baseUrl, $paymentData->toArray());

            $response->throw(); // throws exception if status >= 400
            return $response;
        } catch (Exception $e) {
            Log::error('PayHero STK Payment Error', [
                'payload' => $paymentData->toArray(),
                'message' => $e->getMessage(),
            ]);

            throw $e; // rethrow for controller to handle
        }
    }
}
