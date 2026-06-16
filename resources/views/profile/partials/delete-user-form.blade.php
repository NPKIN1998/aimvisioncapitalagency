<section class="bg-card border border-border/30 rounded-2xl p-5 sm:p-6 shadow-sm space-y-6"
    x-data="{ confirmDelete: false }">

    <header>
        <h2 class="text-lg font-semibold text-foreground">{{ __('Delete Account') }}</h2>
        <p class="mt-1 text-sm text-muted-foreground">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button @click="confirmDelete = true"
        class="inline-flex items-center px-6 py-3 rounded-xl bg-destructive text-destructive-foreground font-semibold shadow-md hover:bg-destructive/90 transition active:scale-[0.98] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring">
        {{ __('Delete Account') }}
    </button>

    {{-- Confirmation Modal --}}
    <div x-show="confirmDelete" x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-background/60 backdrop-blur-sm"
        @click.self="confirmDelete = false">
        <div class="w-full max-w-md bg-card border border-border/30 rounded-2xl shadow-2xl p-6 sm:p-8">
            <h2 class="text-xl font-semibold text-foreground mb-2">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>
            <p class="text-sm text-muted-foreground mb-6">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                {{-- Password field --}}
                <div class="relative mb-6">
                    <input type="password" name="password" id="delete_password" required placeholder=" "
                        class="peer w-full pl-10 pt-5 pb-2 bg-input border border-border rounded-xl focus:border-destructive focus:ring-2 focus:ring-destructive/30 outline-none transition text-foreground" />
                    <i class="bi bi-lock absolute left-3 top-4 text-muted-foreground transition-colors peer-focus:text-destructive"
                        aria-hidden="true"></i>
                    <label for="delete_password" class="absolute left-10 top-2 text-xs text-muted-foreground transition-all
                                  peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm
                                  peer-focus:top-2 peer-focus:text-xs peer-focus:text-destructive">
                        {{ __('Password') }}
                    </label>
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="flex flex-col sm:flex-row gap-3 justify-end">
                    <button type="button" @click="confirmDelete = false"
                        class="px-5 py-2.5 rounded-xl border border-border/50 text-foreground font-medium hover:bg-muted transition">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-destructive text-destructive-foreground font-semibold shadow-md hover:bg-destructive/90 transition">
                        {{ __('Delete Account') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>