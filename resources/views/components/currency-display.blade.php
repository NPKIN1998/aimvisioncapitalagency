<span {{ $attributes }}>
    {{ $currency['symbol'] }} {{ number_format($amount * $currency['rate'], 0) }}
</span>
