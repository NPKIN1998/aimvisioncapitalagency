<x-app-layout>
    <div class="w-full px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-8">

        {{-- Profile Card --}}
        <div class="bg-card border border-border/30 rounded-3xl shadow-lg p-6 sm:p-8">
            {{-- Avatar + Name + Email --}}
            <div class="flex flex-col items-center text-center">
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full border-4 border-primary/20 p-1">
                    <img src="user.png" alt="{{ Auth::user()->name }}" class="w-full h-full rounded-full object-cover">
                </div>
                <h1 class="mt-4 text-xl sm:text-2xl font-bold text-foreground">{{ Auth::user()->name }}</h1>
                <p class="text-sm text-muted-foreground">{{ Auth::user()->email }}</p>
                <div class="mt-3 text-lg">
                    <span class="text-muted-foreground">Balance:</span>
                    <x-currency-display :amount="Auth::user()->balance" class="font-bold text-primary ml-1" />
                </div>
            </div>

            {{-- Referral Stats --}}
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex items-center gap-3 p-4 rounded-2xl bg-accent/10 border border-accent/20">
                    <div class="w-10 h-10 rounded-xl bg-accent/20 flex items-center justify-center">
                        <i class="bi bi-person-check text-xl text-accent"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-foreground">{{ $activeDownlines }}</p>
                        <p class="text-xs text-muted-foreground">Active Referrals</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-4 rounded-2xl bg-muted border border-border/30">
                    <div class="w-10 h-10 rounded-xl bg-muted-foreground/20 flex items-center justify-center">
                        <i class="bi bi-person-x text-xl text-muted-foreground"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-foreground">{{ $downlines - $activeDownlines }}</p>
                        <p class="text-xs text-muted-foreground">Inactive Referrals</p>
                    </div>
                </div>
            </div>

            {{-- Support Link --}}
            <a href="{{ route('contact-us') }}"
                class="mt-6 flex items-center justify-center gap-2 w-full py-3 rounded-xl border border-border/50 text-foreground font-medium hover:bg-muted transition">
                <i class="bi bi-headset"></i> Support
            </a>

            {{-- Action Buttons --}}
            <div class="mt-5 flex flex-col sm:flex-row gap-3">
                <a href="{{ route('profile.edit') }}"
                    class="flex-1 inline-flex items-center justify-center py-3 rounded-xl bg-primary text-primary-foreground font-semibold shadow-md hover:bg-primary/90 transition">
                    Edit Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit"
                        class="w-full py-3 rounded-xl bg-destructive text-destructive-foreground font-semibold shadow-md hover:bg-destructive/90 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>