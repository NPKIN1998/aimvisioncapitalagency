<x-app-layout>
    <div x-data="networkDashboard" class="p-4 sm:p-6 lg:p-8 space-y-6">

        <!-- Header -->
        <h2 class="text-2xl sm:text-3xl font-bold text-center text-foreground">
            Build Your Team
        </h2>

        <!-- Referral Link Card -->
        <div class="bg-card shadow-lg rounded-radius p-4 sm:p-6 flex flex-col sm:flex-row items-center gap-4">
            <input type="text" x-ref="referralInput" value="{{ Auth::user()->upline_link }}" disabled
                class="flex-1 px-3 py-2 border border-border rounded-radius-md text-sm sm:text-base bg-input text-foreground focus:outline-none focus:ring-2 focus:ring-primary" />
            <div class="flex gap-2">
                <button @click="copyReferralLink"
                    class="bg-primary text-primary-foreground px-4 py-2 rounded-radius-md hover:bg-primary)/90] transition">
                    Copy
                </button>
                <button @click="shareReferralLink"
                    class="bg-accent text-accent-foreground px-4 py-2 rounded-radius-md hover:bg-accent)/90] transition">
                    Share
                </button>
            </div>
        </div>

        <!-- Share Modal -->
        <div x-show="showShareModal" x-transition.opacity
            class="fixed inset-0 bg-background/50 flex items-center justify-center z-50">
            <div class="bg-card rounded-radius p-6 w-11/12 max-w-md relative shadow-xl">
                <h3 class="text-lg font-semibold mb-4 text-foreground">Share Your Referral Link</h3>
                <div class="flex flex-col gap-3">
                    <button @click="shareVia('whatsapp')"
                        class="flex items-center gap-2 px-4 py-2 bg-green-500 text-white rounded-radius-sm hover:bg-green-600 transition">
                        <i class="bi bi-whatsapp text-xl"></i> WhatsApp
                    </button>
                    <button @click="shareVia('telegram')"
                        class="flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded-radius-sm hover:bg-blue-600 transition">
                        <i class="bi bi-telegram text-xl"></i> Telegram
                    </button>
                </div>
                <button @click="showShareModal = false"
                    class="absolute top-3 right-3 text-muted-foreground hover:text-foreground transition">
                    <i class="bi bi-x-lg text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Tabs Section -->
        <div x-data="{ activeTab: 'all' }" class="bg-card shadow-lg rounded-radius p-4 sm:p-6">
            <div class="flex gap-4 border-b border-border mb-4">
                <button @click="activeTab = 'all'"
                    :class="activeTab === 'all' ? 'font-semibold border-b-2 border-primary text-primary' :
                        'text-muted-foreground'"
                    class="px-4 py-2 w-1/2  transition">
                    All Downlines
                </button>
                <button @click="activeTab = 'active'"
                    :class="activeTab === 'active' ? 'font-semibold border-b-2 border-primary text-primary' :
                        'text-muted-foreground'"
                    class="px-4 py-2 w-1/2  transition">
                    Active Downlines
                </button>
            </div>

            <!-- All Downlines -->
            <div x-show="activeTab === 'all'" class="flex flex-col gap-3">
                @forelse ($downlines as $downline)
                    @include('partials.downline-item', ['downline' => $downline])
                @empty
                    <p class="text-muted-foreground text-center py-4">No downlines yet.</p>
                @endforelse
            </div>

            <!-- Active Downlines -->
            <div x-show="activeTab === 'active'" class="flex flex-col gap-3">
                @php
                    $activeDownlines = $downlines->filter(fn($d) => $d->status === 'active');
                @endphp
                @forelse ($activeDownlines as $downline)
                    @include('partials.downline-item', ['downline' => $downline])
                @empty
                    <p class="text-muted-foreground text-center py-4">No active downlines yet.</p>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>
