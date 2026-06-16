<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ========== UNIQUE DESIGN SYSTEM (mobile‑first, accessible) ========== */
        :root {
            --gold: #B8860B;
            /* darker gold – passes AA on white */
            --gold-glow: rgba(184, 134, 11, 0.4);
            --navy-deep: #0b1926;
            --surface-glass: rgba(255, 255, 255, 0.06);
            --border-glass: rgba(255, 255, 255, 0.12);
        }

        /* Base background – mobile first */
        body {
            background: linear-gradient(135deg, var(--background) 0%, #f8fafc 100%);
        }

        /* ---- GRAPH PAPER BACKGROUND – hidden on smallest screens for clarity ---- */
        .graph-bg {
            position: absolute;
            inset: 0;
            opacity: 0;
            background-image:
                linear-gradient(var(--primary) 1px, transparent 1px),
                linear-gradient(90deg, var(--primary) 1px, transparent 1px);
            background-size: 40px 40px;
            mask-image: radial-gradient(ellipse at center, black 30%, transparent 70%);
            pointer-events: none;
        }

        @media (min-width: 640px) {
            .graph-bg {
                opacity: 0.08;
            }
        }

        /* ---- ISOMETRIC CUBE – only on large screens ---- */
        .iso-cube {
            display: none;
        }

        @media (min-width: 1024px) {
            .iso-cube {
                display: block;
                position: absolute;
                right: 5%;
                top: 15%;
                width: 260px;
                height: 260px;
                opacity: 0.12;
                transform: rotateX(60deg) rotateZ(-30deg);
                transform-style: preserve-3d;
                animation: floatCube 12s ease-in-out infinite;
            }

            .iso-cube .face {
                position: absolute;
                width: 100px;
                height: 100px;
                background: var(--primary);
                border: 2px solid rgba(255, 255, 255, 0.3);
                backface-visibility: hidden;
            }

            .face.front {
                transform: translateZ(50px);
                background: var(--primary);
            }

            .face.back {
                transform: rotateY(180deg) translateZ(50px);
                background: var(--secondary);
            }

            .face.left {
                transform: rotateY(-90deg) translateZ(50px);
                background: var(--accent);
            }

            .face.right {
                transform: rotateY(90deg) translateZ(50px);
                background: var(--primary);
            }

            .face.top {
                transform: rotateX(90deg) translateZ(50px);
                background: var(--gold);
            }

            .face.bottom {
                transform: rotateX(-90deg) translateZ(50px);
                background: var(--secondary);
            }
        }

        @keyframes floatCube {

            0%,
            100% {
                transform: rotateX(60deg) rotateZ(-30deg) translateY(0);
            }

            50% {
                transform: rotateX(60deg) rotateZ(-30deg) translateY(-20px);
            }
        }

        /* ---- FROSTED GLASS CARD (mobile‑first, accessible hover) ---- */
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 25px -8px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            padding: 1.5rem;
            border-radius: 1rem;
        }

        @media (min-width: 640px) {
            .glass-card {
                padding: 2rem;
                border-radius: 1.5rem;
                box-shadow: 0 25px 45px -12px rgba(0, 0, 0, 0.15);
            }
        }

        /* Decorative animated border (not essential) – kept for style */
        .glass-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 180deg, var(--primary), var(--gold), var(--accent), var(--primary));
            opacity: 0;
            transition: opacity 0.5s;
            z-index: -1;
            animation: rotateBorder 8s linear infinite paused;
        }

        /* Hover effects only when device supports hover */
        @media (hover: hover) {
            .glass-card:hover::before {
                opacity: 0.3;
                animation-play-state: running;
            }

            .glass-card:hover {
                transform: translateY(-8px);
                border-color: var(--primary);
            }
        }

        @keyframes rotateBorder {
            to {
                transform: rotate(1turn);
            }
        }

        /* ---- GOLD UNDERLINE – darker gold for visibility ---- */
        .gold-underline {
            position: relative;
            display: inline-block;
        }

        .gold-underline::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -4px;
            width: 100%;
            height: 2px;
            background: var(--gold);
            border-radius: 2px;
        }

        @media (min-width: 640px) {
            .gold-underline::after {
                bottom: -6px;
                height: 3px;
            }
        }

        /* ---- LUXURY DIVIDER (ANGLE) – adjusted for mobile ---- */
        .angle-divider {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 50px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--background) 100%);
            clip-path: polygon(0% 70%, 100% 0%, 100% 100%, 0% 100%);
            z-index: 1;
        }

        @media (min-width: 640px) {
            .angle-divider {
                height: 80px;
                clip-path: polygon(0% 60%, 100% 0%, 100% 100%, 0% 100%);
            }
        }

        /* ---- TICKER TAPE – accessible: aria-hidden ---- */
        .ticker {
            background: linear-gradient(90deg, var(--primary) 0%, #1e3a5f 100%);
            color: white;
            padding: 0.4rem 0.75rem;
            font-size: 0.625rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            overflow: hidden;
            white-space: nowrap;
        }

        @media (min-width: 640px) {
            .ticker {
                padding: 0.5rem 1rem;
                font-size: 0.75rem;
                letter-spacing: 0.2em;
            }
        }

        /* ---- CUSTOM ICON BLOCK ---- */
        .icon-custom {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 1rem;
        }

        @media (min-width: 640px) {
            .icon-custom {
                width: 56px;
                height: 56px;
                border-radius: 20px;
                margin-bottom: 1.5rem;
            }
        }

        .icon-custom::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: var(--gold);
            opacity: 0.15;
            transition: transform 0.3s;
        }

        @media (hover: hover) {
            .glass-card:hover .icon-custom::before {
                transform: scale(1.15);
            }
        }

        /* ---- FOCUS VISIBLE – for keyboard accessibility ---- */
        a:focus-visible,
        button:focus-visible {
            outline: 2px solid var(--ring);
            outline-offset: 2px;
            border-radius: 0.25rem;
        }

        /* ---- LOADER ANIMATION (pulse ring) ---- */
        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                opacity: 0.6;
            }

            50% {
                transform: scale(1);
                opacity: 1;
            }

            100% {
                transform: scale(0.8);
                opacity: 0.6;
            }
        }

        .pulse-ring {
            animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>

<body class="font-sans antialiased text-foreground">

    <!-- Alpine.js Loader + Main Content Wrapper -->
    <div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 1200)">

        <!-- ========== LOADER OVERLAY ========== -->
        <div x-show="loading" x-transition.opacity.duration.500ms
            class="fixed inset-0 z-[100] flex flex-col items-center justify-center gap-8 bg-background/95 backdrop-blur-md"
            aria-live="polite" aria-label="Loading">
            <!-- Spinning ring with diamond logo -->
            <div class="relative">
                <!-- Outer ring animated spin -->
                <div class="w-20 h-20 border-4 border-primary/20 border-t-primary rounded-full animate-spin"></div>
                <!-- Inner pulsing ring (decorative) -->
                <div class="absolute inset-2 border-2 border-primary/10 rounded-full pulse-ring"></div>
                <!-- Diamond logo centered -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 bg-primary flex items-center justify-center shadow-lg"
                        style="clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);">
                        <span
                            class="text-white font-bold text-sm sm:text-base">{{ substr(config('app.name'), 0, 1) }}</span>
                    </div>
                </div>
            </div>
            <!-- Loading text -->
            <p class="text-sm sm:text-base text-muted-foreground font-medium tracking-widest uppercase">
                Preparing your experience
            </p>
        </div>

        <!-- ========== MAIN CONTENT (fades in after loader) ========== -->
        <div x-show="!loading" x-transition.opacity.duration.700ms>

            <!-- NAVBAR (mobile‑first, accessible) -->
            <header class="w-full border-b border-white/20 bg-white/60 backdrop-blur-xl sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
                    <a href="/" class="flex items-center gap-2 sm:gap-3 group">
                        <!-- Solid primary diamond logo (high contrast white letter) -->
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-primary text-primary-foreground font-bold flex items-center justify-center text-xs sm:text-sm shadow-lg transition-all duration-300"
                            style="clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%); background-color: var(--primary);">
                            {{ substr(config('app.name'), 0, 1) }}
                        </div>
                        <span class="hidden sm:inline text-lg sm:text-xl font-semibold tracking-tight text-primary">
                            {{ config('app.name') }}
                        </span>
                    </a>

                    @if (Route::has('login'))
                        <nav class="flex items-center gap-2 sm:gap-3">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="inline-flex items-center px-3 py-1.5 sm:px-5 sm:py-2.5 rounded-lg text-xs sm:text-sm font-medium border border-primary/20 hover:bg-primary/5 transition">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center px-3 py-1.5 sm:px-5 sm:py-2.5 text-xs sm:text-sm font-medium rounded-lg hover:bg-white/20 transition">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="inline-flex items-center px-4 py-1.5 sm:px-6 sm:py-2.5 text-xs sm:text-sm font-medium rounded-lg bg-primary text-primary-foreground hover:shadow-xl hover:scale-105 transition-all">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </div>
            </header>

            <!-- TICKER (decorative, aria-hidden) -->
            <div class="ticker" aria-hidden="true">
                <span>↑ Market confidence • Trusted by thousands • Real‑time insights • Secure by design • ↑ Market
                    confidence • Trusted by thousands • Real‑time insights • Secure by design</span>
            </div>

            <!-- HERO SECTION (mobile‑first, stacked) -->
            <section class="relative overflow-hidden bg-background py-8 sm:py-12 lg:py-20">
                <div class="graph-bg" aria-hidden="true"></div>

                <!-- Isometric cube (large screens only) -->
                <div class="iso-cube" aria-hidden="true">
                    <div class="face front"></div>
                    <div class="face back"></div>
                    <div class="face left"></div>
                    <div class="face right"></div>
                    <div class="face top"></div>
                    <div class="face bottom"></div>
                </div>

                <div
                    class="max-w-7xl mx-auto px-4 sm:px-6 grid lg:grid-cols-2 gap-8 sm:gap-12 items-center relative z-10">
                    <!-- Left content -->
                    <div class="text-center lg:text-left">
                        <h1
                            class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-extrabold leading-tight mb-4 sm:mb-6">
                            <span class="text-foreground">Empowering Your</span><br>
                            <span class="gold-underline text-primary">Financial Growth</span>
                        </h1>
                        <p
                            class="text-base sm:text-lg text-muted-foreground max-w-xl mb-6 sm:mb-8 leading-relaxed mx-auto lg:mx-0">
                            {{ config('app.name') }} combines smart automation, deep analytics, and expert strategies to
                            grow your capital in a transparent, secure environment.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center justify-center px-5 py-2.5 sm:px-8 sm:py-3.5 rounded-lg bg-primary text-white font-semibold shadow-lg hover:bg-primary/90 transition-all hover:scale-105 text-sm sm:text-base">
                                Create Account
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center justify-center px-5 py-2.5 sm:px-8 sm:py-3.5 rounded-lg border-2 border-primary/30 font-semibold text-primary hover:bg-primary/5 transition-all text-sm sm:text-base">
                                Learn More
                            </a>
                        </div>
                    </div>

                    <!-- Right: abstract financial chart SVG (decorative) -->
                    <div class="hidden lg:flex justify-center" aria-hidden="true">
                        <svg width="360" height="360" viewBox="0 0 360 360" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect x="30" y="180" width="30" height="120" rx="4" fill="var(--primary)" opacity="0.8" />
                            <rect x="80" y="120" width="30" height="180" rx="4" fill="var(--primary)" opacity="0.9" />
                            <rect x="130" y="60" width="30" height="240" rx="4" fill="var(--primary)" />
                            <rect x="180" y="90" width="30" height="210" rx="4" fill="var(--accent)" opacity="0.9" />
                            <rect x="230" y="30" width="30" height="270" rx="4" fill="var(--accent)" />
                            <path d="M45 170 L95 110 L145 50 L195 80 L245 20" stroke="var(--gold)" stroke-width="5"
                                stroke-linecap="round" stroke-linejoin="round" fill="none" />
                            <circle cx="245" cy="20" r="6" fill="var(--gold)" />
                        </svg>
                    </div>
                </div>

                <!-- Angle divider -->
                <div class="angle-divider" aria-hidden="true"></div>
            </section>

            <!-- VALUE PROPOSITION (glass cards) -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 sm:pb-20 lg:pb-28 relative z-20">
                <div class="text-center mb-10 sm:mb-16">
                    <p
                        class="text-xs sm:text-sm font-semibold uppercase tracking-[0.2em] sm:tracking-[0.3em] text-primary mb-2 sm:mb-3">
                        Your Advantage
                    </p>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold">
                        Designed for <span class="gold-underline">ambitious investors</span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
                    <!-- Card 1 -->
                    <div class="glass-card text-center group">
                        <div class="icon-custom">
                            <svg class="w-6 h-6 sm:w-8 sm:h-8 text-primary" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor">
                                <path d="M12 2 L2 7 L12 12 L22 7 Z" stroke-width="2" stroke-linejoin="round" />
                                <path d="M2 17 L12 22 L22 17" stroke-width="2" stroke-linejoin="round" />
                                <path d="M2 12 L12 17 L22 12" stroke-width="2" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-semibold mb-2 sm:mb-3 text-foreground">Smart Portfolio</h3>
                        <p class="text-sm sm:text-base text-muted-foreground leading-relaxed">
                            Automated rebalancing and intelligent asset allocation tailored to your risk profile.
                        </p>
                    </div>

                    <!-- Card 2 -->
                    <div class="glass-card text-center group">
                        <div class="icon-custom">
                            <svg class="w-6 h-6 sm:w-8 sm:h-8 text-primary" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor">
                                <path d="M9 12 L11 14 L15 10" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <circle cx="12" cy="12" r="10" stroke-width="2" />
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-semibold mb-2 sm:mb-3 text-foreground">Transparent Fees</h3>
                        <p class="text-sm sm:text-base text-muted-foreground leading-relaxed">
                            No hidden costs. Every transaction and management fee is visible and predictable.
                        </p>
                    </div>

                    <!-- Card 3 -->
                    <div class="glass-card text-center group">
                        <div class="icon-custom">
                            <svg class="w-6 h-6 sm:w-8 sm:h-8 text-primary" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor">
                                <rect x="3" y="11" width="18" height="11" rx="2" stroke-width="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" stroke-width="2" />
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-semibold mb-2 sm:mb-3 text-foreground">Bank‑Level Security
                        </h3>
                        <p class="text-sm sm:text-base text-muted-foreground leading-relaxed">
                            Multi‑layer encryption, biometric authentication, and 24/7 monitoring protect your assets.
                        </p>
                    </div>
                </div>
            </section>

            <!-- CTA SECTION (dark, accessible) -->
            <section class="relative py-12 sm:py-20 lg:py-28 overflow-hidden"
                style="background: linear-gradient(135deg, #0a1a2f 0%, #0f2439 100%);">
                <div class="absolute inset-0 opacity-10" aria-hidden="true">
                    <div class="h-full w-full"
                        style="background-image: radial-gradient(circle at 20% 30%, var(--gold) 1px, transparent 1px); background-size: 30px 30px; @media (min-width: 640px) { background-size: 50px 50px; }">
                    </div>
                </div>
                <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10">
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-3 sm:mb-4">Ready to Elevate Your
                        Wealth?</h2>
                    <p class="text-base sm:text-lg text-gray-300 max-w-2xl mx-auto mb-6 sm:mb-10">
                        Join {{ config('app.name') }} today and experience a new standard in intelligent investing.
                    </p>
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 sm:px-10 sm:py-4 rounded-lg bg-primary text-white font-semibold shadow-2xl hover:shadow-xl transition-all transform hover:scale-105 text-sm sm:text-base border-2 border-[var(--gold)]">
                        Get Started Free
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            </section>

            <!-- FOOTER -->
            <footer class="border-t border-gray-200 py-6 sm:py-8 text-center text-xs sm:text-sm text-muted-foreground">
                <div class="max-w-7xl mx-auto px-4 flex flex-col items-center gap-1 sm:gap-2">
                    <p>© {{ date('Y') }} {{ config('app.name') }} — All rights reserved.</p>
                    <p class="text-xs opacity-50">Crafted for the discerning investor.</p>
                </div>
            </footer>

        </div><!-- end main content wrapper -->
    </div><!-- end Alpine x-data -->

</body>

</html>