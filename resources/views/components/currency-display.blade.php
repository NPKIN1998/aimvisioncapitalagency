<span {{ $attributes->merge(['class' => 'inline-flex items-baseline font-semibold text-foreground']) }}>
    <span class="mr-1 text-[0.65em] opacity-70">{{ $currency['symbol'] }}</span>
    <span>{{ number_format($amount * $currency['rate'], 0) }}</span>
</span>