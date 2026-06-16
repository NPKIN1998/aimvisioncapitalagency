<x-app-layout>
    <div x-data="{ submitting: false }" class="min-h-dvh flex flex-col items-center justify-center px-4 py-8 sm:px-6 lg:px-8 relative">

        {{-- Subtle graph background (theme‑aware, same as landing) --}}
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" aria-hidden="true"
             style="background-image: linear-gradient(var(--primary) 1px, transparent 1px), linear-gradient(90deg, var(--primary) 1px, transparent 1px); background-size: 40px 40px;">
        </div>

        {{-- Card --}}
        <div class="relative w-full max-w-md bg-card/90 backdrop-blur-xl border border-border/40 rounded-3xl shadow-2xl p-6 sm:p-8">

            {{-- Diamond logo + title --}}
            <div class="flex flex-col items-center mb-6">
                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-primary flex items-center justify-center shadow-xl mb-3"
                     style="clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);">
                    <i class="bi bi-cash-stack text-2xl sm:text-3xl text-white"></i>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-foreground">Deposit Funds</h2>
                <p class="text-sm text-muted-foreground mt-1">Add money via M‑Pesa</p>
            </div>

            {{-- M‑Pesa logo --}}
            <div class="flex justify-center mb-6">
                <img src="{{ asset('mpesalogo.png') }}" alt="M‑Pesa"
                     class="w-44 h-28 sm:w-52 sm:h-32 object-contain rounded-xl bg-white/50 backdrop-blur-sm border border-border/30 p-2 shadow-sm" />
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('deposit.store') }}" class="space-y-5" @submit.prevent="submitting = true; $el.submit()">
                @csrf

                {{-- Phone number (floating label) --}}
                <div class="relative">
                    <input type="tel" name="phone" id="phone"
                           value="{{ Auth::user()->phone }}" required
                           placeholder=" "
                           class="peer w-full pl-10 pt-5 pb-2 bg-input border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none transition text-foreground" />
                    <i class="bi bi-phone absolute left-3 top-4 text-muted-foreground transition-colors peer-focus:text-primary" aria-hidden="true"></i>
                    <label for="phone"
                           class="absolute left-10 top-2 text-xs text-muted-foreground transition-all
                                  peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm
                                  peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary">
                        M‑Pesa number
                    </label>
                </div>

                {{-- Amount (floating label) --}}
                <div class="relative">
                    <input type="number" name="amount" id="amount"
                           min="1" required placeholder=" "
                           class="peer w-full pl-10 pt-5 pb-2 bg-input border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none transition text-foreground" />
                    <i class="bi bi-cash absolute left-3 top-4 text-muted-foreground transition-colors peer-focus:text-primary" aria-hidden="true"></i>
                    <label for="amount"
                           class="absolute left-10 top-2 text-xs text-muted-foreground transition-all
                                  peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm
                                  peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary">
                        Amount
                    </label>
                </div>

                {{-- Submit button (primary with loading state) --}}
                <x-primary-button type="submit" x-bind:disabled="submitting"
                    class="w-full justify-center py-3 text-base mt-2 relative">
                    <span x-show="!submitting">
                        <i class="bi bi-send mr-2"></i> Deposit Now
                    </span>
                    <span x-show="submitting" class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        Processing…
                    </span>
                </x-primary-button>
            </form>

            {{-- Footer note --}}
            <p class="mt-5 text-center text-xs text-muted-foreground">
                Ensure your M‑Pesa number is active and you have sufficient balance.
            </p>
        </div>
    </div>
</x-app-layout>