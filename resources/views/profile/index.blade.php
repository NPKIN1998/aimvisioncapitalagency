<x-app-layout>
    <div class="container mx-auto px-4 py-6 z-0">
        <!-- Profile Card -->
        <section
            class="bg-background backdrop-blur-lg overflow-hidden rounded-xl shadow-lg transform transition-transform hover:scale-105 hover-glow relative">
            <div class="p-6">

                <!-- Profile Header -->
                <header class="text-center">
                    <!-- Profile Picture with Animated Gradient Border -->
                    <div
                        class="relative w-28 h-28 mx-auto mb-4 rounded-full bg-linear-to-tr from-purple-500 via-pink-500 to-yellow-500 p-[2px] animate-gradient">
                        <div class="w-full h-full rounded-full overflow-hidden border-4 border-background">
                            <img src="user.png" alt="{{ Auth::user()->name }}"
                                class="w-full h-full object-cover transition-transform hover:scale-105">
                        </div>
                    </div>

                    <!-- User Name -->
                    <h1 class="text-2xl font-bold text-gray-900">{{ Auth::user()->name }}</h1>

                    <!-- User Email -->
                    <p class="mt-1 text-gray-600">{{ Auth::user()->email }}</p>

                    <!-- User Balance with Smooth Animation -->
                    <p class="mt-2 text-lg text-gray-700">
                        Balance:
                        <x-currency-display :amount="Auth::user()->balance" class="font-semibold text-primary" />
                    </p>
                </header>

                <!-- Referral Status -->
                <section class="mt-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Referral Status</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <x-referral-card :count="$activeDownlines" label="Active Referrals" color="green"
                            tooltip="Referrals actively using the platform" />

                        <x-referral-card :count="$downlines - $activeDownlines" label="Inactive Referrals" color="red"
                            tooltip="Referrals not currently active" />
                    </div>
                </section>

                <a href="{{ route('contact-us') }}"
                    class="mt-4 inline-flex items-center justify-center w-full px-6 py-3 rounded-lg bg-primary text-white font-semibold shadow-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all transform hover:scale-105">
                    <div class="flex items-center gap-3">
                        <i class="bi bi-headset"></i>
                        Support
                    </div>
                    <i data-lucide="arrow-right" class="text-primary"></i>
                </a>
                <!-- Actions -->
                <footer class="mt-6 flex flex-col gap-3">
                    <!-- Edit Profile Button -->
                    <a href="{{ route('profile.edit') }}"
                        class="inline-flex items-center justify-center w-full px-6 py-3 rounded-lg bg-primary text-white font-semibold shadow-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all transform hover:scale-105">
                        Edit Profile
                    </a>

                    <!-- Logout Form -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full px-6 py-3 rounded-lg bg-rose-500 text-white font-semibold shadow-md hover:bg-rose-600 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                            Logout
                        </button>
                    </form>
                </footer>
            </div>
        </section>
    </div>

    <!-- Custom Styles for Glow & Gradient Animation -->
    <style>
        .hover-glow:hover {
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
        }

        @keyframes gradient-animation {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient-animation 5s ease infinite;
        }
    </style>
</x-app-layout>
