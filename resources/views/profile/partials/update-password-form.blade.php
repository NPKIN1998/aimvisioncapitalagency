<section class="bg-card border border-border/30 rounded-2xl p-5 sm:p-6 shadow-sm">
    <header class="mb-6">
        <h2 class="text-lg font-semibold text-foreground">{{ __('Update Password') }}</h2>
        <p class="mt-1 text-sm text-muted-foreground">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        {{-- Current Password --}}
        <div class="relative">
            <input type="password" name="current_password" id="update_password_current_password" required
                autocomplete="current-password" placeholder=" "
                class="peer w-full pl-10 pt-5 pb-2 bg-input border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none transition text-foreground" />
            <i class="bi bi-lock absolute left-3 top-4 text-muted-foreground transition-colors peer-focus:text-primary"
                aria-hidden="true"></i>
            <label for="update_password_current_password" class="absolute left-10 top-2 text-xs text-muted-foreground transition-all
                          peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm
                          peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary">
                {{ __('Current Password') }}
            </label>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- New Password --}}
        <div class="relative">
            <input type="password" name="password" id="update_password_password" required autocomplete="new-password"
                placeholder=" "
                class="peer w-full pl-10 pt-5 pb-2 bg-input border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none transition text-foreground" />
            <i class="bi bi-lock-fill absolute left-3 top-4 text-muted-foreground transition-colors peer-focus:text-primary"
                aria-hidden="true"></i>
            <label for="update_password_password" class="absolute left-10 top-2 text-xs text-muted-foreground transition-all
                          peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm
                          peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary">
                {{ __('New Password') }}
            </label>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div class="relative">
            <input type="password" name="password_confirmation" id="update_password_password_confirmation" required
                autocomplete="new-password" placeholder=" "
                class="peer w-full pl-10 pt-5 pb-2 bg-input border border-border rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none transition text-foreground" />
            <i class="bi bi-lock-fill absolute left-3 top-4 text-muted-foreground transition-colors peer-focus:text-primary"
                aria-hidden="true"></i>
            <label for="update_password_password_confirmation" class="absolute left-10 top-2 text-xs text-muted-foreground transition-all
                          peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm
                          peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary">
                {{ __('Confirm Password') }}
            </label>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button class="px-6 py-2.5">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-accent font-medium">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>