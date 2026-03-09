@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-input bg-transparent text-base selection:bg-primary selection:text-primary-foreground rounded-md shadow-xs']) }}>
