@props(['value'])

<label {{ $attributes->merge(['class' => 'text-sm font-semibold pb-2 text-foreground']) }}>
    {{ $value ?? $slot }}
</label>
