<x-app-layout>
    <div class="container mx-auto px-4 pb-16">

        <!-- Page Heading -->
        <h1
            class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-center mb-10
                   bg-linear-to-r from-primary to-secondary bg-clip-text text-transparent
                   animate-linear drop-shadow-md tracking-tight">
            Explore Our Packages
        </h1>

        <!-- Package Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">

            @foreach ($packages as $package)
                <div
                    class="group relative rounded-2xl overflow-hidden shadow-sm
                            bg-card/90 backdrop-blur-xl border border-border
                            transition-all duration-300
                            hover:shadow-2xl hover:-translate-y-1 hover:scale-105">

                    <!-- Subtle linear Glow -->
                    <div
                        class="absolute inset-0 bg-linear-to-br from-primary to-secondary opacity-10 blur-3xl pointer-events-none">
                    </div>

                    <!-- Card Content -->
                    <div class="relative p-4 sm:p-5 flex flex-col justify-between h-full">

                        <!-- Icon Header -->
                        <div class="flex flex-col items-center text-center mb-4">
                            <div
                                class="w-12 h-12 sm:w-14 sm:h-14 rounded-full
                                       bg-linear-to-r from-primary to-secondary
                                       flex items-center justify-center shadow-lg
                                       group-hover:scale-110 transition-transform duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-primary-foreground">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                                </svg>
                            </div>

                            <h2 class="mt-3 text-sm sm:text-base font-bold text-foreground tracking-wide">
                                {{ $package->name }}
                            </h2>
                        </div>

                        <!-- Body Data -->
                        <div class="space-y-3 text-xs sm:text-sm">

                            <!-- Capital -->
                            <div class="flex justify-between items-center">
                                <span class="text-foreground/80 font-medium">💰 Capital</span>
                                <span class="font-semibold text-foreground">
                                    <x-currency-display :amount="$package->initial_capital" />
                                </span>
                            </div>

                            <!-- Daily Task -->
                            <div class="flex justify-between items-center">
                                <span class="text-foreground/80 font-medium">📋 Daily Task</span>
                                <span
                                    class="font-semibold
                                             {{ $package->daily_task ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $package->daily_task ? 'Yes' : 'No' }}
                                </span>
                            </div>

                        </div>

                        <!-- Footer Button -->
                        <form method="POST" action="{{ route('plan.store') }}" class="mt-5">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $package->id }}">

                            <button
                                class="w-full py-2.5 rounded-xl font-semibold text-xs sm:text-sm
                                       bg-linear-to-r from-primary to-secondary text-primary-foreground
                                       shadow-md transition-all duration-300
                                       hover:shadow-xl hover:scale-[1.03]">
                                Invest Now
                            </button>
                        </form>

                    </div>
                </div>
            @endforeach

        </div>

    </div>
</x-app-layout>
