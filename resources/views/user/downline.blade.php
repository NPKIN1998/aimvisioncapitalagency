<x-app-layout>
    <div x-data="networkDashboard" class="w-full px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-8">

        {{-- ===== HEADER + STATS ROW ===== --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="sm:col-span-2">
                <h1 class="text-2xl sm:text-3xl font-bold text-foreground">Build Your Team</h1>
                <p class="text-sm text-muted-foreground mt-1">Grow your network and earn rewards.</p>
            </div>
            <div class="bg-card border border-border/30 rounded-2xl p-4 sm:p-5 flex items-center gap-4 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center">
                    <i class="bi bi-people-fill text-2xl text-primary"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-muted-foreground uppercase tracking-wide">Total Downlines</p>
                    <p class="text-xl font-bold text-foreground">{{ $downlines->count() }}</p>
                </div>
            </div>
        </div>

        {{-- ===== REFERRAL LINK CARD (premium) ===== --}}
        <div class="bg-card border border-border/40 rounded-2xl shadow-lg p-5 sm:p-6">
            <div class="flex flex-col sm:flex-row items-stretch gap-4">
                <div class="flex-1 relative">
                    <input type="text" x-ref="referralInput" value="{{ Auth::user()->upline_link }}" disabled
                        class="w-full px-4 py-3 pr-12 rounded-xl bg-input border border-border text-foreground text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-primary transition" />
                    <button @click="copyReferralLink"
                        class="absolute right-2 top-1/2 -translate-y-1/2 p-2 rounded-lg bg-primary text-primary-foreground hover:bg-primary/90 transition focus-visible:outline-2 focus-visible:outline-ring"
                        aria-label="Copy referral link">
                        <i class="bi bi-copy text-lg"></i>
                    </button>
                </div>
                <button @click="shareReferralLink"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-accent text-accent-foreground font-semibold shadow-md hover:shadow-lg hover:bg-accent/90 transition-all text-sm sm:text-base">
                    <i class="bi bi-share-fill"></i>
                    Share
                </button>
            </div>
        </div>

        {{-- ===== SHARE MODAL (redesigned) ===== --}}
        <div x-show="showShareModal" x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-background/60 backdrop-blur-sm p-4">
            <div class="bg-card border border-border/50 rounded-2xl shadow-2xl w-full max-w-md p-6 relative"
                @click.away="showShareModal = false">
                <h3 class="text-lg font-semibold text-foreground mb-5">Share via</h3>
                <div class="grid grid-cols-2 gap-3">
                    <button @click="shareVia('whatsapp')"
                        class="flex items-center justify-center gap-2 py-3 rounded-xl border border-border/30 hover:bg-muted transition font-medium text-foreground">
                        <i class="bi bi-whatsapp text-xl text-green-500"></i> WhatsApp
                    </button>
                    <button @click="shareVia('telegram')"
                        class="flex items-center justify-center gap-2 py-3 rounded-xl border border-border/30 hover:bg-muted transition font-medium text-foreground">
                        <i class="bi bi-telegram text-xl text-blue-500"></i> Telegram
                    </button>
                </div>
                <button @click="showShareModal = false"
                    class="absolute top-4 right-4 p-2 rounded-lg text-muted-foreground hover:text-foreground hover:bg-muted transition">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>

        {{-- ===== TABS (styled like navigation) ===== --}}
        <div x-data="{ activeTab: 'all' }"
            class="bg-card border border-border/30 rounded-2xl shadow-sm overflow-hidden">
            <div class="flex border-b border-border">
                <button @click="activeTab = 'all'"
                    :class="activeTab === 'all' ? 'text-primary border-primary' : 'text-muted-foreground border-transparent'"
                    class="flex-1 px-6 py-3 text-sm font-semibold border-b-2 transition hover:text-foreground">
                    All Downlines
                </button>
                <button @click="activeTab = 'active'"
                    :class="activeTab === 'active' ? 'text-primary border-primary' : 'text-muted-foreground border-transparent'"
                    class="flex-1 px-6 py-3 text-sm font-semibold border-b-2 transition hover:text-foreground">
                    Active Downlines
                </button>
            </div>

            <div class="p-4 sm:p-6">
                {{-- All Downlines --}}
                <div x-show="activeTab === 'all'" class="space-y-3">
                    @forelse ($downlines as $downline)
                        @include('partials.downline-item', ['downline' => $downline])
                    @empty
                        <div class="text-center py-12 text-muted-foreground">
                            <i class="bi bi-people text-4xl mb-3 opacity-50"></i>
                            <p class="text-sm">No downlines yet. Share your referral link to start building.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Active Downlines --}}
                <div x-show="activeTab === 'active'" class="space-y-3">
                    @php
                        $activeDownlines = $downlines->filter(fn($d) => $d->status === 'active');
                    @endphp
                    @forelse ($activeDownlines as $downline)
                        @include('partials.downline-item', ['downline' => $downline])
                    @empty
                        <div class="text-center py-12 text-muted-foreground">
                            <i class="bi bi-person-check text-4xl mb-3 opacity-50"></i>
                            <p class="text-sm">No active downlines yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>