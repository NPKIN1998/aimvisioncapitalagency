<x-app-layout>
    <div class="min-h-screen bg-background px-4 py-4 md:px-8 md:py-8"
        x-data="{ activeTab: 'daily', ratings: {} }">

        {{-- HEADER --}}
        <div class="mb-5">
            <h1 class="text-2xl font-bold text-foreground">
                Task Center
            </h1>
            <p class="text-sm text-muted-foreground mt-1">
                Complete tasks and claim your earnings
            </p>
        </div>

        {{-- TABS (MOBILE FIRST) --}}
        <div class="mb-6">
            <div class="grid grid-cols-2 gap-2 bg-muted/40 p-1 rounded-2xl border border-border">

                <button
                    @click="activeTab = 'daily'"
                    :class="activeTab === 'daily'
                        ? 'bg-primary text-primary-foreground shadow-sm'
                        : 'text-muted-foreground'"
                    class="h-11 rounded-xl text-sm font-semibold transition">
                    Daily Tasks
                </button>

                <button
                    @click="activeTab = 'rent'"
                    :class="activeTab === 'rent'
                        ? 'bg-primary text-primary-foreground shadow-sm'
                        : 'text-muted-foreground'"
                    class="h-11 rounded-xl text-sm font-semibold transition">
                    Claim Rent
                </button>

            </div>
        </div>

        {{-- DAILY TASKS --}}
        <div x-show="activeTab === 'daily'" x-cloak class="space-y-4">

            <h2 class="text-sm font-semibold text-muted-foreground uppercase tracking-wide">
                Rate Packages
            </h2>

            <div class="space-y-4">

                @foreach ($investments as $investment)
                                <div
                                    class="bg-card border border-border rounded-3xl p-4 shadow-sm">

                                    {{-- TOP SECTION --}}
                                    <div class="flex gap-3">

                                        <img src="{{ asset('images/hotel1.png') }}"
                                            class="w-16 h-16 rounded-2xl object-cover shrink-0">

                                        <div class="flex-1 min-w-0">

                                            <div class="flex items-start justify-between gap-2">

                                                <div class="min-w-0">
                                                    <h3 class="text-sm font-semibold text-foreground truncate">
                                                        {{ $investment->package->name }}
                                                    </h3>

                                                    <p class="text-xs text-muted-foreground mt-1">
                                                        Next Claim {{ $investment->next_payment }}
                                                    </p>
                                                </div>

                                                <span
                                                    class="text-[10px] px-2 py-1 rounded-full font-medium
                                                    {{ $investment->status === 'active'
                    ? 'bg-accent/10 text-accent'
                    : 'bg-primary/10 text-primary' }}">
                                                    {{ $investment->status }}
                                                </span>

                                            </div>
                                        </div>
                                    </div>

                                    {{-- RATING --}}
                                    <div class="mt-4">
                                        <p class="text-xs text-muted-foreground mb-2">
                                            Rate this package
                                        </p>

                                        <div class="flex items-center justify-between">

                                            <div class="flex gap-1">
                                                <template x-for="i in 5">
                                                    <button type="button"
                                                        @click="ratings[{{ $investment->id }}] = i"
                                                        class="focus:outline-none">

                                                        <i class="bi bi-star-fill text-lg"
                                                            :class="i <= (ratings[{{ $investment->id }}] || 0)
                                                                ? 'text-accent'
                                                                : 'text-muted-foreground/40'">
                                                        </i>

                                                    </button>
                                                </template>
                                            </div>

                                            <span class="text-xs text-muted-foreground"
                                                x-text="ratings[{{ $investment->id }}]
                                                    ? ratings[{{ $investment->id }}] + '/5'
                                                    : 'Tap to rate'">
                                            </span>

                                        </div>
                                    </div>

                                    {{-- ACTION --}}
                                    <form class="mt-4" method="POST" action="{{ route('dailyTask') }}">
                                        @csrf
                                        <input type="hidden" name="investment_id" value="{{ $investment->id }}">
                                        <input type="hidden" name="rating"
                                            x-model="ratings[{{ $investment->id }}]">

                                        <button type="submit"
                                            class="w-full h-11 rounded-2xl bg-primary text-primary-foreground font-semibold active:scale-[0.98] transition">
                                            Submit Rating
                                        </button>
                                    </form>

                                </div>
                @endforeach

            </div>
        </div>

        {{-- RENT TAB --}}
        <div x-show="activeTab === 'rent'" x-cloak class="space-y-4">

            @forelse($rents as $rent)

                        <div class="bg-card border border-border rounded-3xl p-5 shadow-sm">

                            {{-- HEADER --}}
                            <div class="flex items-start justify-between gap-3 mb-4">

                                <div class="min-w-0">
                                    <h3 class="text-sm font-semibold text-foreground truncate">
                                        {{ $rent->property->name ?? 'Property Investment' }}
                                    </h3>

                                    <p class="text-xs text-muted-foreground mt-1">
                                        Investment #{{ $rent->id }}
                                    </p>
                                </div>

                                <span
                                    class="text-[10px] px-2 py-1 rounded-full font-medium
                                    {{ $rent->status === 'active'
                ? 'bg-accent/10 text-accent'
                : 'bg-destructive/10 text-destructive' }}">
                                    {{ ucfirst($rent->status) }}
                                </span>

                            </div>

                            {{-- STATS (MOBILE FIRST GRID) --}}
                            <div class="grid grid-cols-2 gap-3 mb-5">

                                <div class="rounded-2xl bg-muted/40 border border-border p-3 text-center">
                                    <p class="text-[10px] text-muted-foreground uppercase">
                                        Capital
                                    </p>
                                    <p class="text-sm font-semibold text-foreground mt-1">
                                        <x-currency-display :amount="$rent['property']['capital']" />
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-primary/10 border border-border p-3 text-center">
                                    <p class="text-[10px] text-primary uppercase">
                                        Daily
                                    </p>
                                    <p class="text-sm font-semibold text-primary mt-1">
                                        <x-currency-display :amount="floatval($rent['property']['daily_rent'])" />
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-muted/40 border border-border p-3 text-center">
                                    <p class="text-[10px] text-muted-foreground uppercase">
                                        Paid Days
                                    </p>
                                    <p class="text-sm font-semibold text-foreground mt-1">
                                        {{ $rent->days_paid }}
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-accent/10 border border-border p-3 text-center">
                                    <p class="text-[10px] text-accent uppercase">
                                        Total
                                    </p>
                                    <p class="text-sm font-semibold text-accent mt-1">
                                        <x-currency-display :amount="floatval($rent['property']['total_rent'])" />
                                    </p>
                                </div>

                            </div>

                            {{-- ACTION --}}
                            <button
                                @click="claimRent({{ $rent->id }})"
                                :disabled="{{ $rent->status !== 'active' ? 'true' : 'false' }}"
                                class="w-full h-12 rounded-2xl font-semibold transition active:scale-[0.98]
                                {{ $rent->status === 'active'
                ? 'bg-primary text-primary-foreground'
                : 'bg-muted text-muted-foreground cursor-not-allowed' }}">

                                @if ($rent->status === 'active')
                                    Claim Earnings
                                @else
                                    Inactive Investment
                                @endif

                            </button>

                        </div>

            @empty

                <div class="text-center py-12">
                    <h3 class="text-lg font-semibold text-foreground">
                        No Active Investments
                    </h3>

                    <p class="text-sm text-muted-foreground mt-2">
                        Start investing to earn daily rental income
                    </p>

                    <a href="{{ route('release') }}"
                        class="inline-flex mt-5 px-5 py-3 rounded-2xl bg-primary text-primary-foreground font-semibold">
                        Explore Opportunities
                    </a>
                </div>

            @endforelse

        </div>

    </div>
</x-app-layout>