<x-app-layout>
    <div class="w-full px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-10">

        {{-- ===== HEADER SECTION ===== --}}
        <div class="relative text-center max-w-2xl mx-auto">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-primary mb-2">Investment Packages</p>
            <h1 class="text-3xl sm:text-4xl font-bold text-foreground">Choose a plan that matches your ambition</h1>
            <p class="mt-3 text-sm sm:text-base text-muted-foreground leading-relaxed">
                Every package is carefully designed to deliver steady returns and daily rewards. Start with confidence.
            </p>
        </div>

        {{-- ===== PACKAGES ===== --}}
        @if($packages->isNotEmpty())
            <div class="space-y-6 lg:space-y-0 lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-10">
                @foreach ($packages as $package)
                    @php
                        $isLeft = $loop->odd;
                    @endphp

                    <div
                        class="relative flex flex-col lg:flex-row lg:items-center gap-4 lg:gap-0 {{ $isLeft ? 'lg:flex-row' : 'lg:flex-row-reverse' }}">

                        {{-- Card --}}
                        <div
                            class="relative flex-1 bg-card border border-border/30 rounded-3xl p-6 sm:p-8 shadow-md hover:shadow-xl transition-all duration-300 group">
                            <div
                                class="absolute top-0 left-8 right-8 h-1 bg-gradient-to-r from-primary via-accent to-secondary rounded-b-full opacity-80">
                            </div>

                            <div
                                class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                                <i class="bi bi-graph-up-arrow text-2xl text-primary"></i>
                            </div>

                            <h3 class="text-xl sm:text-2xl font-bold text-foreground mb-4">{{ $package->name }}</h3>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                                <div>
                                    <p class="text-muted-foreground text-xs uppercase tracking-wide">Capital</p>
                                    <p class="font-semibold text-foreground mt-0.5">
                                        <x-currency-display :amount="$package->initial_capital" />
                                    </p>
                                </div>
                                <div>
                                    <p class="text-muted-foreground text-xs uppercase tracking-wide">Daily Task</p>
                                    <p
                                        class="font-semibold mt-0.5 {{ $package->daily_task ? 'text-accent' : 'text-destructive' }}">
                                        {{ $package->daily_task ? 'Yes' : 'No' }}
                                    </p>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('plan.store') }}" class="mt-6">
                                @csrf
                                <input type="hidden" name="plan_id" value="{{ $package->id }}">
                                <button type="submit"
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-primary text-primary-foreground font-semibold text-sm shadow-lg hover:bg-primary/90 hover:shadow-xl active:scale-[0.98] transition-all focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring">
                                    Invest Now
                                    <i class="bi bi-arrow-right text-lg"></i>
                                </button>
                            </form>
                        </div>

                        <div class="hidden lg:block w-8 h-8 rounded-full bg-gradient-to-br from-primary/30 to-accent/30 blur-xl self-center mx-4 flex-shrink-0"
                            aria-hidden="true"></div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 text-muted-foreground">
                <i class="bi bi-inbox text-4xl mb-3 opacity-50"></i>
                <p class="text-sm">No packages available at the moment. Please check back later.</p>
            </div>
        @endif

        <p class="text-center text-xs text-muted-foreground">
            All packages come with full support and secure capital protection.
        </p>
    </div>
</x-app-layout>