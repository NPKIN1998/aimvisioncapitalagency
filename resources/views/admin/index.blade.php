<x-layouts.admin-layout>
    <!-- Page Header -->
    <div class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-foreground tracking-tight">Admin Dashboard</h1>
            <p class="text-sm sm:text-base text-muted-foreground mt-1 sm:mt-2">Welcome back! Here's what's happening
                with your platform today.</p>
        </div>
        <div class="flex items-center justify-between sm:justify-end sm:space-x-3">
            <div class="text-right">
                <p class="text-xs sm:text-sm text-muted-foreground">Last updated</p>
                <p class="text-xs sm:text-sm font-medium" x-text="new Date().toLocaleString()"></p>
            </div>
            <button
                class="bg-primary text-primary-foreground px-3 py-2 sm:px-4 sm:py-2 rounded-lg hover:bg-primary/90 transition-colors flex items-center space-x-2 text-sm">
                <i class="bi bi-repeat size-4"></i>
                <span>Refresh</span>
            </button>
        </div>
    </div>

</x-layouts.admin-layout>