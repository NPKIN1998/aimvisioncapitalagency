<x-app-layout>
    <div class="w-full px-4 sm:px-6 lg:px-8 py-6 sm:py-8 lg:py-10 space-y-8 sm:space-y-10">

        {{-- ===== BALANCE CARD ===== --}}
        <div x-data="{ showBalance: false, isLoading: false, toggleBalance() { this.isLoading = true; setTimeout(() => { this.showBalance = !this.showBalance; this.isLoading = false }, 300) } }"
            class="relative overflow-hidden bg-linear-to-br from-primary via-primary to-primary/90 rounded-2xl shadow-2xl">

            {{-- Professional grid overlay (theme‑aware) --}}
            <div class="absolute inset-0 opacity-[0.07] pointer-events-none"
                style="background-image: linear-gradient(var(--primary-foreground) 1px, transparent 1px), linear-gradient(90deg, var(--primary-foreground) 1px, transparent 1px); background-size: 40px 40px;">
            </div>

            {{-- Subtle vignette for depth --}}
            <div class="absolute inset-0 bg-linear-to-t from-black/20 to-transparent pointer-events-none"></div>

            <div class="relative p-6 sm:p-8 lg:p-10">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                    {{-- Left: label + balance --}}
                    <div class="flex-1">
                        <p
                            class="text-xs sm:text-sm font-semibold uppercase tracking-[0.3em] text-primary-foreground/50 mb-2">
                            Available Balance
                        </p>
                        <div class="min-h-16 sm:min-h-20 flex items-center">
                            <template x-if="showBalance">
                                <div class="fade-in">
                                    <span class="sr-only">Your balance is</span>
                                    <x-currency-display :amount="Auth::user()->balance"
                                        class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tighter text-white" />
                                </div>
                            </template>
                            <template x-if="!showBalance">
                                <div class="flex gap-2 fade-in" aria-hidden="true">
                                    <span class="w-10 h-6 sm:w-12 sm:h-7 bg-white/20 rounded-lg animate-pulse"></span>
                                    <span class="w-16 h-6 sm:w-20 sm:h-7 bg-white/20 rounded-lg animate-pulse"></span>
                                    <span class="w-20 h-6 sm:w-24 sm:h-7 bg-white/20 rounded-lg animate-pulse"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Right: toggle button (glass style) --}}
                    <button @click="toggleBalance()" :disabled="isLoading"
                        :aria-label="showBalance ? 'Hide balance' : 'Show balance'"
                        class="shrink-0 group relative size-12 sm:size-14 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 backdrop-blur-md flex items-center justify-center transition-all duration-200 hover:scale-105 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                        <template x-if="isLoading">
                            <i class="bi bi-arrow-repeat animate-spin text-xl sm:text-2xl text-white"></i>
                        </template>
                        <template x-if="!isLoading">
                            <i :class="showBalance ? 'bi-eye-slash' : 'bi-eye'"
                                class="text-xl sm:text-2xl text-white transition-transform group-hover:scale-110"></i>
                        </template>
                    </button>
                </div>
            </div>
        </div>

        {{-- QUICK ACTIONS (themed, distinct per item) --}}
        <div class="grid grid-cols-3 lg:grid-cols-6 gap-4">
            @php
                $actions = [
                    ['route' => 'plan', 'label' => 'Plans', 'icon' => 'bi-graph-up', 'color' => 'primary'],
                    ['route' => 'grant', 'label' => 'Grants', 'icon' => 'bi-award', 'color' => 'accent'],
                    ['route' => 'cashout', 'label' => 'Withdraw', 'icon' => 'bi-cash-stack', 'color' => 'secondary'],
                    ['route' => 'deposit', 'label' => 'Deposit', 'icon' => 'bi-wallet2', 'color' => 'primary'],
                    ['route' => 'release', 'label' => 'Property', 'icon' => 'bi-building', 'color' => 'chart-3'],
                    ['route' => 'task', 'label' => 'Tasks', 'icon' => 'bi-list-check', 'color' => 'secondary'],
                ];

                $colorMap = [
                    'primary' => 'text-primary border-primary/30 hover:border-primary',
                    'accent' => 'text-accent border-accent/30 hover:border-accent',
                    'secondary' => 'text-secondary-foreground border-secondary/30 hover:border-secondary',
                    'chart-3' => 'text-chart-3 border-chart-3/30 hover:border-chart-3',
                ];
            @endphp

            @foreach ($actions as $action)
                @php
                    $colorClasses = $colorMap[$action['color']];
                @endphp
                <a href="{{ route($action['route']) }}"
                    class="flex flex-col items-center justify-center p-4 sm:p-5 bg-card border border-border/30 rounded-2xl shadow-sm hover:shadow-md transition-all active:scale-[0.98] group {{ $colorClasses }}">
                    <div
                        class="size-12 sm:size-14 rounded-xl bg-white/70 dark:bg-white/10 backdrop-blur-md shadow-inner flex items-center justify-center mb-2 group-hover:scale-105 transition-transform">
                        <i class="bi {{ $action['icon'] }} text-2xl sm:text-3xl {{ $colorClasses }}"></i>
                    </div>
                    <span class="text-xs sm:text-sm font-medium text-foreground text-center">{{ $action['label'] }}</span>
                </a>
            @endforeach
        </div>
        {{-- STATISTICS (now using currency component for monetary values) --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            @php
                $stats = [
                    ['label' => 'Active Plans', 'value' => Auth::user()->plans()->where('status', 'active')->count(), 'icon' => 'bi-briefcase', 'color' => 'bg-primary/10 text-primary'],
                    ['label' => 'Total Deposits', 'value' => Auth::user()->transactions()->where('type', 'deposit')->sum('amount'), 'icon' => 'bi-wallet2', 'color' => 'bg-accent/10 text-accent', 'is_currency' => true],
                    ['label' => 'Referral Bonus', 'value' => Auth::user()->transactions()->where('type', 'referral_bonus')->sum('amount'), 'icon' => 'bi-people', 'color' => 'bg-chart-3/10 text-chart-3', 'is_currency' => true],
                ];
            @endphp
            @foreach ($stats as $stat)
                <div class="bg-card border border-border/30 rounded-2xl p-5 sm:p-6 flex items-center gap-4 shadow-sm">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl {{ $stat['color'] }} flex items-center justify-center">
                        <i class="bi {{ $stat['icon'] }} text-xl sm:text-2xl"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm text-muted-foreground font-medium">{{ $stat['label'] }}</p>
                        @if ($stat['is_currency'] ?? false)
                            <x-currency-display :amount="$stat['value']"
                                class="text-lg sm:text-xl font-bold text-foreground truncate" />
                        @else
                            <p class="text-lg sm:text-xl font-bold text-foreground truncate">{{ $stat['value'] }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @foreach ($transactions as $transaction)
            @php
                $typeValue = $transaction->type instanceof \App\Enums\TransactionType ? $transaction->type->value : $transaction->type;
                $typeMeta = [
                    'deposit' => ['icon' => 'bi-wallet2', 'color' => 'bg-accent/10 text-accent'],
                    'withdrawal' => ['icon' => 'bi-cash-stack', 'color' => 'bg-primary/10 text-primary'],
                    'investment' => ['icon' => 'bi-graph-up', 'color' => 'bg-secondary/20 text-secondary-foreground'],
                    'referral_bonus' => ['icon' => 'bi-gift', 'color' => 'bg-chart-3/10 text-chart-3'],
                    'wealth_fund' => ['icon' => 'bi-bank', 'color' => 'bg-accent/10 text-accent'],
                    'task_reward' => ['icon' => 'bi-list-check', 'color' => 'bg-secondary/20 text-secondary-foreground'],
                ][$typeValue] ?? ['icon' => 'bi-arrow-left-right', 'color' => 'bg-muted text-muted-foreground'];
                $status = $transaction->status ?? 'pending';
                $statusColor = [
                    'completed' => 'bg-accent/20 text-accent',
                    'approved' => 'bg-accent/20 text-accent',
                    'pending' => 'bg-chart-3/20 text-chart-3',
                    'failed' => 'bg-destructive/20 text-destructive',
                    'active' => 'bg-primary/20 text-primary',
                ][$status] ?? 'bg-muted/20 text-muted-foreground';
                $amountSign = in_array($typeValue, ['withdrawal', 'investment']) ? '-' : '+';
            @endphp

            <div
                class="bg-card border border-border/20 rounded-2xl p-4 sm:p-5 flex flex-row items-center justify-between gap-3 shadow-sm hover:shadow-md transition-shadow">
                {{-- Left: icon + description – allowed to shrink --}}
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 rounded-full {{ $typeMeta['color'] }} flex items-center justify-center shrink-0">
                        <i class="bi {{ $typeMeta['icon'] }} text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <p class="text-sm font-semibold text-foreground capitalize truncate">
                                {{ str_replace('_', ' ', $typeValue) }}
                            </p>
                            <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $statusColor }} shrink-0">
                                {{ ucfirst($status) }}
                            </span>
                        </div>
                        <p class="text-xs text-muted-foreground mt-0.5 truncate">
                            {{ $transaction->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>

                {{-- Right: amount – always on the right, never wraps --}}
                <div class="flex items-center gap-1 shrink-0">
                    <span class="text-base sm:text-lg font-bold {{ $amountSign === '+' ? 'text-accent' : 'text-primary' }}">
                        {{ $amountSign }}
                    </span>
                    <x-currency-display :amount="$transaction->amount"
                        class="text-base sm:text-lg font-bold {{ $amountSign === '+' ? 'text-accent' : 'text-primary' }}" />
                </div>
            </div>
        @endforeach
    </div>

    <style>
        .fade-in {
            opacity: 0;
            animation: fadeIn 0.4s ease forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
    </style>
</x-app-layout>