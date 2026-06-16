@props(['count' => 0, 'label' => '', 'color' => 'primary', 'tooltip' => null])

@php
    $colorClasses = [
        'green' => 'bg-accent/10 border-accent/30 text-accent',
        'red' => 'bg-destructive/10 border-destructive/30 text-destructive',
        'primary' => 'bg-primary/10 border-primary/30 text-primary',
    ][$color] ?? 'bg-muted border-border text-foreground';

    $badgeClasses = [
        'green' => 'bg-accent/20 text-accent',
        'red' => 'bg-destructive/20 text-destructive',
        'primary' => 'bg-primary/20 text-primary',
    ][$color] ?? 'bg-muted/20 text-foreground';
@endphp

<div {{ $attributes->merge(['class' => "relative flex flex-col items-center py-4 px-6 rounded-2xl border shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5 group $colorClasses"]) }}>
    {{-- Circular Badge --}}
    <div class="w-16 h-16 rounded-full flex items-center justify-center font-bold text-lg {{ $badgeClasses }}">
        {{ $count }}
    </div>

    {{-- Label with Tooltip --}}
    <span class="text-sm font-medium mt-2 relative">
        {{ $label }}
        @if ($tooltip)
            <span
                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover:block px-2 py-1 text-xs bg-foreground text-background rounded shadow-lg whitespace-nowrap">
                {{ $tooltip }}
            </span>
        @endif
    </span>
</div>