<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" x-init="
    $watch('darkMode', val => {
        localStorage.setItem('theme', val ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark', val);
    });
    if (darkMode) document.documentElement.classList.add('dark');
">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    {{-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-background text-foreground">

    <!-- Root Alpine state: loader + mobile menu -->
    <div x-data="{ loading: true, mobileMenuOpen: false }" x-init="setTimeout(() => loading = false, 800)" class="relative min-h-dvh">

        <!-- ===== PROFESSIONAL LOADER ===== -->
        <div x-show="loading" x-transition.opacity.duration.500ms
             class="fixed inset-0 z-[200] flex flex-col items-center justify-center gap-8 bg-background/95 backdrop-blur-md"
             role="status" aria-label="Loading your dashboard...">
            <div class="relative">
                <div class="w-20 h-20 border-4 border-primary/20 border-t-primary rounded-full animate-spin"></div>
                <div class="absolute inset-2 border-2 border-primary/10 rounded-full animate-pulse"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-10 h-10 bg-primary flex items-center justify-center shadow-lg"
                         style="clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);">
                        <span class="text-white font-bold text-sm">{{ substr(config('app.name'), 0, 1) }}</span>
                    </div>
                </div>
            </div>
            <p class="text-sm sm:text-base text-muted-foreground font-medium tracking-widest uppercase">
                Preparing your experience
            </p>
        </div>

        <!-- ===== MAIN APP (fades in after loader) ===== -->
        <div x-show="!loading" x-transition.opacity.duration.700ms class="flex flex-col min-h-dvh">

            <!-- Mobile sidebar overlay + panel (now uses root mobileMenuOpen) -->
            <!-- Overlay -->
            <div x-show="mobileMenuOpen" x-transition.opacity.duration.300ms
                 class="fixed inset-0 z-40 bg-black/40 backdrop-blur-sm lg:hidden"
                 @click="mobileMenuOpen = false" aria-hidden="true"></div>

            <!-- Glass panel -->
            <div x-show="mobileMenuOpen" x-cloak
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="fixed inset-y-0 left-0 z-50 w-80 max-w-[85vw] bg-card/85 backdrop-blur-xl border-r border-border/50 shadow-2xl lg:hidden"
                 role="dialog" aria-modal="true" aria-label="Main menu">
                <div class="flex flex-col h-full p-6">
                    <!-- Close button -->
                    <button @click="mobileMenuOpen = false"
                            class="self-end p-2 rounded-lg text-muted-foreground hover:text-foreground hover:bg-muted transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring"
                            aria-label="Close menu">
                        <i class="bi bi-x-lg text-xl"></i>
                    </button>

                    <!-- Brand logo -->
                    <a href="/" class="flex items-center gap-3 mb-8 group" @click="mobileMenuOpen = false">
                        <div class="w-10 h-10 bg-primary flex items-center justify-center shadow-lg"
                             style="clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);">
                            <span class="text-white font-bold text-sm">{{ substr(config('app.name'), 0, 1) }}</span>
                        </div>
                        <span class="text-xl font-semibold text-foreground">{{ config('app.name') }}</span>
                    </a>

                    <!-- Navigation links -->
                    <nav class="flex-1 space-y-1">
                        @foreach (['dashboard' => ['label' => 'Home', 'icon' => 'house'], 'deposit' => ['label' => 'Deposit', 'icon' => 'wallet2'], 'cashout' => ['label' => 'Cash Out', 'icon' => 'cash-coin'], 'task' => ['label' => 'Task', 'icon' => 'check2-square'], 'transactions' => ['label' => 'Transactions', 'icon' => 'arrow-down-up'], 'plan' => ['label' => 'Plan', 'icon' => 'briefcase'], 'grant' => ['label' => 'Grant', 'icon' => 'award'], 'release' => ['label' => 'Property', 'icon' => 'building']] as $route => $item)
                            <a href="{{ route($route) }}" @click="mobileMenuOpen = false"
                               class="flex items-center gap-3 px-4 py-3 rounded-xl text-foreground text-[15px] transition
                                      {{ Route::is($route) ? 'bg-primary/10 font-semibold text-primary' : 'hover:bg-muted' }}">
                                <i class="bi bi-{{ $item['icon'] }} text-lg"></i>
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </nav>

                    <!-- Footer -->
                    <div class="mt-auto pt-6 border-t border-border/30 text-xs text-muted-foreground text-center">
                        &copy; {{ date('Y') }} {{ config('app.name') }}
                    </div>
                </div>
            </div>

            <!-- Header -->
            <header class="sticky top-0 z-30 bg-primary/85 backdrop-blur-xl border-b border-white/10 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-14 sm:h-16">

                        <!-- Left: Mobile menu trigger + page title -->
                        <div class="flex items-center gap-3">
                            <button @click="mobileMenuOpen = true"
                                    class="lg:hidden p-2 rounded-lg text-primary-foreground hover:bg-white/10 transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring"
                                    aria-label="Open menu">
                                <i class="bi bi-list text-2xl"></i>
                            </button>

                            <h2 class="hidden lg:block text-xl font-semibold tracking-tight text-primary-foreground drop-shadow-sm">
                                @yield('title', 'Dashboard')
                            </h2>
                        </div>

                        <!-- Right actions -->
                        <div class="flex items-center gap-2 sm:gap-4">
                            <!-- Dark mode toggle -->
                            <button @click="darkMode = !darkMode"
                                class="p-2 rounded-lg text-primary-foreground hover:bg-white/10 transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring"
                                :aria-label="darkMode ? 'Switch to light mode' : 'Switch to dark mode'">
                                <i class="bi text-xl" :class="darkMode ? 'bi-sun-fill' : 'bi-moon-fill'"></i>
                            </button>

                            <!-- ========== NOTIFICATIONS DROPDOWN (mobile‑first, responsive) ========== -->
                            <div x-data="{ notifOpen: false }" class="relative">
                                <button @click="notifOpen = !notifOpen"
                                        class="relative p-2 rounded-lg text-primary-foreground hover:bg-white/10 transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring"
                                        aria-label="Notifications (3 unread)">
                                    <i class="bi bi-bell text-2xl"></i>
                                    <span class="absolute -top-1 -right-1 flex items-center justify-center w-5 h-5 text-xs font-bold bg-destructive text-destructive-foreground rounded-full shadow-md">
                                        3
                                    </span>
                                </button>

                                <!-- Dropdown panel -->
                                <div x-show="notifOpen" x-cloak x-transition.opacity @click.away="notifOpen = false"
                                    class="absolute right-0 mt-2 w-72 sm:w-80 md:w-96 max-w-[calc(100vw-2rem)] bg-card border border-border/50 rounded-xl shadow-2xl overflow-hidden z-50 backdrop-blur-md">
                                    <!-- Header -->
                                    <div class="flex items-center justify-between px-4 sm:px-5 py-3 border-b border-border/50">
                                        <h3 class="font-semibold text-foreground text-sm">Notifications</h3>
                                        <button @click="notifOpen = false"
                                                class="text-muted-foreground hover:text-foreground transition">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                    <!-- List (scrollable) -->
                                    <div class="max-h-60 sm:max-h-72 overflow-y-auto divide-y divide-border/50">
                                        <!-- Notification item 1 -->
                                        <a href="#" class="flex gap-3 px-4 sm:px-5 py-3 hover:bg-muted transition">
                                            <div class="w-9 h-9 rounded-full bg-accent/20 flex items-center justify-center shrink-0">
                                                <i class="bi bi-wallet2 text-accent"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm text-foreground font-medium truncate">Deposit confirmed</p>
                                                <p class="text-xs text-muted-foreground mt-0.5">$250.00 added to your wallet</p>
                                                <p class="text-xs text-muted-foreground/70 mt-1">5 min ago</p>
                                            </div>
                                        </a>
                                        <!-- Notification item 2 -->
                                        <a href="#" class="flex gap-3 px-4 sm:px-5 py-3 hover:bg-muted transition">
                                            <div class="w-9 h-9 rounded-full bg-primary/20 flex items-center justify-center shrink-0">
                                                <i class="bi bi-briefcase text-primary"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm text-foreground font-medium truncate">Plan activated</p>
                                                <p class="text-xs text-muted-foreground mt-0.5">Gold Plan is now active</p>
                                                <p class="text-xs text-muted-foreground/70 mt-1">1 hour ago</p>
                                            </div>
                                        </a>
                                        <!-- Notification item 3 -->
                                        <a href="#" class="flex gap-3 px-4 sm:px-5 py-3 hover:bg-muted transition">
                                            <div class="w-9 h-9 rounded-full bg-chart-3/20 flex items-center justify-center shrink-0">
                                                <i class="bi bi-gift text-chart-3"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm text-foreground font-medium truncate">Referral bonus</p>
                                                <p class="text-xs text-muted-foreground mt-0.5">You earned $50.00 commission</p>
                                                <p class="text-xs text-muted-foreground/70 mt-1">2 hours ago</p>
                                            </div>
                                        </a>
                                    </div>
                                    <!-- View all link -->
                                    <a href="#" class="block text-center text-sm text-primary font-medium py-3 border-t border-border/50 hover:bg-muted transition">
                                        View all notifications
                                    </a>
                                </div>
                            </div>

                            <!-- User dropdown -->
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open"
                                    class="flex items-center gap-2 p-1 rounded-lg hover:bg-white/10 transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring"
                                    aria-label="User menu">
                                    <img class="w-9 h-9 rounded-full border-2 border-white/60 shadow" src="user.png" alt="User avatar">
                                    <i class="bi bi-chevron-down text-primary-foreground text-lg hidden sm:block"></i>
                                </button>

                                <div x-show="open" x-cloak x-transition.opacity @click.away="open = false"
                                    class="absolute right-0 mt-2 w-52 bg-card border border-border/50 rounded-xl shadow-2xl overflow-hidden z-50 backdrop-blur-md">
                                    <a href="{{ route('profile.index') }}" @click="open = false"
                                       class="flex items-center gap-3 px-4 py-3 text-foreground hover:bg-muted transition">
                                        <i class="bi bi-person-circle text-lg"></i> Profile
                                    </a>
                                    <a href="#" @click="open = false"
                                       class="flex items-center gap-3 px-4 py-3 text-foreground hover:bg-muted transition">
                                        <i class="bi bi-gear text-lg"></i> Settings
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="flex items-center gap-3 w-full px-4 py-3 text-foreground hover:bg-muted transition">
                                            <i class="bi bi-box-arrow-right text-lg"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </header>

            <!-- Toast notification -->
            <x-toast-notification />

            <!-- Main content -->
            <main class="flex-1 pb-24 sm:pb-16 overflow-auto bg-background">
                {{ $slot }}
            </main>

            <!-- Bottom navigation (mobile) – floating glass card -->
            <nav class="fixed bottom-0 inset-x-0 z-50 lg:hidden" aria-label="Main navigation">
                <div class="mx-3 mb-3 bg-card/85 backdrop-blur-xl border border-border/50 rounded-2xl shadow-2xl">
                    <ul class="flex justify-between items-center px-4 py-2">
                        @foreach ([
                            'dashboard' => ['label' => 'Home', 'icon' => 'house'],
                            'downlines' => ['label' => 'Team', 'icon' => 'people'],
                            'plan' => ['label' => 'Plan', 'icon' => 'briefcase'],
                            'deposit' => ['label' => 'Deposit', 'icon' => 'wallet2'],
                            'profile.index' => ['label' => 'Profile', 'icon' => 'person'],
                        ] as $route => $item)
                            @php $active = Route::is($route); @endphp
                            <li>
                                <a href="{{ route($route) }}"
                                   class="flex flex-col items-center gap-0.5 transition-all duration-200 group"
                                   aria-current="{{ $active ? 'page' : 'false' }}">
                                    <div class="p-2 rounded-full {{ $active ? 'bg-primary text-primary-foreground shadow-md' : 'text-muted-foreground group-hover:text-foreground' }}">
                                        <i class="bi bi-{{ $item['icon'] }}{{ $active ? '-fill' : '' }} text-xl transition-transform duration-300 {{ $active ? '-translate-y-0.5' : '' }}"></i>
                                    </div>
                                    <span class="text-[10px] font-medium {{ $active ? 'text-primary' : 'text-muted-foreground' }}">
                                        {{ $item['label'] }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </nav>

            <!-- Toast script -->
            <script>
                @if (session('toast'))
                    window.addEventListener('DOMContentLoaded', () => {
                        window.notify(@json(session('toast')));
                    });
                @endif
            </script>
        </div>
    </div>
</body>
</html>