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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-background text-foreground antialiased overflow-x-hidden">
    <div class="min-h-screen flex">
        <!-- Sidebar Overlay (Mobile) -->
        <div id="sidebar-overlay"
            class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden transition-opacity duration-300" aria-hidden="true">
        </div>
        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-50 w-72 max-w-[85vw] bg-sidebar border-r border-sidebar-border transform-gpu -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-out lg:static lg:inset-0"
            aria-label="Main navigation">
            <!-- Sidebar Header (with close button on mobile) -->
            <div class="flex items-center justify-between h-16 px-4 bg-sidebar border-b border-sidebar-border">
                <h1 class="text-xl font-bold text-sidebar-foreground tracking-tight truncate">
                    {{ config('app.name', 'Laravel') }}
                </h1>
                <button id="sidebar-close"
                    class="lg:hidden p-2 -mr-2 text-sidebar-foreground/70 hover:text-sidebar-foreground transition-colors rounded-md focus:outline-none focus:ring-2 focus:ring-sidebar-primary"
                    aria-label="Close sidebar">
                    <i class="bi bi-x-circle size-5"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto overscroll-contain">
                <!-- Home/Dashboard -->
                <a href="{{ route('admin.index') }}"
                    class="flex items-center px-4 py-3.5 text-sm font-medium rounded-lg transition-colors duration-200 min-h-12 {{ request()->routeIs('admin.index') ? 'bg-sidebar-accent text-sidebar-accent-foreground' : 'text-sidebar-foreground hover:bg-sidebar-accent hover:text-sidebar-accent-foreground' }}">
                    <i class="bi bi-house size-5 mr-3 shrink-0"></i>
                    Dashboard
                </a>

            </nav>
        </aside>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 lg:ml-0">
            <!-- Top Bar (Mobile only) -->
            <header class="bg-card border-b border-border lg:hidden sticky top-0 z-30">
                <div class="flex items-center justify-between h-16 px-4">
                    <button id="sidebar-toggle"
                        class="p-2 -ml-2 text-foreground hover:text-primary transition-colors rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                        aria-label="Open menu">
                        <i class="bi bi-menu-app size-6"></i>
                    </button>
                    <h1 class="text-lg font-semibold text-foreground">Admin Panel</h1>
                    <div class="w-6"></div> <!-- Spacer for centering -->
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-4 sm:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
    <!-- Scripts -->
    <script>
        (function () {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const toggleBtn = document.getElementById('sidebar-toggle');
            const closeBtn = document.getElementById('sidebar-close');
            const body = document.body;

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                body.style.overflow = 'hidden';
                sidebar.setAttribute('aria-hidden', 'false');
                overlay.setAttribute('aria-hidden', 'false');
                // Focus management
                closeBtn?.focus();
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                body.style.overflow = '';
                sidebar.setAttribute('aria-hidden', 'true');
                overlay.setAttribute('aria-hidden', 'true');
                toggleBtn?.focus();
            }

            function toggleSidebar() {
                const isOpen = !sidebar.classList.contains('-translate-x-full');
                isOpen ? closeSidebar() : openSidebar();
            }

            // Event listeners
            toggleBtn?.addEventListener('click', toggleSidebar);
            closeBtn?.addEventListener('click', closeSidebar);
            overlay?.addEventListener('click', closeSidebar);

            // Close on escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
                    closeSidebar();
                }
            });

            // Optional: Swipe to close (basic implementation)
            let touchStartX = 0;
            sidebar.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            }, {
                passive: true
            });

            sidebar.addEventListener('touchend', (e) => {
                const touchEndX = e.changedTouches[0].screenX;
                const diff = touchEndX - touchStartX;
                // Swipe left by at least 50px to close
                if (diff < -50 && !sidebar.classList.contains('-translate-x-full')) {
                    closeSidebar();
                }
            });


        })();
    </script>
</body>

</html>