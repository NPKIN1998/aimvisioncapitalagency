<div class="p-6 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
    <!-- Background gradient -->
    <div
        class="absolute top-0 right-0 w-24 h-24 bg-{{ $color }}/5 rounded-full blur-2xl group-hover:bg-{{ $color }}/10 transition-all duration-500">
    </div>

    <div class="relative">
        <!-- Header -->
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-{{ $color }}/10 rounded-xl">
                <i data-lucide="{{ $icon }}" class="w-6 h-6 text-{{ $color }}"></i>
            </div>
            @if ($change)
                <div
                    class="flex items-center space-x-1 px-2 py-1 rounded-full text-xs font-medium
                        {{ $changeType === 'positive' ? 'bg-secondary/10 text-secondary' : 'bg-destructive/10 text-destructive' }}">
                    <i data-lucide="{{ $changeType === 'positive' ? 'trending-up' : 'trending-down' }}" class="size-3"></i>
                    <span>{{ $change }}</span>
                </div>
            @endif
        </div>

        <!-- Content -->
        <div class="space-y-2">
            <p class="text-2xl font-bold text-foreground tracking-tight">{{ $value }}</p>
            <p class="text-sm text-muted-foreground font-medium">{{ $title }}</p>
        </div>

        <!-- Progress bar (optional) -->
        <div class="mt-4" x-data="{ progress: 75 }" x-show="false">
            <div class="w-full bg-muted rounded-full h-2">
                <div class="bg-{{ $color }} h-2 rounded-full transition-all duration-500"
                    :style="`width: ${progress}%`"></div>
            </div>
        </div>
    </div>
</div>