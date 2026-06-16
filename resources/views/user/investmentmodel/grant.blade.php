<x-app-layout>
    <div class="min-h-screen bg-background px-4 py-6 space-y-8">

        {{-- FORM CARD --}}
        <div class="max-w-xl mx-auto">

            <div class="bg-card border border-border rounded-3xl p-5 shadow-sm">

                <h2 class="text-xl font-bold text-foreground text-center">
                    Grant Application
                </h2>

                <p class="text-sm text-muted-foreground text-center mt-2">
                    Apply for financial support by filling the form below.
                </p>

                <form class="space-y-4 mt-6" method="POST" action="{{ route('grant.store') }}">
                    @csrf

                    {{-- PHONE --}}
                    <div>
                        <label class="text-sm font-medium text-foreground">
                            Phone Number
                        </label>

                        <input type="tel" name="phone" value="{{ Auth::user()->phone }}" readonly
                            class="mt-2 w-full rounded-xl border border-border bg-muted/40 px-4 py-3 text-foreground">
                    </div>

                    {{-- AMOUNT --}}
                    <div>
                        <label class="text-sm font-medium text-foreground">
                            Grant Amount (KES)
                        </label>

                        <input type="number" name="amount" min="2500" placeholder="Minimum 2,500"
                            class="mt-2 w-full rounded-xl border border-border bg-input px-4 py-3 text-foreground placeholder:text-muted-foreground focus:border-primary focus:ring-2 focus:ring-primary/20">

                        <p class="text-xs text-muted-foreground mt-1">
                            Minimum eligible amount is KES 2,500
                        </p>
                    </div>

                    {{-- BUTTON --}}
                    <button type="submit"
                        class="w-full h-12 rounded-2xl bg-primary text-primary-foreground font-semibold active:scale-[0.98] transition">
                        Apply for Grant
                    </button>

                </form>

            </div>
        </div>

        {{-- GRANTS HISTORY --}}
        <div class="max-w-4xl mx-auto space-y-4">

            <h2 class="text-lg font-semibold text-foreground">
                Your Grant Requests
            </h2>

            {{-- MOBILE: CARD LIST --}}
            <div class="space-y-3 md:hidden">

                @forelse ($grants as $grant)

                    <div class="bg-card border border-border rounded-3xl p-4 shadow-sm">

                        <div class="flex justify-between items-start">

                            <div>
                                <p class="text-sm font-semibold text-foreground">
                                    KES {{ number_format($grant->capital, 2) }}
                                </p>

                                <p class="text-xs text-muted-foreground mt-1">
                                    {{ $grant->date->format('M d, Y') }}
                                </p>
                            </div>

                            <span class="text-[10px] px-2 py-1 rounded-full font-medium
                                    @if($grant->status === 'active')
                                        bg-accent/10 text-accent
                                    @elseif($grant->status === 'pending')
                                        bg-primary/10 text-primary
                                    @else
                                        bg-muted text-muted-foreground
                                    @endif">
                                {{ ucfirst($grant->status) }}
                            </span>

                        </div>

                        <div class="mt-3 flex justify-between text-xs">
                            <span class="text-muted-foreground">Return</span>
                            <span class="font-semibold text-foreground">
                                KES {{ number_format($grant->return, 2) }}
                            </span>
                        </div>

                    </div>

                @empty
                    <div class="text-center py-10 text-muted-foreground text-sm">
                        No grant requests found.
                    </div>
                @endforelse

            </div>

            {{-- DESKTOP TABLE --}}
            <div class="hidden md:block bg-card border border-border rounded-3xl overflow-hidden">

                <table class="w-full text-sm">

                    <thead class="bg-muted/40 text-muted-foreground">
                        <tr>
                            <th class="p-3 text-left">Amount</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Return</th>
                            <th class="p-3 text-left">Date</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-border">

                        @forelse ($grants as $grant)
                            <tr class="hover:bg-muted/30 transition">

                                <td class="p-3 text-foreground font-medium">
                                    KES {{ number_format($grant->capital, 2) }}
                                </td>

                                <td class="p-3">
                                    <span class="text-[11px] px-2 py-1 rounded-full font-medium
                                            @if ($grant->status === 'active')
                                                bg-accent/10 text-accent
                                            @elseif ($grant->status === 'pending')
                                                bg-primary/10 text-primary
                                            @else
                                                bg-muted text-muted-foreground
                                            @endif">
                                        {{ ucfirst($grant->status) }}
                                    </span>
                                </td>

                                <td class="p-3 text-foreground">
                                    KES {{ number_format($grant->return, 2) }}
                                </td>

                                <td class="p-3 text-muted-foreground">
                                    {{ $grant->date->format('M d, Y') }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center p-6 text-muted-foreground">
                                    No grants found.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
</x-app-layout>