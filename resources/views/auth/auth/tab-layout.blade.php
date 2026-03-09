<x-guest-layout>
    <div x-data="{
        active: '{{ request()->routeIs('register') ? 'register' : 'login' }}',
        vertical: false
    }" class="max-w-lg mx-auto mt-10 w-full">
        <!-- Tabs -->
        <div class="flex border-b border-border mb-6">
            <!-- Register -->
            <button @click="active = 'register'; window.history.pushState({}, '', '{{ route('register') }}')"
                class="relative w-1/2 py-3 text-center font-medium transition text-sm flex items-center justify-center gap-2"
                :class="active === 'register'
                    ?
                    'text-foreground' :
                    'text-muted-foreground hover:text-foreground'">

                <i class="bi bi-person-plus-fill text-lg"></i>
                Register

                <!-- Active underline -->
                <span class="absolute bottom-0 left-0 h-0.5 bg-primary transition-all duration-300"
                    :class="active === 'register' ? 'w-full' : 'w-0'">
                </span>
            </button>

            <!-- Login -->
            <button @click="active = 'login'; window.history.pushState({}, '', '{{ route('login') }}')"
                class="relative w-1/2 py-3 text-center font-medium transition text-sm flex items-center justify-center gap-2"
                :class="active === 'login'
                    ?
                    'text-foreground' :
                    'text-muted-foreground hover:text-foreground'">

                <i class="bi bi-box-arrow-in-right text-lg"></i>
                Login

                <span class="absolute bottom-0 left-0 h-0.5 bg-primary transition-all duration-300"
                    :class="active === 'login' ? 'w-full' : 'w-0'">
                </span>
            </button>

        </div>

        <!-- Card -->
        <div class="bg-card border border-border rounded-xl shadow-sm p-6">

            <!-- Register -->
            <div x-show="active === 'register'" x-transition>

                <div class="text-center mb-8">
                    <h1 class="text-2xl font-semibold text-foreground">
                        <i class="bi bi-person-plus-fill mr-1"></i> Create an Account
                    </h1>
                    <p class="text-sm text-muted-foreground mt-2">
                        Join us and explore all premium features.
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <div class="relative">
                            <i class="bi bi-person absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground"></i>
                            <x-text-input id="name" class="mt-1 w-full pl-10" type="text" name="name"
                                required autofocus />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Username -->
                    <div>
                        <x-input-label for="username" :value="__('Username')" />
                        <div class="relative">
                            <i class="bi bi-at absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground"></i>
                            <x-text-input id="username" class="mt-1 w-full pl-10" type="text" name="username"
                                required />
                        </div>
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>

                    <!-- Country -->
                    <div>
                        <x-input-label for="country" :value="__('Country')" />
                        <div class="relative">
                            <i class="bi bi-globe2 absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground"></i>
                            <select id="country" name="country"
                                class="block w-full mt-1 pl-10 rounded-md bg-background border-border text-foreground">
                                <option value="">Select Country</option>
                                @foreach (['US' => 'United States', 'UK' => 'United Kingdom', 'CA' => 'Canada', 'NG' => 'Nigeria', 'KE' => 'Kenya', 'GH' => 'Ghana', 'IN' => 'India', 'PH' => 'Philippines'] as $code => $label)
                                    <option value="{{ $code }}" @selected(old('country') == $code)>{{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <x-input-error :messages="$errors->get('country')" class="mt-2" />
                    </div>

                    <!-- Phone -->
                    <div>
                        <x-input-label for="phone" :value="__('Phone')" />
                        <div class="relative">
                            <i
                                class="bi bi-telephone absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground"></i>
                            <x-text-input id="phone" class="mt-1 w-full pl-10" type="tel" name="phone"
                                required />
                        </div>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <div class="relative">
                            <i
                                class="bi bi-envelope absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground"></i>
                            <x-text-input id="email" class="mt-1 w-full pl-10" type="email" name="email"
                                required />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password + Confirm -->
                    <div x-data="{ show: false }">

                        @foreach (['password' => 'Password', 'password_confirmation' => 'Confirm Password'] as $name => $label)
                            <div class="mt-3">
                                <x-input-label :for="$name" :value="$label" />

                                <div class="relative">
                                    <i
                                        class="bi bi-lock absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground"></i>

                                    <x-text-input :id="$name" class="mt-1 w-full pl-10 pr-10"
                                        x-bind:type="show ? 'text' : 'password'" name="{{ $name }}" required />

                                    <button type="button" @click="show = !show"
                                        class="absolute inset-y-0 right-0 px-3 text-muted-foreground hover:text-foreground">
                                        <i class="bi" :class="show ? 'bi-eye-slash' : 'bi-eye'"></i>
                                    </button>
                                </div>

                                <x-input-error :messages="$errors->get($name)" class="mt-2" />
                            </div>
                        @endforeach
                    </div>

                    <!-- Register button -->
                    <x-primary-button class="w-full justify-center mt-6">
                        <i class="bi bi-person-plus mr-2"></i>
                        {{ __('Register') }}
                    </x-primary-button>

                </form>

                <p class="text-center text-sm text-muted-foreground mt-5">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-primary font-medium">Sign In</a>
                </p>
            </div>

            <!-- Login -->
            <div x-show="active === 'login'" x-transition x-cloak>

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Credential -->
                    <div>
                        <x-input-label for="credential" :value="__('Username / Phone / Email')" />
                        <div class="relative">
                            <i
                                class="bi bi-person-badge absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground"></i>
                            <x-text-input id="credential" class="mt-1 w-full pl-10" type="text" name="credential"
                                required />
                        </div>
                        <x-input-error :messages="$errors->get('credential')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <div class="relative">
                            <i
                                class="bi bi-lock-fill absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground"></i>
                            <x-text-input id="password" class="mt-1 w-full pl-10" type="password" name="password"
                                required />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember -->
                    <label class="flex items-center gap-2 mt-3">
                        <input type="checkbox" name="remember" class="rounded-sm border-border bg-background">
                        <span class="text-sm text-muted-foreground">Remember me</span>
                    </label>

                    <!-- Actions -->
                    <div class="flex justify-between items-center">
                        <a href="{{ route('password.request') }}" class="text-sm text-primary hover:underline">
                            Forgot password?
                        </a>

                        <x-primary-button>
                            <i class="bi bi-box-arrow-in-right mr-2"></i>
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
