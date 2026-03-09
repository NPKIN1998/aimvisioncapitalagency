<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <link rel="stylesheet" href="/build/assets/app-Bv6YdaMr.css">
    <link rel="stylesheet" href="/build/assets/app-BI69yjDX.css">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="relative flex flex-col min-h-screen bg-background text-foreground">

        <!-- Header -->
        <header class="bg-primary text-primary-foreground shadow-sm backdrop-blur-md relative z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">

                    <!-- Mobile Menu -->
                    <div x-data="{ mobileMenuOpen: false }" class="relative lg:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen"
                            class="text-white p-2 rounded-lg hover:bg-white/10 transition focus:outline-none focus:ring-2 focus:ring-white/30"
                            aria-label="Toggle Menu">
                            <i class="bi bi-list text-2xl"></i>
                        </button>

                        <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-2"
                            class="fixed top-16 left-0 w-64 bg-primary rounded-xl shadow-xl border border-white/10 overflow-hidden z-[9999]">

                            @php
                                $mobileNav = [
                                    ['route' => 'dashboard', 'label' => 'Home', 'icon' => 'house'],
                                    ['route' => 'deposit', 'label' => 'Deposit', 'icon' => 'wallet2'],
                                    ['route' => 'plan', 'label' => 'Plan', 'icon' => 'briefcase'],
                                    ['route' => 'grant', 'label' => 'Grant', 'icon' => 'award'],
                                    ['route' => 'release', 'label' => 'Property', 'icon' => 'building'],
                                ];
                            @endphp

                            @foreach ($mobileNav as $item)
                                @php $isActive = Route::is($item['route']); @endphp
                                <a href="{{ route($item['route']) }}" @click="mobileMenuOpen = false"
                                    class="flex items-center gap-3 px-5 py-3 text-white text-[15px] transition
                                    {{ $isActive ? 'bg-white/10 font-semibold' : 'hover:bg-white/10' }}">
                                    <i class="bi bi-{{ $item['icon'] }} text-lg"></i>
                                    {{ $item['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Page Title (Desktop) -->
                    <h2 class="hidden lg:block text-xl font-semibold tracking-tight drop-shadow-sm">
                        {{ __('Dashboard') }}
                    </h2>

                    <!-- Right Actions -->
                    <div class="flex items-center gap-4">

                        <!-- Notifications -->
                        <button
                            class="relative p-2 rounded-lg hover:bg-white/10 transition focus:outline-none focus:ring-2 focus:ring-white/30"
                            aria-label="Notifications">
                            <i class="bi bi-bell text-2xl text-white"></i>
                            <span
                                class="absolute -top-1.5 -right-1.5 flex items-center justify-center w-5 h-5 text-xs font-bold bg-red-600 text-white rounded-full shadow-md">
                                3
                            </span>
                        </button>

                        <!-- User Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                class="flex items-center gap-2 p-1 rounded-lg hover:bg-white/10 transition focus:ring-2 focus:ring-white/30"
                                aria-label="User Menu">
                                <img class="w-10 h-10 rounded-full border-2 border-white shadow"
                                    src="https://ui-avatars.com/api/?name=User" alt="User Avatar">
                                <i class="bi bi-chevron-down text-white text-lg"></i>
                            </button>

                            <div x-show="open" x-cloak x-transition.opacity @click.away="open = false"
                                class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden z-9999>

                                <a href="{{ route('profile.index') }}"
                                @click="open = false"
                                class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-100 transition">
                                <i class="bi bi-person-circle text-lg"></i> Profile
                                </a>

                                <a href="#" @click="open = false"
                                    class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-100 transition">
                                    <i class="bi bi-gear text-lg"></i> Settings
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-3 w-full px-4 py-3 text-gray-700 hover:bg-gray-100 transition">
                                        <i class="bi bi-box-arrow-right text-lg"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </header>

        <x-toast-notification />

        <!-- Page Content -->
        <main class="flex-1 h-full bg-background pb-20 overflow-auto">
            {{ $slot }}
        </main>

        <!-- Bottom Navigation (Mobile) -->
        <nav class="fixed bottom-0 inset-x-0 z-50">
            <div
                class="w-full mx-auto bg-primary/90 backdrop-blur-xl border-t border-white/10 shadow-[0_-4px_20px_rgba(0,0,0,0.25)] rounded-t-3xl">
                <ul class="flex justify-between items-center px-6 py-2">

                    @php
                        $bottomNav = [
                            ['route' => 'dashboard', 'label' => 'Home', 'icon' => 'house'],
                            ['route' => 'downlines', 'label' => 'Team', 'icon' => 'people'],
                            ['route' => 'plan', 'label' => 'Plan', 'icon' => 'briefcase'],
                            ['route' => 'deposit', 'label' => 'Deposit', 'icon' => 'wallet2'],
                            ['route' => 'profile.index', 'label' => 'Profile', 'icon' => 'person'],
                        ];
                    @endphp

                    @foreach ($bottomNav as $nav)
                        @php $active = Route::is($nav['route']); @endphp
                        <li>
                            <a href="{{ route($nav['route']) }}"
                                class="flex flex-col items-center space-y-1 transition-all duration-200 {{ $active ? 'scale-110 text-white' : 'text-white/70 hover:text-white' }}">
                                <div
                                    class="{{ $active ? 'p-2 rounded-full border border-white/40 shadow-lg bg-white/10' : '' }}">
                                    <i
                                        class="bi bi-{{ $nav['icon'] }}{{ $active ? '-fill' : '' }} text-xl transition-transform duration-300 {{ $active ? '-translate-y-1' : '' }}"></i>
                                </div>
                                <span class="text-[11px] font-medium tracking-wide">{{ $nav['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </nav>

        <script>
            @if (session('toast'))
                window.addEventListener('DOMContentLoaded', () => {
                    window.notify(@json(session('toast')));
                });
            @endif
        </script>
    </div>

    <script src="/build/assets/app-DkDD0-hg.js"></script>
</body>

</html>
