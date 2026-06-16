<x-app-layout>
    <div class="min-h-screen bg-background">
        <!-- Mobile Header -->
        <div class="px-4 pt-6 pb-4">
            <h1 class="text-2xl font-bold text-foreground">
                Withdraw Funds
            </h1>
            <p class="text-sm text-muted-foreground mt-1">
                Send money directly to your mobile wallet.
            </p>
        </div>

        <!-- Content -->
        <div class="px-4 pb-24">
            <div class="bg-card border border-border rounded-2xl p-4 shadow-sm">

                <!-- Logo -->
                <div class="flex justify-center mb-5">
                    <img src="{{ asset('mpesalogo.png') }}" alt="M-Pesa" class="h-20 w-auto object-contain">
                </div>

                <form method="POST" action="{{ route('cashout.store') }}" class="space-y-4">

                    @csrf

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-2">
                            Mobile Number
                        </label>

                        <input type="tel" name="phone" value="{{ old('phone', Auth::user()->phone) }}"
                            placeholder="07XXXXXXXX"
                            class="w-full rounded-xl border border-border bg-input px-4 py-3 text-foreground placeholder:text-muted-foreground focus:ring-2 focus:ring-primary/20 focus:border-primary">
                    </div>

                    <!-- Method -->
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-2">
                            Withdrawal Method
                        </label>

                        <select name="method"
                            class="w-full rounded-xl border border-border bg-input px-4 py-3 text-foreground focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            <option value="mpesa">M-Pesa</option>
                            <option value="airtel">Airtel Money</option>
                        </select>
                    </div>

                    <!-- Amount -->
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-2">
                            Amount (KES)
                        </label>

                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground">
                                KES
                            </span>

                            <input type="number" min="1" name="amount" placeholder="0.00"
                                class="w-full rounded-xl border border-border bg-input pl-14 pr-4 py-3 text-foreground placeholder:text-muted-foreground focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="bg-accent/10 border border-accent/20 rounded-xl p-3">
                        <div class="flex gap-3">
                            <i class="bi bi-info-circle text-accent mt-0.5"></i>

                            <p class="text-xs text-muted-foreground leading-relaxed">
                                Withdrawals are reviewed before processing.
                                Ensure your phone number is correct.
                            </p>
                        </div>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full h-12 rounded-xl bg-primary text-primary-foreground font-semibold active:scale-[0.98] transition">
                        Withdraw Now
                    </button>
                </form>
            </div>
        </div>

        <!-- Desktop Enhancement -->
        <style>
            @media (min-width: 768px) {
                .withdraw-container {
                    max-width: 32rem;
                    margin-inline: auto;
                }
            }
        </style>
    </div>
</x-app-layout>