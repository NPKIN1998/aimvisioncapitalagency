<?php

namespace App\Data;

class PayHeroSKTData
{
    public function __construct(
        public float $amount,
        public string $phoneNumber,
        public string $customerName,
        public string $externalReference,
        public string $callbackUrl,
        public int $channelId = 0,
        public string $provider = 'm-pesa'
    ) {
        $this->channelId = $channelId ?: (int) config('payhero.channel_id');
        $this->provider = $provider ?: 'm-pesa';
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'phone_number' => $this->phoneNumber,
            'channel_id' => $this->channelId,
            'provider' => $this->provider,
            'external_reference' => $this->externalReference,
            'customer_name' => $this->customerName,
            'callback_url' => $this->callbackUrl,
        ];
    }
}
