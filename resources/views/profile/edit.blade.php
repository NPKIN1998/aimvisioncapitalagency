<x-app-layout>
    <div class="w-full px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-8">

        {{-- Page heading --}}
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-foreground">{{ __('Profile') }}</h1>
            <p class="mt-1 text-sm text-muted-foreground">Manage your personal information, password, and account.</p>
        </div>

        {{-- Profile Information --}}
        @include('profile.partials.update-profile-information-form')

        {{-- Update Password --}}
        @include('profile.partials.update-password-form')

        {{-- Delete Account --}}
        @include('profile.partials.delete-user-form')

    </div>
</x-app-layout>