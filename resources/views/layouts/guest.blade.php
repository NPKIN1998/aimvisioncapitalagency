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

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <!-- Bootstrap Icons (for form icons) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    <!-- Alpine.js wrapper – loader then content -->
    <div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 1200)">

        <!-- ===== PROFESSIONAL LOADER ===== -->
        <div x-show="loading" x-transition.opacity.duration.500ms
            class="fixed inset-0 z-[100] flex flex-col items-center justify-center gap-8 bg-background/95 backdrop-blur-md"
            role="status" aria-label="Loading...">
            <!-- Spinner -->
            <div class="relative">
                <!-- Outer ring spin -->
                <div class="w-20 h-20 border-4 border-primary/20 border-t-primary rounded-full animate-spin"></div>
                <!-- Inner pulsing ring -->
                <div class="absolute inset-2 border-2 border-primary/10 rounded-full animate-pulse"></div>
                <!-- Diamond logo -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 bg-primary flex items-center justify-center shadow-lg"
                        style="clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);">
                        <span
                            class="text-white font-bold text-sm sm:text-base">{{ substr(config('app.name'), 0, 1) }}</span>
                    </div>
                </div>
            </div>
            <!-- Label -->
            <p class="text-sm sm:text-base text-muted-foreground font-medium tracking-widest uppercase">
                Preparing your experience
            </p>
        </div>

        <!-- ===== MAIN PAGE (fades in) ===== -->
        <div x-show="!loading" x-transition.opacity.duration.700ms class="min-h-dvh flex flex-col bg-background">

            <!-- Subtle background pattern (decorative) -->
            <div class="absolute inset-0 opacity-5 pointer-events-none" aria-hidden="true"
                style="background-image: linear-gradient(var(--primary) 1px, transparent 1px), linear-gradient(90deg, var(--primary) 1px, transparent 1px); background-size: 40px 40px;">
            </div>

            <!-- Brand ticker (decorative) -->
            <div class="relative z-10 w-full bg-primary text-primary-foreground text-[0.6rem] sm:text-xs font-medium uppercase tracking-widest overflow-hidden whitespace-nowrap py-1"
                aria-hidden="true">
                <span>{{ config('app.name') }} • Secure • Transparent • Reliable • {{ config('app.name') }} • Secure •
                    Transparent • Reliable</span>
            </div>

            <!-- Centered content -->
            <main class="flex-1 flex flex-col items-center justify-center px-4 py-8 sm:px-6 relative z-10">
                <!-- Brand lockup -->
                <a href="/" class="flex flex-col items-center gap-2 sm:gap-3 mb-6 sm:mb-8 group"
                    aria-label="{{ config('app.name') }} – Home">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-primary flex items-center justify-center shadow-xl transition-transform group-hover:scale-105"
                        style="clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);">
                        <span
                            class="text-white font-bold text-lg sm:text-xl">{{ substr(config('app.name'), 0, 1) }}</span>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-semibold tracking-tight text-primary">
                        {{ config('app.name') }}
                    </h1>
                </a>

                <!-- Auth form slot -->
                <div class="w-full max-w-lg">
                    {{ $slot }}
                </div>
            </main>

            <!-- Footer -->
            <footer class="relative z-10 py-4 text-center text-xs text-muted-foreground/70 border-t border-border/30">
                &copy; {{ date('Y') }} {{ config('app.name') }} &mdash; All rights reserved.
            </footer>
        </div>
    </div>

</body>

</html>