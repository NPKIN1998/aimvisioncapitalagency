<section class="bg-card border border-border/30 rounded-2xl p-5 sm:p-6 shadow-sm">
    <header class="mb-6">
        <h2 class="text-lg font-semibold text-foreground">{{ __('Profile Information') }}</h2>
        <p class="mt-1 text-sm text-muted-foreground">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-foreground" />
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus
                autocomplete="name"
                class="mt-1 block w-full px-4 py-2.5 bg-input border border-border rounded-xl text-foreground focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none transition" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-foreground" />
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                autocomplete="username"
                class="mt-1 block w-full px-4 py-2.5 bg-input border border-border rounded-xl text-foreground focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none transition" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-3 text-sm">
                    <p class="text-foreground">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification"
                            class="underline text-primary hover:text-primary/80 transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-accent">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button class="px-6 py-2.5">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-accent font-medium">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>