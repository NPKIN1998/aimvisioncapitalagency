<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <link rel="stylesheet" href="/build/assets/app-Bv6YdaMr.css">
    <link rel="stylesheet" href="/build/assets/app-BI69yjDX.css">
</head>

<body class="bg-background text-foreground font-sans">

    <!-- NAVBAR -->
    <header class="w-full border-b border-border bg-card/50 backdrop-blur-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <h1 class="text-xl font-semibold tracking-tight">
                {{ config('app.name', 'Laravel') }}
            </h1>

            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-5 py-2 rounded-md text-sm border border-border hover:bg-muted">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 text-sm rounded-md hover:bg-muted">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-5 py-2 text-sm rounded-md bg-primary text-primary-foreground hover:opacity-90 shadow-sm">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>


    <!-- HERO SECTION -->
    <section class="max-w-7xl mx-auto px-6 pt-24 pb-28 text-center">
        <h2 class="text-4xl md:text-6xl font-extrabold tracking-tight leading-tight mb-6">
            Empowering Your Financial Growth with
            <span class="text-primary">AimVision Capital Agency</span>
        </h2>

        <p class="text-lg md:text-xl text-muted-foreground max-w-3xl mx-auto mb-10">
            {{ config('app.name') }} helps individuals and businesses access smarter investment tools,
            simplified financial insights, and reliable capital growth strategies—all on one professional platform.
        </p>

        <div class="flex justify-center gap-4">
            <a href="{{ route('register') }}"
                class="px-8 py-3 rounded-lg bg-primary text-primary-foreground font-medium shadow-md hover:opacity-90 transition">
                Create Account
            </a>

            <a href="{{ route('login') }}"
                class="px-8 py-3 rounded-lg border border-border font-medium hover:bg-muted transition">
                Learn More
            </a>
        </div>
    </section>


    <!-- VALUE PROPOSITION SECTION -->
    <section class="max-w-7xl mx-auto px-6 pb-24">
        <h3 class="text-3xl font-semibold text-center mb-12">
            Why AimVision Capital Agency?
        </h3>

        <div class="grid md:grid-cols-3 gap-8">

            <div class="p-8 bg-card rounded-xl shadow-sm border border-border">
                <h4 class="text-xl font-semibold mb-3">Smart Wealth Growth</h4>
                <p class="text-muted-foreground">
                    Access well-structured financial tools designed to help you build, manage,
                    and scale your income streams with confidence.
                </p>
            </div>

            <div class="p-8 bg-card rounded-xl shadow-sm border border-border">
                <h4 class="text-xl font-semibold mb-3">Transparent Processes</h4>
                <p class="text-muted-foreground">
                    Everything is tracked, recorded, and easy to monitor—ensuring clarity and accountability
                    at every step of your financial journey.
                </p>
            </div>

            <div class="p-8 bg-card rounded-xl shadow-sm border border-border">
                <h4 class="text-xl font-semibold mb-3">Secure Digital Platform</h4>
                <p class="text-muted-foreground">
                    Built on top of modern Laravel infrastructure with best-in-class security
                    to ensure your data, transactions, and investments remain protected.
                </p>
            </div>

        </div>
    </section>


    <!-- CALL TO ACTION -->
    <section class="bg-card py-20 border-t border-b border-border">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h3 class="text-3xl font-semibold mb-4">Start Your Financial Journey Today</h3>
            <p class="text-muted-foreground max-w-2xl mx-auto mb-8">
                Join thousands who trust AimVision Capital Agency for reliable growth,
                expert guidance, and secure financial operations.
            </p>

            <a href="{{ route('register') }}"
                class="px-8 py-3 rounded-lg bg-primary text-primary-foreground font-medium shadow-md hover:opacity-90 transition">
                Get Started Now
            </a>
        </div>
    </section>


    <!-- FOOTER -->
    <footer class="border-t border-border py-6 text-center text-sm text-muted-foreground">
        © {{ date('Y') }} {{ config('app.name') }} — All rights reserved.
    </footer>

    <script src="/build/assets/app-DkDD0-hg.js"></script>
</body>

</html>
