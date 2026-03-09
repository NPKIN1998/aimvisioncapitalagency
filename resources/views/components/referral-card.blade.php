@props(['count', 'label', 'color', 'tooltip'])

<div
    {{ $attributes->merge(['class' => "relative flex flex-col items-center py-4 px-6 rounded-lg bg-$color-100 border border-$color-300 shadow-md transition-all hover:bg-$color-200 group"]) }}>
    <!-- Circular Badge -->
    <div
        class="w-20 h-20 rounded-full bg-{{ $color }}-200 flex items-center justify-center text-{{ $color }}-900 font-bold text-xl">
        {{ $count }}
    </div>

    <!-- Label with Tooltip -->
    <span class="text-sm text-{{ $color }}-700 mt-2 relative group">
        {{ $label }}
        @if ($tooltip)
            <span
                class="absolute bottom-full mb-2 hidden group-hover:block px-2 py-1 text-xs bg-gray-700 text-white rounded">
                {{ $tooltip }}
            </span>
        @endif
    </span>
</div>
