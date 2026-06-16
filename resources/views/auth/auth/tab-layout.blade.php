<x-guest-layout>
    <div x-data="{
            active: '{{ request()->routeIs('register') ? 'register' : 'login' }}',
            showPassword: false,
            submitting: false,
            password: '',
            passwordStrength: 0,
            getStrength(password) {
                let score = 0;
                if (password.length >= 8) score++;
                if (/[A-Z]/.test(password)) score++;
                if (/[0-9]/.test(password)) score++;
                if (/[^A-Za-z0-9]/.test(password)) score++;
                this.passwordStrength = score;
            }
        }" class="w-full relative">

        <!-- Decorative glowing blob behind the card (premium touch) -->
        <div class="absolute -top-32 -left-32 w-64 h-64 rounded-full bg-primary/10 blur-3xl animate-pulse pointer-events-none"
            aria-hidden="true"></div>
        <div class="absolute -bottom-32 -right-32 w-64 h-64 rounded-full bg-accent/10 blur-3xl animate-pulse pointer-events-none"
            aria-hidden="true"></div>

        <!-- ===== TABS ===== -->
        <div class="flex border-b border-border mb-6" role="tablist" aria-label="Authentication">
            <!-- Register tab -->
            <button @click="active = 'register'; window.history.pushState({}, '', '{{ route('register') }}')" role="tab"
                :aria-selected="active === 'register'"
                class="relative w-1/2 py-3 text-center font-medium transition text-sm flex items-center justify-center gap-2"
                :class="active === 'register'
                    ? 'text-foreground'
                    : 'text-muted-foreground hover:text-foreground'">
                <i class="bi bi-person-plus-fill text-lg" aria-hidden="true"></i>
                Register
                <span class="absolute bottom-0 left-0 h-0.5 bg-primary transition-all duration-300"
                    :class="active === 'register' ? 'w-full' : 'w-0'"></span>
            </button>

            <!-- Login tab -->
            <button @click="active = 'login'; window.history.pushState({}, '', '{{ route('login') }}')" role="tab"
                :aria-selected="active === 'login'"
                class="relative w-1/2 py-3 text-center font-medium transition text-sm flex items-center justify-center gap-2"
                :class="active === 'login'
                    ? 'text-foreground'
                    : 'text-muted-foreground hover:text-foreground'">
                <i class="bi bi-box-arrow-in-right text-lg" aria-hidden="true"></i>
                Login
                <span class="absolute bottom-0 left-0 h-0.5 bg-primary transition-all duration-300"
                    :class="active === 'login' ? 'w-full' : 'w-0'"></span>
            </button>
        </div>

        <!-- ===== FORM CARD (glass style + animated border) ===== -->
        <div
            class="relative bg-card/90 backdrop-blur-md border border-border/50 rounded-2xl shadow-2xl p-6 sm:p-8 overflow-hidden group">
            <!-- Rotating conic gradient on hover (like landing cards) -->
            <div class="absolute inset-0 opacity-0 group-hover:opacity-30 transition-opacity duration-500 pointer-events-none"
                aria-hidden="true"
                style="background: conic-gradient(from 180deg, var(--primary), var(--gold), var(--accent), var(--primary));">
            </div>

            <!-- ========== REGISTER FORM ========== -->
            <div x-show="active === 'register'" x-transition role="tabpanel" aria-labelledby="register-tab">

                <header class="text-center mb-8">
                    <h2 class="text-2xl font-semibold text-foreground">
                        <i class="bi bi-person-plus-fill mr-1" aria-hidden="true"></i>
                        Create an Account
                    </h2>
                    <p class="text-sm text-muted-foreground mt-2">Join {{ config('app.name') }} and unlock premium
                        features.</p>
                </header>

                <form method="POST" action="{{ route('register.store') }}" class="space-y-6" novalidate
                    @submit.prevent="submitting = true; $el.submit()">
                    @csrf

                    <!-- ===== Section: Personal Information ===== -->
                    <div class="space-y-4">
                        <p
                            class="text-xs font-semibold uppercase tracking-wider text-muted-foreground border-b border-border/50 pb-1">
                            Personal Information</p>

                        <!-- Name (floating label) -->
                        <div class="relative">
                            <x-text-input id="register-name"
                                class="peer mt-0 w-full pl-10 pt-5 pb-2 bg-input border-border focus:border-primary focus:ring-primary"
                                type="text" name="name" required autofocus autocomplete="name" placeholder=" " />
                            <i class="bi bi-person absolute left-3 top-4 text-muted-foreground transition-colors peer-focus:text-primary"
                                aria-hidden="true"></i>
                            <label for="register-name"
                                class="absolute left-10 top-2 text-xs text-muted-foreground transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-placeholder-shown:text-muted-foreground peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary">
                                Full name
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />

                        <!-- Username -->
                        <div class="relative">
                            <x-text-input id="register-username"
                                class="peer mt-0 w-full pl-10 pt-5 pb-2 bg-input border-border focus:border-primary focus:ring-primary"
                                type="text" name="username" required autocomplete="username" placeholder=" " />
                            <i class="bi bi-at absolute left-3 top-4 text-muted-foreground transition-colors peer-focus:text-primary"
                                aria-hidden="true"></i>
                            <label for="register-username"
                                class="absolute left-10 top-2 text-xs text-muted-foreground transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-placeholder-shown:text-muted-foreground peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary">
                                Username
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('username')" class="mt-1" />
                    </div>

                    <!-- ===== Section: Contact Details ===== -->
                    <div class="space-y-4">
                        <p
                            class="text-xs font-semibold uppercase tracking-wider text-muted-foreground border-b border-border/50 pb-1">
                            Contact Details</p>

                        <!-- Country -->
                        <div class="relative">
                            <select id="register-country" name="country"
                                class="peer mt-0 w-full pl-10 pt-5 pb-2 rounded-lg bg-input border-border focus:border-primary focus:ring-primary text-foreground appearance-none">
                                <option value="" selected disabled hidden></option>
                                @foreach (['US' => 'United States', 'UK' => 'United Kingdom', 'CA' => 'Canada', 'NG' => 'Nigeria', 'KE' => 'Kenya', 'GH' => 'Ghana', 'IN' => 'India', 'PH' => 'Philippines'] as $code => $label)
                                    <option value="{{ $code }}" @selected(old('country') == $code)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <i class="bi bi-globe2 absolute left-3 top-4 text-muted-foreground transition-colors peer-focus:text-primary"
                                aria-hidden="true"></i>
                            <label for="register-country"
                                class="absolute left-10 top-2 text-xs text-muted-foreground transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-placeholder-shown:text-muted-foreground peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary">
                                Country
                            </label>
                            <!-- custom arrow for select -->
                            <i class="bi bi-chevron-down absolute right-3 top-4 text-muted-foreground pointer-events-none"
                                aria-hidden="true"></i>
                        </div>
                        <x-input-error :messages="$errors->get('country')" class="mt-1" />

                        <!-- Phone -->
                        <div class="relative">
                            <x-text-input id="register-phone"
                                class="peer mt-0 w-full pl-10 pt-5 pb-2 bg-input border-border focus:border-primary focus:ring-primary"
                                type="tel" name="phone" required autocomplete="tel" placeholder=" " />
                            <i class="bi bi-telephone absolute left-3 top-4 text-muted-foreground transition-colors peer-focus:text-primary"
                                aria-hidden="true"></i>
                            <label for="register-phone"
                                class="absolute left-10 top-2 text-xs text-muted-foreground transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-placeholder-shown:text-muted-foreground peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary">
                                Phone number
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('phone')" class="mt-1" />

                        <!-- Email -->
                        <div class="relative">
                            <x-text-input id="register-email"
                                class="peer mt-0 w-full pl-10 pt-5 pb-2 bg-input border-border focus:border-primary focus:ring-primary"
                                type="email" name="email" required autocomplete="email" placeholder=" " />
                            <i class="bi bi-envelope absolute left-3 top-4 text-muted-foreground transition-colors peer-focus:text-primary"
                                aria-hidden="true"></i>
                            <label for="register-email"
                                class="absolute left-10 top-2 text-xs text-muted-foreground transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-placeholder-shown:text-muted-foreground peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary">
                                Email address
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <!-- ===== Section: Security ===== -->
                    <div class="space-y-4">
                        <p
                            class="text-xs font-semibold uppercase tracking-wider text-muted-foreground border-b border-border/50 pb-1">
                            Security</p>

                        <!-- Password with strength meter -->
                        <div class="relative">
                            <x-text-input id="register-password"
                                class="peer mt-0 w-full pl-10 pr-10 pt-5 pb-2 bg-input border-border focus:border-primary focus:ring-primary"
                                x-bind:type="showPassword ? 'text' : 'password'" name="password" required
                                autocomplete="new-password" x-model="password" @input="getStrength(password)"
                                placeholder=" " />
                            <i class="bi bi-lock absolute left-3 top-4 text-muted-foreground transition-colors peer-focus:text-primary"
                                aria-hidden="true"></i>
                            <label for="register-password"
                                class="absolute left-10 top-2 text-xs text-muted-foreground transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-placeholder-shown:text-muted-foreground peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary">
                                Password
                            </label>
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 px-3 text-muted-foreground hover:text-foreground focus:outline-2 focus:outline-offset-2 focus:outline-primary"
                                :aria-label="showPassword ? 'Hide password' : 'Show password'">
                                <i class="bi text-lg" :class="showPassword ? 'bi-eye-slash' : 'bi-eye'"
                                    aria-hidden="true"></i>
                            </button>
                        </div>
                        <!-- Strength meter -->
                        <div class="flex gap-1 mt-1" x-show="password.length > 0">
                            <div class="h-1 flex-1 rounded-full"
                                :class="passwordStrength >= 1 ? 'bg-destructive' : 'bg-border'"></div>
                            <div class="h-1 flex-1 rounded-full"
                                :class="passwordStrength >= 2 ? 'bg-chart-3' : 'bg-border'"></div>
                            <div class="h-1 flex-1 rounded-full"
                                :class="passwordStrength >= 3 ? 'bg-chart-3' : 'bg-border'"></div>
                            <div class="h-1 flex-1 rounded-full"
                                :class="passwordStrength >= 4 ? 'bg-accent' : 'bg-border'"></div>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />

                        <!-- Confirm Password -->
                        <div class="relative">
                            <x-text-input id="register-password_confirmation"
                                class="peer mt-0 w-full pl-10 pr-10 pt-5 pb-2 bg-input border-border focus:border-primary focus:ring-primary"
                                x-bind:type="showPassword ? 'text' : 'password'" name="password_confirmation" required
                                autocomplete="new-password" placeholder=" " />
                            <i class="bi bi-lock absolute left-3 top-4 text-muted-foreground transition-colors peer-focus:text-primary"
                                aria-hidden="true"></i>
                            <label for="register-password_confirmation"
                                class="absolute left-10 top-2 text-xs text-muted-foreground transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-placeholder-shown:text-muted-foreground peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary">
                                Confirm Password
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                    </div>

                    <!-- Register button (around line 228) -->
                    <x-primary-button class="w-full justify-center mt-6 py-3 text-base relative"
                        x-bind:disabled="submitting">
                        <span x-show="!submitting">
                            <i class="bi bi-person-plus mr-2" aria-hidden="true"></i>
                            Register
                        </span>
                        <span x-show="submitting" class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            Creating account…
                        </span>
                    </x-primary-button>
                </form>

                <p class="text-center text-sm text-muted-foreground mt-5">
                    Already have an account?
                    <a href="{{ route('login') }}"
                        class="text-primary font-medium hover:underline focus:outline-2 focus:outline-offset-2 focus:outline-primary">
                        Sign in
                    </a>
                </p>
            </div>

            <!-- ========== LOGIN FORM ========== -->
            <div x-show="active === 'login'" x-transition x-cloak role="tabpanel" aria-labelledby="login-tab">

                <header class="text-center mb-8">
                    <h2 class="text-2xl font-semibold text-foreground">
                        <i class="bi bi-box-arrow-in-right mr-1" aria-hidden="true"></i>
                        Welcome Back
                    </h2>
                    <p class="text-sm text-muted-foreground mt-2">Sign in to your {{ config('app.name') }} dashboard.
                    </p>
                </header>

                <form method="POST" action="{{ route('login.store') }}" class="space-y-5" novalidate
                    @submit.prevent="submitting = true; $el.submit()">
                    @csrf

                    <!-- Credential (floating label) -->
                    <div class="relative">
                        <x-text-input id="login-credential"
                            class="peer mt-0 w-full pl-10 pt-5 pb-2 bg-input border-border focus:border-primary focus:ring-primary"
                            type="text" name="credential" required autofocus autocomplete="username" placeholder=" " />
                        <i class="bi bi-person-badge absolute left-3 top-4 text-muted-foreground transition-colors peer-focus:text-primary"
                            aria-hidden="true"></i>
                        <label for="login-credential"
                            class="absolute left-10 top-2 text-xs text-muted-foreground transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-placeholder-shown:text-muted-foreground peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary">
                            Username, phone or email
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('credential')" class="mt-1" />

                    <!-- Password (floating label) -->
                    <div class="relative">
                        <x-text-input id="login-password"
                            class="peer mt-0 w-full pl-10 pr-10 pt-5 pb-2 bg-input border-border focus:border-primary focus:ring-primary"
                            x-bind:type="showPassword ? 'text' : 'password'" name="password" required
                            autocomplete="current-password" placeholder=" " />
                        <i class="bi bi-lock-fill absolute left-3 top-4 text-muted-foreground transition-colors peer-focus:text-primary"
                            aria-hidden="true"></i>
                        <label for="login-password"
                            class="absolute left-10 top-2 text-xs text-muted-foreground transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-placeholder-shown:text-muted-foreground peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary">
                            Password
                        </label>
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 px-3 text-muted-foreground hover:text-foreground focus:outline-2 focus:outline-offset-2 focus:outline-primary"
                            :aria-label="showPassword ? 'Hide password' : 'Show password'">
                            <i class="bi text-lg" :class="showPassword ? 'bi-eye-slash' : 'bi-eye'"
                                aria-hidden="true"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />

                    <!-- Remember + Forgot -->
                    <div class="flex items-center justify-between mt-3">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember"
                                class="rounded border-border bg-background text-primary focus:ring-primary">
                            <span class="text-sm text-muted-foreground">Remember me</span>
                        </label>
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-primary hover:underline focus:outline-2 focus:outline-offset-2 focus:outline-primary">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Login button -->
                    <x-primary-button class="w-full justify-center py-3 text-base relative mt-4"
                        x-bind:disabled="submitting">
                        <span x-show="!submitting">
                            <i class="bi bi-box-arrow-in-right mr-2" aria-hidden="true"></i>
                            Log in
                        </span>
                        <span x-show="submitting" class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            Signing in…
                        </span>
                    </x-primary-button>
                </form>
            </div>

        </div><!-- end card -->
    </div>
</x-guest-layout>